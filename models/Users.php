<?php


namespace app\models;


use Codeception\Module\Cli;
use Yii;

/**
 * Class Users
 * @package app\models
 * @property int[] $clinicIdList
 * @property Clinic[] $clinicList
 */
class Users extends Generated\UsersGenerated implements \yii\web\IdentityInterface
{

    public $password1;
    public $password2;

    public function rules()
    {
        return [
            [['login', 'hash'], 'required'],
            [['login', 'clinics', 'password1', 'password2'], 'string'],
            [['is_admin'], 'integer'],
            [['clinicIdList'], 'safe'],
            [['password1', 'password2'], function ($attr) {
                if ($this->password1 !== $this->password2) {
                    $this->addError('password1', 'Пароли не совпадают');
                    $this->addError('password2', 'Пароли не совпадают');
                }
            }],
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->password1) {
            $this->hash = Yii::$app->security->generatePasswordHash($this->password1);
        }
        return parent::save($runValidation, $attributeNames);
    }

    public function getClinicIdList()
    {
        $clinics = json_decode($this->clinics);
        return is_array($clinics) ? $clinics : [];
    }

    public function setClinicIdList($list)
    {
        $this->clinics = json_encode($list);
    }

    public function getClinicList()
    {
        return Clinic::find()->where(['id' => $this->clinicIdList])->all();
    }


    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->hash);
    }

}