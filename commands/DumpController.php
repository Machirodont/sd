<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class DumpController extends Controller
{

    private const DUMP_FILE_STATIC = "install_data/sql_seeds/static.sql";
    private const DUMP_FILE_GENERATED = "install_data/sql_seeds/generated.sql";

    public function actionSaveStatic()
    {
        if (preg_match('/dbname=([^;]*)/', Yii::$app->db->dsn, $match)) {
            $dbname = $match[1];
            $dbuser = Yii::$app->db->username;
            $dbpass = Yii::$app->db->password;
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
        if (preg_match('/dbname=([^;]*)/', Yii::$app->db->dsn, $match)) {
            $dbname = $match[1];
            $dbuser = Yii::$app->db->username;
            $dbpass = Yii::$app->db->password;
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
        return $this->loadDump(self::DUMP_FILE_STATIC);
    }

    public function actionClearGenerated()
    {
        return $this->loadDump(self::DUMP_FILE_GENERATED);
    }

    private function loadDump(string $dumpFileName): int
    {
        if (!file_exists($dumpFileName)) {
            echo "Error: dump file isn't exists (" . $dumpFileName . ")";
            return ExitCode::DATAERR;
        }
        if ($command = $this->mysqlLoadDumpCommand($dumpFileName)) {
            shell_exec($command);
        } else {
            echo "Error: can't get DB name: p." . __LINE__ . " f." . __FILE__;
            return ExitCode::DATAERR;
        }
        return ExitCode::OK;
    }

    private function mysqlLoadDumpCommand(string $dumpFileName): string
    {
        if (preg_match('/mysql:host=(.+):([0-9]+);dbname=([^;]*)/', Yii::$app->db->dsn, $match)) {
            $dbHost = $match[1];
            $dbPort = $match[2];
            $dbname = $match[3];
            $dbuser = Yii::$app->db->username;
            $dbpass = Yii::$app->db->password;
            return "mysql "
                . "-h" . $dbHost . " "
                . "-u" . $dbuser . " "
                . "-p" . $dbpass . " "
                . $dbname . " < " . $dumpFileName;
        } else {
            return "";
        }
    }

}
