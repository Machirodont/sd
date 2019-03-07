<?php


namespace app\models;

use app\models\Generated\PersonsGenerated;
use yii\db\Query;

/**
 *
 * Class Persons
 * @package app\models
 * @property string $fullname Полное имя
 * @property string $portraitUrl url адрес фотографии
 * @property Clinic[] $clinics Клиники
 * @property Clinic $currentClinic Выбранная клиника
 * @property TimeLines $timeLine Таймлайн выбранной клиники
 * @property string $sheduleHash Хэш-ID расписания для выбранной клиники
 * @property array $htmlBlocks
 * @property string $htmlDescription
 *
 */
class Persons extends PersonsGenerated
{
    public $currentClinic = null;

    public function getFullName()
    {
        return $this->lastname . " " . $this->firstname . (($this->patronymic) ? " " . $this->patronymic : "");
    }

    public function getPortraitUrl()
    {
        if (file_exists('./images/persons/' . $this->person_id . '.jpg')) {
            return "/images/persons/" . $this->person_id . ".jpg";
        }
        return "/images/persons/0.jpg";
    }

    public function getClinics()
    {
        return Clinic::find()
            ->select("c.*")
            ->from(["c" => "sd_clinics"])
            ->leftJoin(["w" => "sd_workplaces"], "w.clinic_hash = c.hash_id")
            ->leftJoin(["t" => "sd_timelines"], "t.workplace_hash = w.workplace_hash")
            ->where(["t.person_id" => $this->person_id])
            ->all();
    }

    /**
     * @return TimeLines
     */
    public function getTimeLine()
    {
        if (!$this->currentClinic instanceof Clinic) return null;
        $res = TimeLines::find()
            ->select("tl.*")
            ->from(["tl" => "sd_timelines"])
            ->leftJoin(["w" => "sd_workplaces"], "tl.workplace_hash = w.workplace_hash")
            ->where([
                "w.clinic_hash" => $this->currentClinic->hash_id,
                "tl.person_id" => $this->person_id
            ])
            ->all();
        if (count($res) === 1) return $res[0];
        return null;
    }

    /**
     * @return array
     */
    public function getHtmlBlocks()
    {
        return HtmlBlock::find()
            ->where([
                "itemTable" => "sd_persons",
                "itemKey" => $this->person_id
            ])
            ->orderBy("order")
            ->all();
    }

    public function getHtmlDescription()
    {
        return array_reduce($this->htmlBlocks, function ($html, HtmlBlock $b) {
            return $html . "\n<div>" . $b->html."</div>";
        }, "");
    }

    public function traitString($traitTitle, $glue = ", ")
    {
        $s = "";
        if (isset($this->traits[$traitTitle]) && is_array($this->traits[$traitTitle])) {
            for ($i = 0; $i < count($this->traits[$traitTitle]); $i++) {
                if ($i > 0) $s .= $glue;
                $s .= $this->traits[$traitTitle][$i]->description;
            }
        }
        return $s;
    }

    /**
     * @param $sheduleHash
     * @return null|Persons
     */
    public static function findBySheduleHash($sheduleHash)
    {
        $res = self::find()
            ->select("p.*")
            ->from(["p" => "sd_persons", "a" => "sd_shedule_assign"])
            ->where(["and",
                "p.person_id = a.personId",
                "a.shedule_hash = \"" . $sheduleHash . "\"",
            ])
            ->all();
        if (count($res) === 1) return $res[0];
        return null;
    }
}