<?php

namespace app\models;

use DateTime;

/**
 * Class Appointment
 * @package app\models
 * @property-read Persons $person
 * @property-read Clinic $clinic
 * @property-read Users $owner
 * @property-read DateTime $date
 * @property-read string $semanticHowLongAgo
 */
class Appointment extends Generated\AppointmentGenerated
{
    public const STATUS_CREATED = 0;
    public const STATUS_IN_PROGRESS = 1;
    public const STATUS_CONFIRMED = 2;
    public const STATUS_CANCELLED = 3;
    public const COOKIE_NAME = 'appointment_key';

    public const STATUS_NAME = [
        0 => 'НОВОЕ',
        1 => "В РАБОТЕ",
        2 => "ПОДТВЕРЖДЕНО",
        3 => "ОТМЕНЕНО",
    ];

    public static function statusIsValid($status): bool
    {
        return in_array((int)$status, [Appointment::STATUS_CREATED, Appointment::STATUS_CONFIRMED, Appointment::STATUS_CANCELLED]);
    }

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

    /**
     * @param string $phone
     * @return Appointment[]
     */
    public static function findByPhone(string $phone): array
    {
        return Appointment::find()->where(['phone' => $phone])->all();
    }

    private static function findDouble(Appointment $origin)
    {
        return Appointment::find()->where([
            "phone" => $origin->phone,
            "person_id" => $origin->person_id,
            "clinic_id" => $origin->clinic_id,
            "status" => $origin->status,
            "cookie" => $origin->cookie,
        ])->one();
    }

    public function mergeDouble(): Appointment
    {
        $double = Appointment::findDouble($this);
        return $double ? $double : $this;
    }

    public function getDate()
    {
        return DateTime::createFromFormat('Y-m-d', $this->day);
    }

    public function getSemanticHowLongAgo()
    {
        $appoitmentUtcTime = date_create($this->created)
            ->format("U");
        $howLongAgoSec = time()
            - (int)$appoitmentUtcTime
            + (new \DateTimeZone('Europe/Moscow'))->getOffset(date_create($this->created));
        $result = "Получено ";
        if ($howLongAgoSec > 60 * 60 * 24) {
            $result .= "больше суток назад";
        } elseif ($howLongAgoSec >= 60 * 60) {
            $result .= floor($howLongAgoSec / 3600) . " часов " . floor($howLongAgoSec % 3600 / 60) . " минут назад";
        } else {
            $result .= floor($howLongAgoSec / 60) . " минут назад";
        }
        return $result;
    }
}