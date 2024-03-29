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
use app\models\DailyTimeline;
use app\models\TimelineCells;
use Yii;
use yii\console\Controller;
use app\models\PriceGroup;
use app\models\PriceItems;
use yii\db\Query;
use app\models\Workplaces;
use app\models\Persons;
use app\models\TimeLines;
use app\models\TimelineDays;
use yii\helpers\ArrayHelper;

class ParseController extends Controller
{

    public function actionTest()
    {
        Extra::writeLog("Test");
    }

    public function actionPriceLoad()
    {
        Extra::writeLog("parse-controller/price-load");
        $file_path = __DIR__ . "/../data/gz_tmp.gz";
        $time_file = __DIR__ . "/../stage/" . "load_price_time.txt";
        $url = Yii::$app->params['priceSourceUrl'];
        $status = 0;
        if (!file_exists($time_file)) {
            file_put_contents($time_file, 0);
        }
        $last_load_time = intval(file_get_contents($time_file));
        if ((time() - $last_load_time) > (60 * 60 * 24)) {
            Extra::writeLog("Попытка загрузки файла прайса");
            $c = curl_init();
            curl_setopt($c, CURLOPT_URL, $url);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c, CURLOPT_HEADER, true);
            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($c, CURLOPT_SSLVERSION, 3);
            $result = curl_exec($c);
            $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
            $headerSize = curl_getinfo($c, CURLINFO_HEADER_SIZE);
            curl_close($c);
        } else {
            echo "Не время еще";
            exit;
        }
        if ($status == 200) {
            $content_gz = substr($result, $headerSize);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $f = fopen($file_path, 'w');
            if ($f === false) {
                echo "Не могу сохранить загруженный файл";
                exit;
            }
            fwrite($f, $content_gz);
            fclose($f);
            file_put_contents($time_file, time());
        } else {
            Extra::writeLog("Ошибка загрузки файла прайса, ответ " . $status);
            exit;
        }
        echo "Все вроде ок";
        exit;
    }

    public function actionPriceParse()
    {
        Extra::writeLog("parse-controller/price-parse");
        $lockfile = "lockfile-parse-price.txt";
        self::singletonLock($lockfile);

        $load_time_file = __DIR__ . "/../stage/" . "load_price_time.txt";
        $parse_time_file = __DIR__ . "/../stage/" . "parse_price_time.txt";
        $fName = __DIR__ . "/../data/gz_tmp.gz";
        if (!file_exists($load_time_file)) {
            file_put_contents($load_time_file, 0);
        }
        if (!file_exists($parse_time_file)) {
            file_put_contents($parse_time_file, 0);
        }
        $last_load_time = intval(file_get_contents($load_time_file));
        $last_parse_time = intval(file_get_contents($parse_time_file));
        if (($last_parse_time + 30) > $last_load_time) {
            echo "Новый файл не загружался";
            self::singletonUnlock($lockfile);
            exit;
        }

        $clinicList = Clinic::getActiveList();
        $clinicId = ArrayHelper::map($clinicList, "city", "id");

        echo "\n";
        if (!file_exists($fName)) {
            echo "File not found\n";
            self::singletonUnlock($lockfile);
            exit;
        }
        $zp = gzopen($fName, "r");
        $data_links = gzread($zp, 10000000);
        gzclose($zp);
        $arr = json_decode($data_links, true);
        $arrCount = count($arr);

        Yii::$app->db->createCommand("UPDATE sd_price_group SET removed=\"" . date("Y-m-d H-i-s") . "\"")->execute();
        Yii::$app->db->createCommand("UPDATE sd_price_items SET removed=\"" . date("Y-m-d H-i-s") . "\"")->execute();
        Yii::$app->db->createCommand("DELETE FROM sd_price_local")->execute();
        Yii::$app->db->createCommand("ALTER TABLE `sd_price_local` 	AUTO_INCREMENT=0;")->execute();
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
                Yii::$app->db->createCommand($sql)->execute();
                $sqlStackCount = 0;
                $sql = "";
            }
        }
        file_put_contents($parse_time_file, time());
        self::singletonUnlock($lockfile);
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
            Yii::$app->db->createCommand("DELETE FROM sd_loaded_schedules WHERE fileName=\"" . $f["fileName"] . "\" ")->execute();
            if (file_exists($fName)) unlink($fName);
            echo $f["fileName"] . "\n";
        }

        Yii::$app->db->createCommand("DELETE FROM sd_timeline_days WHERE day< DATE_SUB(\"" . date("Y-m-d") . "\", INTERVAL 4 DAY)")->execute();
        return 0;
    }

    public function actionResetSchedule()
    {
        Yii::$app->db->createCommand("DELETE FROM sd_loaded_schedules")->execute();
        Yii::$app->db->createCommand("ALTER TABLE `sd_loaded_schedules` AUTO_INCREMENT=0;")->execute();
        Yii::$app->db->createCommand("DELETE FROM sd_timeline_days")->execute();
        Yii::$app->db->createCommand("ALTER TABLE `sd_timeline_days` AUTO_INCREMENT=0;")->execute();
        Yii::$app->db->createCommand("DELETE FROM sd_timeline_cells")->execute();
        Yii::$app->db->createCommand("ALTER TABLE `sd_timeline_cells` AUTO_INCREMENT=0;")->execute();
        Yii::$app->db->createCommand("DELETE FROM sd_timeline_changelog")->execute();
        Yii::$app->db->createCommand("ALTER TABLE `sd_timeline_changelog` AUTO_INCREMENT=0;")->execute();
        Yii::$app->db->createCommand("DELETE FROM sd_timelines")->execute();
        Yii::$app->db->createCommand("ALTER TABLE `sd_timelines` AUTO_INCREMENT=0;")->execute();
        Yii::$app->db->createCommand("DELETE FROM sd_workplaces")->execute();
        Yii::$app->db->createCommand("ALTER TABLE `sd_workplaces` AUTO_INCREMENT=0;")->execute();
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
                Yii::$app->db->createCommand()->batchInsert('sd_loaded_schedules', ["fileName", "loadTime"], $inserts)->execute();
                $inserts = [];
            }

        }
        Yii::$app->db->createCommand()->batchInsert('sd_loaded_schedules', ["fileName", "loadTime"], $inserts)->execute();
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

        $lockfile = "lockfile-parse-schedules.txt";
        self::singletonLock($lockfile);

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
            self::singletonUnlock($lockfile);
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
                self::singletonUnlock($lockfile);
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
                                        Yii::$app->db->createCommand("INSERT INTO sd_shedule_assign SET personId=" . $person->person_id . ", shedule_hash=\"" . $schedule_hash . "\" , schedule_fio=\"" . $personName . "\" ")->execute();
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

                            $dailyTimelines = [];
                            foreach ($schedule->cells as $cell) {
                                if (!array_key_exists($cell->date, $dailyTimelines)) {
                                    $dailyTimelines[$cell->date] = DailyTimeline::load($cell->date, $tl->id);
                                }
                                $dailyTimelines[$cell->date]->add($cell->time_start, $cell->time_end, $cell->free);
                            }
                            foreach ($dailyTimelines as $dailyTimeline) {
                                $dailyTimeline->save();
                            }
                        } else {
                            echo "Отсутствует соответствие: " . $schedule->name . " / " . $schedule_hash . " (" . $subdiv->name . ")\n";
                        }
                    }
                }
            }
            Yii::$app->db->createCommand("UPDATE sd_loaded_schedules SET  parsed=1 WHERE fileName=\"" . $fName . "\";")->execute();
        }
        self::singletonUnlock($lockfile);
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

    public static function singletonLock(string $lockfile)
    {
        $lockFilePath = __DIR__ . "/../stage/" . $lockfile;
        if (file_exists($lockFilePath)) exit;
        file_put_contents($lockFilePath, getmypid(), LOCK_EX);
        if (file_get_contents($lockFilePath) != getmypid()) {
            echo "Уже выполняется";
            exit;
        }
    }

    public static function singletonUnlock(string $lockfile)
    {
        $lockFilePath = __DIR__ . "/../stage/" . $lockfile;
        unlink($lockFilePath);
    }
}