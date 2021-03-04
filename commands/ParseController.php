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
use app\models\TimelineCells;
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
            echo $arr[$i]["code"] . "\n";
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

    public function actionClearOldSchedules()
    {
        $lastLoadedFile = (new Query())->select("*")
            ->from("sd_loaded_schedules")
            ->orderBy(["loadTime" => SORT_DESC])
            ->limit(1)
            ->all();
        if (count($lastLoadedFile) !== 1) return 0;
        $lastLoadingTime = $lastLoadedFile[0]["loadTime"];

        $files = (new Query())->select("*")
            ->from("sd_loaded_schedules")
            ->where("loadTime < DATE_SUB(\"" . $lastLoadingTime . "\", INTERVAL 1 DAY)")
            ->orderBy(["loadTime" => SORT_ASC])
            ->all();
        echo count($files) . "\n";
        foreach ($files as $f) {
            $fName = __DIR__ . "/../data/" . $f["fileName"];
            \Yii::$app->db->createCommand("DELETE FROM sd_loaded_schedules WHERE fileName=\"" . $f["fileName"] . "\" ")->execute();
            if (file_exists($fName)) unlink($fName);
            echo $f["fileName"] . "\n";
        }

        \Yii::$app->db->createCommand("DELETE FROM sd_timeline_days WHERE day< DATE_SUB(\"" . date("Y-m-d") . "\", INTERVAL 4 DAY)")->execute();
        return 0;
    }

    public function actionResetSchedule()
    {
        \Yii::$app->db->createCommand("DELETE FROM sd_loaded_schedules")->execute();
        \Yii::$app->db->createCommand("ALTER TABLE `sd_loaded_schedules` AUTO_INCREMENT=0;")->execute();
        \Yii::$app->db->createCommand("DELETE FROM sd_timeline_days")->execute();
        \Yii::$app->db->createCommand("ALTER TABLE `sd_timeline_days` AUTO_INCREMENT=0;")->execute();
        \Yii::$app->db->createCommand("DELETE FROM sd_timeline_cells")->execute();
        \Yii::$app->db->createCommand("ALTER TABLE `sd_timeline_cells` AUTO_INCREMENT=0;")->execute();
        \Yii::$app->db->createCommand("DELETE FROM sd_timeline_changelog")->execute();
        \Yii::$app->db->createCommand("ALTER TABLE `sd_timeline_changelog` AUTO_INCREMENT=0;")->execute();
        \Yii::$app->db->createCommand("DELETE FROM sd_timelines")->execute();
        \Yii::$app->db->createCommand("ALTER TABLE `sd_timelines` AUTO_INCREMENT=0;")->execute();
        \Yii::$app->db->createCommand("DELETE FROM sd_workplaces")->execute();
        \Yii::$app->db->createCommand("ALTER TABLE `sd_workplaces` AUTO_INCREMENT=0;")->execute();
    }

    public function actionScheduleList()
    {
        $files = glob(__DIR__ . "/../data/schedule_*.json");
        echo count($files);
        $t = microtime(true);
        $inserts = [];
        foreach ($files as $file) {
            echo basename($file);
            $s = json_decode(file_get_contents($file));
            $fileLoadDateTime = $s->time;
            echo " > " . $fileLoadDateTime . "\n";
            $inserts[] = [basename($file), $fileLoadDateTime];
            if (count($inserts) > 30) {
                \Yii::$app->db->createCommand()->batchInsert('sd_loaded_schedules', ["fileName", "loadTime"], $inserts)->execute();
                $inserts = [];
            }

        }
        \Yii::$app->db->createCommand()->batchInsert('sd_loaded_schedules', ["fileName", "loadTime"], $inserts)->execute();
        echo microtime(true) - $t;
    }

    /** 252 сек
     *
     * @return int
     * @throws \yii\db\Exception
     */
    public function actionSchedules()
    {
        $stopParsingFile = __DIR__ . "/../stage/" . "stop_parsing.txt";
        if (file_exists($stopParsingFile) && file_get_contents($stopParsingFile)) {
            echo "Уберите файл stop_parsing.txt";
            return;
        }

        $lockfile = __DIR__ . "/../stage/" . "lockfile-parse-schedules.txt";
        if (file_exists($lockfile)) exit;
        file_put_contents($lockfile, getmypid(), LOCK_EX);
        if (file_get_contents($lockfile) != getmypid()) {
            echo "Уже выполняется";
            exit;
        }

        /*
SELECT tch.*, tc.start, tl.person_id, p.lastname, lsh.loadTime, cl.city FROM sd_timeline_changelog AS tch
LEFT JOIN sd_timeline_cells AS tc ON tch.cellId=tc.id
LEFT JOIN sd_timelines AS tl ON tc.timelineId=tl.id
LEFT JOIN sd_persons AS p ON tl.person_id=p.person_id
LEFT JOIN sd_loaded_schedules AS lsh ON lsh.fileName=tc.source
LEFT JOIN sd_workplaces AS wp ON tl.workplace_hash=wp.workplace_hash
LEFT JOIN sd_clinics AS cl ON wp.clinic_hash=cl.hash_id
         */
        $files = (new Query())->select("fileName")
            ->from("sd_loaded_schedules")
            ->where(["parsed" => 0])
            ->orderBy(["loadTime" => SORT_ASC])
            ->all();
        if (count($files) === 0) {
            echo "Парсить нечего";
            return 0;
        }

        $log = "";
        $t = microtime(true);
        foreach ($files as $f) {
            $fName = $f["fileName"];

            echo $fName . "\n";
            Extra::writeLog("Парсим файл " . $fName);
            if (!file_exists(__DIR__ . "/../data/" . $fName)) {
                Extra::writeLog("Не найден файл " . $fName);
                echo "Ошибка файла";
                return 0;
            }
            $s = json_decode(file_get_contents(__DIR__ . "/../data/" . $fName));

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
                                if (!$d && $day_is_active) {
                                    $d = new TimelineDays(["timelineId" => $tl->id, "day" => $date]);
                                }
                                if ($d) {
                                    if ($d->is_active !== intval($day_is_active)) {
                                        echo $d->isNewRecord ? "NEW DAY\n" : "REFRESH DAY\n";
                                    }
                                    $d->is_active = intval($day_is_active);
                                    $d->save();
                                    //ToDo - проверка и реакция, если сохранение не прошло
                                    echo "day " . $date . " - " . ($day_is_active ? "+" : " ") . " - " . $schedule->name . " / " . $subdiv->name . ";\n";
                                }
                            }

                            $inserts = [];
                            foreach ($schedule->cells as $cell) {

                                $startText = $cell->date . " " . $cell->time_start . ":00";
                                $endText = $cell->date . " " . $cell->time_end . ":00";
                                $tCell = TimelineCells::findOne(["timelineId" => $tl->id, "start" => $startText, "end" => $endText]);

                                if (!$tCell) {
                                    if ($tl->id == 31) $log .= "\nINCOMING: " . $cell->date . "  " . $cell->time_start . "  " . $cell->time_end . " " . $cell->free . " \n";
                                    $intersectCondition = ["and",
                                        ["timelineId" => $tl->id],
                                        ["not",
                                            ["or",
                                                ["and",
                                                    [">=", "start", $startText],
                                                    [">=", "start", $endText]
                                                ],
                                                ["and",
                                                    ["<=", "end", $startText],
                                                    ["<=", "end", $endText]
                                                ]
                                            ]
                                        ]
                                    ];

                                    $intersectedTCells = TimelineCells::find()->where($intersectCondition)->all();
                                    if ($intersectedTCells) {
                                        if ($tl->id == 31) $log .= "INTERSECT\n";
                                        echo "ПЕРЕСЕЧЕНИЕ " . $tl->id . " " . $startText . " " . $endText . " " . count($intersectedTCells) . "\n";
                                        $newCell = new TimelineCells([
                                            "timelineId" => $tl->id,
                                            "start" => $startText,
                                            "end" => $endText,
                                            "free" => intval($cell->free),
                                            "source" => $fName,
                                        ]);
                                        //Вычисление и обработка пересечений
                                        $oldCellsLog = "[";
                                        $newCellsLog = "[";
                                        foreach ($intersectedTCells as $oldCell) {
                                            /**@var $oldCell \app\models\TimelineCells */
                                            $oldCellsLog .= date("H:i", $oldCell->startT) . " - " . date("H:i", $oldCell->endT) . ";";
                                            if ($oldCell->startT < $newCell->startT) {
                                                $inserts[] = [$tl->id, $oldCell->start, $newCell->start, $oldCell->free, $fName];
                                                $newCellsLog .= $oldCell->start . " - " . $newCell->start . ";";
                                            }
                                            if ($oldCell->endT > $newCell->endT) {
                                                $inserts[] = [$tl->id, $newCell->end, $oldCell->end, $oldCell->free, $fName];
                                                $newCellsLog .= $newCell->end . " - " . $oldCell->end . ";";
                                            }
                                        }
                                        $newCellsLog .= "]\n";
                                        $oldCellsLog .= "]\n";
                                        if ($tl->id == 31) $log .= $oldCellsLog . $newCellsLog;

                                        TimelineCells::deleteAll($intersectCondition);
                                    } else {
                                        if ($tl->id == 31) $log .= "NEW\n";
                                    }
                                    $inserts[] = [$tl->id, $startText, $endText, intval($cell->free), $fName];
                                }

                                if ($tCell && intval($cell->free) !== intval($tCell->free)) {
                                    if ($tl->id == 31) $log .= "\nINCOMING: " . $cell->date . "  " . $cell->time_start . "  " . $cell->time_end . " " . $cell->free . " \n";
                                    if ($tl->id == 31) $log .= "UPDATE\n";
                                    echo "ПЕРЕЗАПИСЬ\n";
                                    $tCell->free = intval($cell->free);
                                    $tCell->source = $fName;
                                    $tCell->save();
                                }
                            }
                            \Yii::$app->db->createCommand()->batchInsert('sd_timeline_cells', ["timelineId", "start", "end", "free", "source"], $inserts)->execute();
                        } else {
                            echo "Отсутствует соответствие: " . $schedule->name . " / " . $schedule_hash . " (" . $subdiv->name . ")\n";
                        }
                    }
                }
            }
            \Yii::$app->db->createCommand("UPDATE sd_loaded_schedules SET  parsed=1 WHERE fileName=\"" . $fName . "\";")->execute();
        }
        unlink($lockfile);
        echo microtime(true) - $t . "\n";
        echo "END\n\n";
        echo $log;
    }


    public function actionGenTags()
    {
        $persons = Persons::find()->where([">", "person_id", 32])->all();
        foreach ($persons as $person) {
            /**@var \app\models\Persons $person */
            $tag = $person->primarySpec . " " . $person->lastname;
            $tag = mb_strtolower($tag);
            $tag = transliterator_transliterate('Russian-Latin/BGN', $tag);
            $tag = str_replace(" ", "-", $tag);
            $tag = preg_replace("|[^a-z\\-]|", "", $tag);
            /*
            \Yii::$app->db->createCommand()->insert("sd_url_tags", [
                'tag' => $tag,
                'param' => 'id',
                'value' => $person->person_id,
                'route' => 'persons/view'
            ])->execute();*/
        }
    }
}