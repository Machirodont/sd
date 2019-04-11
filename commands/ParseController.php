<?php
/**
 * Created by PhpStorm.
 * User: a.ivanitsky
 * Date: 01.04.2019
 * Time: 12:24
 */

namespace app\commands;


use app\helpers\Extra;
use app\models\Clinic;
use yii\console\Controller;
use app\models\PriceGroup;
use app\models\PriceItems;
use yii\db\Query;
use app\models\Workplaces;
use app\models\Persons;
use app\models\TimeLines;
use app\models\TimelineDays;

class ParseController extends Controller
{
    public function actionTest()
    {
        echo "start\n";
        for ($i = 0; $i < 60; $i++) {
            sleep(1);
            echo ($i + 1) . "\n";
        }
        echo "end\n";
    }

    public function actionPrice()
    {
        $clinicId = [
            "Гагарин" => 5,
            "Руза" => 2,
            "Тучково" => 1,
        ];

        echo "\n";
        $fName = __DIR__ . "/../data/gz_tmp.gz";
        if (!file_exists($fName)) {
            echo "File not found\n";
            echo __DIR__;
            exit;
        }
        $zp = gzopen($fName, "r");
        $data_links = gzread($zp, 10000000);
        gzclose($zp);
        $arr = json_decode($data_links, true);
        $arrCount = count($arr);

        \Yii::$app->db->createCommand("UPDATE sd_price_group SET removed=\"" . date("Y-m-d H-i-s") . "\"")->execute();
        \Yii::$app->db->createCommand("UPDATE sd_price_items SET removed=\"" . date("Y-m-d H-i-s") . "\"")->execute();
        \Yii::$app->db->createCommand("DELETE FROM sd_price_local")->execute();
        \Yii::$app->db->createCommand("ALTER TABLE `sd_price_local` 	AUTO_INCREMENT=0;")->execute();
        $sqlStackCount = 0;
        $sql = "";
        for ($i = 0; $i < count($arr); $i++) {
           // echo round(100 * ($i + 1) / $arrCount) . "% (" . ($i + 1) . ")              \r";
            $parentId = null;
            for ($i1 = 0; $i1 < count($arr[$i]["group"]); $i1++) {
                $grName = $arr[$i]["group"][$i1];
                $group = PriceGroup::findOne(["groupName" => $grName, "parentId" => $parentId]);
                if (!$group) $group = new PriceGroup(["groupName" => $grName, "parentId" => $parentId]);
                $group->removed = null;
                $group->save();
                $parentId = $group->id;
            }


            $priceItem = PriceItems::findOne(["code" => $arr[$i]["code"]]);

            if (!$priceItem) {
                $priceItem = new PriceItems([
                    "code" => $arr[$i]["code"],
                ]);
            }

            $priceItem->setAttributes([
                "name" => $arr[$i]["name"],
                "item_type" => $arr[$i]["type"],
                "global_price" => $arr[$i]["price"],
                "info" => (array_key_exists("info", $arr[$i])) ? $arr[$i]["info"] : null,
                "groupId" => $parentId,
                "removed" => null,
            ]);
            $priceItem->save();

            $itemId = $priceItem->id;
            echo $arr[$i]["code"]."\n";
            foreach ($arr[$i]["price_list"] as $clinicName => $price) {
                if (array_key_exists($clinicName, $clinicId) && ((float)$price) > 0) {
                     $sql .= "INSERT INTO sd_price_local SET itemId=" . $itemId . ", clinicId=" . $clinicId[$clinicName] . ", price=\"" . ((float)$price) . "\";";
                    $sqlStackCount++;
                }
            }
            if ($sqlStackCount > 20) {
                \Yii::$app->db->createCommand($sql)->execute();
                $sqlStackCount = 0;
                $sql = "";
            }
        }
        exit;
    }

    public function actionIndexGroups()
    {
        $groups = PriceGroup::find()->all();

    }

    public function actionScheduleList()
    {
        $files = glob("./data/schedule_*.json");
        echo count($files);
        foreach ($files as $file) {
            echo basename($file) . "  >  " . date("Y-m-d H-i-s", filemtime($file));
            echo "\n";
            \Yii::$app->db->createCommand("INSERT INTO sd_loaded_schedules SET fileName=\"" . basename($file) . "\",  loadTime=\"" . date("Y-m-d H-i-s", filemtime($file)) . "\" ")->execute();
        }

    }

    public function actionSchedules()
    {
        $files = (new Query())->select("fileName")
            ->from("sd_loaded_schedules")
            ->where(["parsed" => 0])
            ->orderBy(["loadTime" => SORT_ASC])
            ->all();
        if (count($files) === 0) return "Парсить нечего";

        foreach ($files as $f) {
            $fName = $f["fileName"];

            echo $fName . "\n";
            Extra::writeLog("Парсим файл ".$fName);
            if (!file_exists("../data/" . $fName)){
                Extra::writeLog("Не найден файл ".$fName);
                return "Ошибка файла";
            }
            $s = json_decode(file_get_contents("../data/" . $fName));

            foreach ($s->subdivisions as $subdiv_hash => $subdiv) {

                $clinic = Clinic::findOne(["hash_id" => $subdiv_hash]);
                if (!$clinic) echo "Неизвестная клиника " . $subdiv->name . " " . $subdiv_hash . "\n";

                foreach ($subdiv->workplaces as $workplace_hash => $workplace) {

                    //Добавляем в sd_workplaces новый Workplace, если его там еще нет
                    if (!Workplaces::findByHash($workplace_hash)) {
                        $w = new Workplaces([
                            "workplace_hash" => $workplace_hash,
                            "clinic_hash" => $subdiv_hash
                        ]);
                        $w->save();
                        echo "new Workplace " . $workplace->name . "\n";
                        //ToDo - проверка и реакция, если сохранение не прошло
                    }

                    foreach ($workplace->schedules as $schedule_hash => $schedule) {
                        $person = Persons::findBySheduleHash($schedule_hash);

                        if (!$person) { //Сопоставление персон из базы и из выгрузки по ФИО. (основное сопоставление идет по sd_shedule_assign)
                            $match = [];
                            $personName = $schedule->name;
                            if (preg_match("|(\S+?)\s|", $personName, $match) !== false) {
                                if (mb_strlen($personName) > mb_strlen($match[0]) + 2) {
                                    $firstNameStart = mb_substr($personName, mb_strlen($match[0]), 1);
                                    $patronymStart = mb_substr($personName, mb_strlen($match[0]) + 2, 1);
                                    $r = Persons::find()->where(["and",
                                        ["lastname" => $match[1]],
                                        ["like", "firstname", $firstNameStart],
                                        ["like", "patronymic", $patronymStart],
                                    ])->all();
                                    if (count($r) === 1) $person = $r[0];
                                    if ($person) {
                                        echo $schedule->name . " -> " . $person->fullname . "\n";
                                        \Yii::$app->db->createCommand("INSERT INTO sd_shedule_assign SET personId=" . $person->person_id . ", shedule_hash=\"" . $schedule_hash . "\" , schedule_fio=\"" . $personName . "\" ")->execute();
                                        $person = Persons::findBySheduleHash($schedule_hash);
                                    }
                                }
                            }
                        }

                        if ($person) {
                            $person_id = $person->person_id;

                            //Добавляем в sd_timelines новый Timeline, если его там еще нет
                            $tl = TimeLines::findOne(["workplace_hash" => $workplace_hash, "person_id" => $person_id]);
                            if (!$tl) {
                                $tl = new TimeLines(["workplace_hash" => $workplace_hash, "person_id" => $person_id]);
                                $tl->save();
                                echo "new Timeline " . $workplace->name . " / " . $person_id . "\n";
                                //ToDo - проверка и реакция, если сохранение не прошло
                            }

                            foreach ($schedule->days_active as $date => $day_is_active) {
                                $d = TimelineDays::findOne(["timelineId" => $tl->id, "day" => $date]);
                                if (!$d) {
                                    $d = new TimelineDays(["timelineId" => $tl->id, "day" => $date]);
                                }
                                $d->is_active = intval($day_is_active);
                                $d->save();
                                echo "day " . $date . " - " . ($day_is_active ? "+" : " ") . " - " . $schedule->name . " / " . $subdiv->name . ";\n";
                                //ToDo - проверка и реакция, если сохранение не прошло
                            }
                        } else {
                            echo "Отсутствует соответствие: " . $schedule->name . " / " . $schedule_hash . " (" . $subdiv->name . ")\n";
                        }
                    }
                }
            }
            \Yii::$app->db->createCommand("UPDATE sd_loaded_schedules SET  parsed=1 WHERE fileName=\"" . $fName . "\";")->execute();
        }
        echo "END\n";
    }

}