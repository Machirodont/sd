<?php


namespace app\models;


class AppointmentSettingsForm extends \yii\base\Model
{
    public function rules()
    {
        return [
            [['enableAppointment', 'enableCaptcha'], 'boolean'],
        ];
    }

    public $enableAppointment;
    public $enableCaptcha;

    public const FILE_APPOINTMENT_ENABLE = __DIR__ . "/../stage/setting-appointment-enabled";
    public const FILE_CAPTCHA_ENABLE = __DIR__ . "/../stage/setting-captcha-enabled";

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->enableAppointment = file_exists(self::FILE_APPOINTMENT_ENABLE);
        $this->enableCaptcha = file_exists(self::FILE_CAPTCHA_ENABLE);
    }

    public function save()
    {
        if ($this->enableAppointment && !file_exists(self::FILE_APPOINTMENT_ENABLE)) {
            file_put_contents(self::FILE_APPOINTMENT_ENABLE, "1");
        }
        if (!$this->enableAppointment && file_exists(self::FILE_APPOINTMENT_ENABLE)) {
            unlink(self::FILE_APPOINTMENT_ENABLE);
        }

        if ($this->enableCaptcha && !file_exists(self::FILE_CAPTCHA_ENABLE)) {
            file_put_contents(self::FILE_CAPTCHA_ENABLE, "1");
        }
        if (!$this->enableCaptcha && file_exists(self::FILE_CAPTCHA_ENABLE)) {
            unlink(self::FILE_CAPTCHA_ENABLE);
        }
    }
}