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
 * @property string $sheduleHash Хэш-ID расписания для выбранной клиники
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
        return $this->hasMany(Clinic::class, ['hash_id' => 'subdivision_hash'])
            ->viaTable("sd_schedule", ['person_id' => 'person_id']);
    }

    public function getSheduleHash()
    {
        if (!$this->currentClinic instanceof Clinic) return null;
        $shedules = (new Query())
            ->select("hash")
            ->from("sd_schedule")
            ->where([
                "person_id" => $this->person_id,
                "subdivision_hash" => $this->currentClinic->hash_id
            ])
            ->column();
        if (count($shedules) !== 1) return null;
        return ($shedules[0]);
    }

    public
    function traitString($traitTitle, $glue = ", ")
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

}