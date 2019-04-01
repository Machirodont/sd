<?php
/**
 * Created by PhpStorm.
 * User: a.ivanitsky
 * Date: 01.04.2019
 * Time: 10:42
 */

namespace app\models;


use app\models\Generated\PriceItemsGenerated;
use yii\db\Query;

/**
 * Class PriceItems
 * @package app\models
 * @property $price float|null
 */
class PriceItems extends PriceItemsGenerated
{
    public function getPrice()
    {
        $clinicId = \Yii::$app->session->get("cid");
        if (!$clinicId) return null;
        $price = (new Query())->select("price")
            ->from("sd_price_local")
            ->where([
                "clinicId" => $clinicId,
                "itemId" => $this->id
            ])->all();
        if (count($price) === 0) return null;
        return $price[0]["price"];
    }
}