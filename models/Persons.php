<?php


namespace app\models;

use app\models\Generated\PersonsGenerated;

/**
 *
 * Class Persons
 * @package app\models
 * @property string $fullname Полное имя
 * @property string $portraitUrl url адрес фотографии
 * @property Clinic[] $clinics Клиники
 *
 */
class Persons extends PersonsGenerated
{
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

}