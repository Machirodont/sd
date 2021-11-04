<?php


namespace app\components\actions;


use app\helpers\Extra;
use app\models\Clinic;
use app\models\Persons;
use app\models\Promo;
use Yii;
use yii\base\Action;
use yii\helpers\Html;

class LoadScheduleAction extends Action
{
    public function run($code)
    {
        if ($code !== Yii::$app->params['scheduleEndpointCode']) {
            Extra::writeLog("ERROR: wrong GET code");
            return 'FALSE';
        }

        $postRaw = file_get_contents("php://input");
        if ($postRaw === false) {
            Extra::writeLog("ERROR: wrong php://input");
            return 'FALSE';
        }

        try {
            $postDecompressStr = gzdecode($postRaw);
        } catch (\Exception $e) {
            Extra::writeLog("ERROR: GZip exception " . $e->getCode());
            return 'FALSE';
        }

        if ($postDecompressStr === false) {
            Extra::writeLog("ERROR: GZip (false returned)");
            return 'FALSE';
        }
        $postData = array();
        parse_str($postDecompressStr, $postData);

        if (!array_key_exists('json', $postData)) {
            Extra::writeLog("ERROR: no json key in URL data");
            return 'FALSE';
        }

        $json = json_decode($postData['json'], true);
        if (!is_array($json)) {
            Extra::writeLog("ERROR: data is not json");
            return 'FALSE';
        }

        $fName = "schedule_" . date("Y-m-d-H-i-s") . ".json";
        $fn_suffix = 1;
        while (file_exists("../data/" . $fName)) {
            $fName = "schedule" . $fn_suffix . "_" . date("Y-m-d-H-i-s") . ".json";
            $fn_suffix++;
        }

        if (!file_put_contents("../data/" . $fName, $postData['json'])) {
            Extra::writeLog("ERROR: can't write file " . $fName);
        }

        Yii::$app->db->createCommand("INSERT INTO sd_loaded_schedules SET fileName=\"" . $fName . "\",  loadTime=\"" . date("Y-m-d H:i:s") . "\"")->execute();

        //Обрабока данных - дергаем через сокет скрипт, который дергает команду Yii (потому что скрипт сдохнет через 30 секунд, а команда отработает сколько надо)
        Extra::socketAsyncCall(["/site/schedule-parse"]);

        return 'TRUE';
    }


}