<?php
/**
 * Created by PhpStorm.
 * User: a.ivanitsky
 * Date: 01.04.2019
 * Time: 12:24
 */

namespace app\commands;


use yii\console\Controller;
use app\models\PriceGroup;
use app\models\PriceItems;

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
        for ($i = 0; $i < count($arr); $i++) {
            echo round(100 * ($i + 1) / $arrCount) . "% (" . ($i + 1) . ")              \r";
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
            $sql = "";
            foreach ($arr[$i]["price_list"] as $clinicName => $price) {
                if (array_key_exists($clinicName, $clinicId) && ((float)$price) > 0) {
                    $sql .= "INSERT INTO sd_price_local SET itemId=" . $itemId . ", clinicId=" . $clinicId[$clinicName] . ", price=\"" . ((float)$price) . "\";";
                    $sqlStackCount++;
                }
            }
            if ($sqlStackCount > 20) {
                \Yii::$app->db->createCommand($sql)->execute();
                $sqlStackCount = 0;
            }
        }
        exit;
    }

    public function actionIndexGroups()
    {
        $groups=PriceGroup::find()->all();
        
    }

}