<?php


namespace app\models;


use Yii;

class Users extends Generated\UsersGenerated
{

    public $password1;
    public $password2;


    public function rules()
    {
        return [
            [['login', 'hash', 'clinics'], 'required'],
            [['login', 'clinics', 'password1', 'password2'], 'string'],
            [['is_admin'], 'integer'],
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
}