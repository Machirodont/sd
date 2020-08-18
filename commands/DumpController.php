<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DumpController extends Controller
{

    public function actionSaveStatic()
    {
        if (preg_match('/dbname=([^;]*)/', \Yii::$app->db->dsn, $match)) {
            $dbname = $match[1];
            $dbuser = \Yii::$app->db->username;
            $dbpass = \Yii::$app->db->password;
            echo "\n";
            shell_exec("del static.sql");
            echo "\n";
            $cmd = "mysqldump --complete-insert --quote-names -u " . $dbuser . " -p" . $dbpass . " " . $dbname;
            $cmd .= "  sd_clinics";
            $cmd .= "  sd_html_block";
            $cmd .= "  sd_institutions";
            $cmd .= "  sd_pages";
            $cmd .= "  sd_persons";
            $cmd .= "  sd_promo";
            $cmd .= "  sd_redirect";
            $cmd .= "  sd_traits";
            $cmd .= "  sd_url_tags";
            $cmd .= " > static.sql";
            shell_exec($cmd);
        } else {
            echo "Error: can't get DB name: p." . __LINE__ . " f." . __FILE__;
            return ExitCode::DATAERR;
        }
        return ExitCode::OK;
    }

    public function actionSaveGenerated()
    {
        if (preg_match('/dbname=([^;]*)/', \Yii::$app->db->dsn, $match)) {
            $dbname = $match[1];
            $dbuser = \Yii::$app->db->username;
            $dbpass = \Yii::$app->db->password;
            echo "\n";
            shell_exec("del generated.sql");
            echo "\n";
            $cmd = "mysqldump --no-data --complete-insert --quote-names -u " . $dbuser . " -p" . $dbpass . " " . $dbname;
            $cmd .= "  sd_hit_counter";
            $cmd .= "  sd_loaded_schedules";
            $cmd .= "  sd_price_group";
            $cmd .= "  sd_price_group_index";
            $cmd .= "  sd_price_items";
            $cmd .= "  sd_price_local";
            $cmd .= "  sd_shedule_assign";
            $cmd .= "  sd_timelines";
            $cmd .= "  sd_timeline_cells";
            $cmd .= "  sd_timeline_changelog";
            $cmd .= "  sd_timeline_days";
            $cmd .= "  sd_workplaces";
            $cmd .= " > generated.sql";
            shell_exec($cmd);
            $sql = file_get_contents("generated.sql");
            $sql = mb_ereg_replace("AUTO_INCREMENT=[0-9]+", "", $sql);
            file_put_contents("generated.sql", $sql);
        } else {
            echo "Error: can't get DB name: p." . __LINE__ . " f." . __FILE__;
            return ExitCode::DATAERR;
        }
        return ExitCode::OK;
    }

    public function actionLoadStatic()
    {
        if (preg_match('/dbname=([^;]*)/', \Yii::$app->db->dsn, $match)) {
            $dbname = $match[1];
            $dbuser = \Yii::$app->db->username;
            $dbpass = \Yii::$app->db->password;
            if (!file_exists("static.sql")) {
                echo "Error: dump file isn't exists (sql.sql)";
                return ExitCode::DATAERR;
            }
            echo "\n";
//            \Yii::$app->db->createCommand("DROP DATABASE IF EXISTS $dbname;")->execute();
//            \Yii::$app->db->createCommand("CREATE DATABASE $dbname CHARACTER SET utf8 COLLATE utf8_general_ci;")->execute();
            shell_exec("mysql -u " . $dbuser . " -p" . $dbpass . " " . $dbname . " < static.sql");
        } else {
            echo "Error: can't get DB name: p." . __LINE__ . " f." . __FILE__;
            return ExitCode::DATAERR;
        }
        return ExitCode::OK;
    }

    public function actionClearGenerated()
    {
        if (preg_match('/dbname=([^;]*)/', \Yii::$app->db->dsn, $match)) {
            $dbname = $match[1];
            $dbuser = \Yii::$app->db->username;
            $dbpass = \Yii::$app->db->password;
            if (!file_exists("generated.sql")) {
                echo "Error: dump file isn't exists (sql.sql)";
                return ExitCode::DATAERR;
            }
            echo "\n";
            shell_exec("mysql -u " . $dbuser . " -p" . $dbpass . " " . $dbname . " < generated.sql");
        } else {
            echo "Error: can't get DB name: p." . __LINE__ . " f." . __FILE__;
            return ExitCode::DATAERR;
        }
        return ExitCode::OK;
    }

}
