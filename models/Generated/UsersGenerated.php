<?php

namespace app\models\Generated;

use Yii;

/**
 * This is the model class for table "sd_users".
 *
 * @property int $id
 * @property string $login
 * @property string $hash
 * @property int $is_admin
 * @property string $clinics
 */
class UsersGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'hash', 'clinics'], 'required'],
            [['login', 'hash', 'clinics'], 'string'],
            [['is_admin'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'hash' => 'Hash',
            'is_admin' => 'Is Admin',
            'clinics' => 'Clinics',
        ];
    }
}
