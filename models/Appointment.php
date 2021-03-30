<?php

namespace app\models;

/**
 * Class Appointment
 * @package app\models
 * @property-read Persons $person
 * @property-read Clinic $clinic
 * @property-read Users $owner
 */
class Appointment extends Generated\AppointmentGenerated
{
    public const STATUS_CREATED = 0;
    public const STATUS_IN_PROGRESS = 1;
    public const STATUS_CONFIRMED = 2;
    public const STATUS_CANCELLED = 3;
    public const COOKIE_NAME = 'appointment_key';

    public function getPerson()
    {
        return Persons::findOne($this->person_id);
    }

    public function getClinic()
    {
        return Clinic::findOne($this->clinic_id);
    }

    public function getOwner()
    {
        return Users::findOne($this->owner_id);
    }
}