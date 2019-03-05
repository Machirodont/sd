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

    public function actionSave()
    {
        if (preg_match('/dbname=([^;]*)/', \Yii::$app->db->dsn, $match)) {
            $dbname = $match[1];
            $dbuser = \Yii::$app->db->username;
            $dbpass = \Yii::$app->db->password;
            echo "\n";
            shell_exec("del sql.sql");
            echo "\n";
            shell_exec("mysqldump -c -Q -u " . $dbuser . " -p" . $dbpass . " " . $dbname . " > sql.sql");
        } else {
            echo "Error: can't get DB name: p." . __LINE__ . " f." . __FILE__;
            return ExitCode::DATAERR;
        }
        return ExitCode::OK;
    }


    public function actionLoad()
    {
        if (preg_match('/dbname=([^;]*)/', \Yii::$app->db->dsn, $match)) {
            $dbname = $match[1];
            $dbuser = \Yii::$app->db->username;
            $dbpass = \Yii::$app->db->password;
            if (!file_exists("sql.sql")) {
                echo "Error: dump file isn't exists (sql.sql)";
                return ExitCode::DATAERR;
            }
            echo "\n";
            \Yii::$app->db->createCommand("DROP DATABASE IF EXISTS $dbname;")->execute();
            \Yii::$app->db->createCommand("CREATE DATABASE $dbname CHARACTER SET utf8 COLLATE utf8_general_ci;")->execute();
            shell_exec("mysql -u " . $dbuser . " -p" . $dbpass . " " . $dbname . " < sql.sql");
        } else {
            echo "Error: can't get DB name: p." . __LINE__ . " f." . __FILE__;
            return ExitCode::DATAERR;
        }
        return ExitCode::OK;
    }
}
