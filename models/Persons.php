<?php


namespace app\models;

use app\helpers\Extra;
use app\models\Generated\PersonsGenerated;
use yii\db\Query;

/**
 *
 * Class Persons
 * @package app\models
 * @property string $fullName Полное имя
 * @property string $portraitUrl url адрес фотографии
 * @property Clinic[] $clinics Клиники
 * @property Clinic $currentClinic Выбранная клиника
 * @property TimeLines[] $timeLines Таймлайны выбранной клиники
 * @property TimelineDays[] $activeDays Дни работы в выбранной клинике (для всех Workplaces)
 * @property string $sheduleHash Хэш-ID расписания для выбранной клиники
 * @property array $htmlBlocks
 * @property string $htmlDescription
 * @property string $primarySpec
 * @property string $secondarySpecs
 * @property TimelineCells[] $timeCells
 *
 */
class Persons extends PersonsGenerated
{
    public $currentClinic = null;

    public $loadedTraits = [];

    public function rules()
    {
        return [
            [['firstname', 'lastname'], 'required'],
            [['firstname', 'lastname', 'patronymic'], 'string'],
            [['education', 'years_work'], 'integer'],
            [['education', 'years_work'], 'filter', 'filter' => function ($val) {
                return $val ? $val : null;
            }],
            ['loadedTraits', 'safe']
        ];
    }

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
     * @return TimeLines[]
     */
    public function getTimeLines()
    {
        if (!$this->currentClinic instanceof Clinic) return null;
        return TimeLines::find()
            ->select("tl.*")
            ->from(["tl" => "sd_timelines"])
            ->leftJoin(["w" => "sd_workplaces"], "tl.workplace_hash = w.workplace_hash")
            ->where([
                "w.clinic_hash" => $this->currentClinic->hash_id,
                "tl.person_id" => $this->person_id
            ])
            ->all();
        //У одного человека может быть несколько Workplace в одном подразделении
    }

    public function getTimeCells()
    {
        if (!$this->currentClinic instanceof Clinic) return null;
        return TimelineCells::find()
            ->select("tc.*")
            ->from(["tc" => "sd_timeline_cells"])
            ->leftJoin(["tl" => "sd_timelines"], "tc.timelineId = tl.id")
            ->leftJoin(["w" => "sd_workplaces"], "tl.workplace_hash = w.workplace_hash")
            ->where([
                "w.clinic_hash" => $this->currentClinic->hash_id,
                "tl.person_id" => $this->person_id
            ])
            ->orderBy("tc.start")
            ->all();
    }


    public function getActiveDays()
    {
        if (!$this->currentClinic instanceof Clinic) return null;
        $timelines = $this->timeLines;
        $days = [];
        foreach ($timelines as $timeline) {
            $days = array_merge($days, $timeline->activeDays);
        }
        return $days;
    }


    public function searchActiveDays(\DateTime $from, \DateTime $to)
    {
        if (!$this->currentClinic instanceof Clinic) return null;
        $timelines = $this->timeLines;
        $days = [];
        foreach ($timelines as $timeline) {
            $days = array_merge($days, $timeline->searchActiveDays($from, $to));
        }
        return $days;
    }

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

    public function traitString($traitTitle, $glue = ", ")
    {
        return Extra::implodeField($this->traits[$traitTitle], "description", $glue);
    }

    public function getPrimarySpec()
    {
        if (isset($this->traits["специальность"]) && is_array($this->traits["специальность"])) {
            $specs = $this->traits["специальность"];
            if (count($specs) === 0) return "";
            $specs = Extra::sortByField($specs, "sort");
            return mb_strtoupper($specs[0]->description);
        }
        return "";
    }


    public function getSecondarySpecs()
    {
        if (isset($this->traits["специальность"]) && is_array($this->traits["специальность"])) {
            $specs = $this->traits["специальность"];
            if (count($specs) < 2) return "";
            $specs = Extra::sortByField($specs, "sort");
            array_shift($specs);
            return Extra::implodeField($specs, "description", ", ");
        }
        return "";
    }

    public function getWorkExperiences()
    {
        $exp = [];
        if (isset($this->traits["Основное место работы"]) && is_array($this->traits["Основное место работы"])) {
            foreach ($this->traits["Основное место работы"] as $trait) {
                /**@var $trait Traits */
                $expirienceDescription = ($trait->description) ? $trait->description : "Специалист";
                if ($trait->institution) {
                    $expirienceDescription .= ", ";
                    $expirienceDescription .= ($trait->institution->shortname)
                        ? $trait->institution->shortname . " (" . $trait->institution->name . ")"
                        : $trait->institution->name;
                }
                $exp[] = $expirienceDescription;
            }
        }
        return $exp;
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

    public function getYearsWorkString()
    {
        $word = ($this->years_work !== 11 && $this->years_work % 10 === 1) ? "года" : "лет";
        return "более " . $this->years_work . " " . $word;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if (parent::save($runValidation, $attributeNames)) {
            for ($i = 0; $i < count($this->loadedTraits["trait_id"]); $i++) {
                if (!$trait = Traits::findOne($this->loadedTraits["trait_id"][$i])) {
                    $trait = new Traits();
                }
                $trait->person_id = $this->person_id;
                $trait->title = $this->loadedTraits["title"][$i];
                $trait->description = $this->loadedTraits["description"][$i];
                $trait->institution_id = $this->loadedTraits["institution_id"][$i] ? $this->loadedTraits["institution_id"][$i] : null;
                $trait->sort = $this->loadedTraits["sort"][$i];
                $trait->sort = $trait->sort ? $trait->sort : 10;
                if ($trait->title !== "0") {
                    if (!$trait->save()) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }
}