<?php
/**
 * Created by PhpStorm.
 * User: a.ivanitsky
 * Date: 14.03.2019
 * Time: 12:00
 */

namespace app\models;


use app\models\Generated\PagesGenerated;

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
        return array_reduce($blocks, function ($html, HtmlBlock $b) {
            return $html . "\n<div>" . $b->content . "</div>";
        }, "");
    }
}