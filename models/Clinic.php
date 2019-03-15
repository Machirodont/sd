<?php
/**
 * Created by PhpStorm.
 * User: Nerp
 * Date: 01.12.2018
 * Time: 11:55
 */

namespace app\models;

use app\models\Generated\ClinicsGenerated;

/**
 * Class Clinic
 * @property array $htmlBlocks
 * @property string $htmlDescription
 *
 */
class Clinic extends ClinicsGenerated
{
    /**
     * @return array
     */
    public function getHtmlBlocks()
    {
        return HtmlBlock::find()
            ->where([
                "itemTable" => self::tableName(),
                "itemKey" => $this->primaryKey
            ])
            ->orderBy("order")
            ->all();
    }

    public function getHtmlDescription()
    {
        return array_reduce($this->htmlBlocks, function ($html, HtmlBlock $b) {
            return $html . "\n<div>" . $b->content."</div>";
        }, "");
    }

}