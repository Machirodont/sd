<?php

namespace app\models;

use app\models\Generated\ClinicsGenerated;
use Yii;

/**
 * Class Clinic
 * @property array $htmlBlocks
 * @property string $htmlDescription
 * @property int $companyPage
 * @property Persons[] $persons
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
            return $html . "\n<div>" . $b->content . "</div>";
        }, "");
    }

    public function getPersons(): array
    {
        $query = Persons::find()->where(["removed" => null]);
        $query
            ->from([
                "p" => "sd_persons",
                "t" => "sd_timelines",
                "w" => "sd_workplaces",
                "c" => "sd_clinics",
            ])
            ->where(["and",
                "c.id = " . $this->id,
                "c.hash_id = w.clinic_hash",
                "c.hash_id = w.clinic_hash",
                "w.workplace_hash = t.workplace_hash",
                "t.person_id=p.person_id",
                "p.removed IS NULL"
            ]);

        return $query->all();
    }

}