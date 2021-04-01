<?php

namespace app\models\Generated;

use Yii;

/**
 * This is the model class for table "sd_appointment".
 *
 * @property int $id
 * @property int $person_id
 * @property int $clinic_id
 * @property string $phone
 * @property string $ip
 * @property string $day
 * @property string $cookie
 * @property int $status
 * @property string $created
 * @property int $owner_id
 */
class AppointmentGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_appointment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_id', 'clinic_id'], 'integer'],
            [['phone', 'cookie'], 'required'],
            [['phone', 'cookie'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'person_id' => 'Person ID',
            'clinic_id' => 'Clinic ID',
            'phone' => 'Phone',
            'cookie' => 'Cookie',
        ];
    }
}
