<?php
/**
 * Created by PhpStorm.
 * User: Nerp
 * Date: 01.12.2018
 * Time: 11:55
 */

namespace app\models;

use app\models\Generated\PersonsGenerated;

/**
 *
 * Class Persons
 * @package app\models
 * @property string $fullname Полное имя
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

}