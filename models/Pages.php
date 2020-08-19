<?php
/**
 * Created by PhpStorm.
 * User: a.ivanitsky
 * Date: 14.03.2019
 * Time: 12:00
 */

namespace app\models;


use app\models\Generated\PagesGenerated;
use Yii;
use yii\helpers\Html;

/** @property string $content
 */
class Pages extends PagesGenerated
{

    public function getContent()
    {
        $blocks = HtmlBlock::find()
            ->where([
                "itemTable" => "sd_pages",
                "itemKey" => $this->id
            ])
            ->orderBy("order")
            ->all();

        $content = array_reduce($blocks,
            function ($html, HtmlBlock $b) {
                $res = $html . "\n<div>" . $b->content . "</div>";
                if (!Yii::$app->user->isGuest) {
                    $res .= $html . Html::a("Редактировать блок", ["/html-block/update", "id" => $b->id], ["class" => "btn btn-warning"]);
                }
                return $res;
            },
            "");

        if (!Yii::$app->user->isGuest) {
            $content .= "<br><br><br>".Html::a("Добавить блок", ["/html-block/create", "key" => $this->primaryKey, "class"=>"page"], ["class" => "btn btn-success"]);
        }
        return $content;
    }
}