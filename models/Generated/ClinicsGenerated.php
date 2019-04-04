<?php

namespace app\models\Generated;

use Yii;

/**
 * This is the model class for table "sd_clinics".
 *
 * @property int $id
 * @property string $city город
 * @property string $in "в городе"
 * @property string $region район
 * @property string $address адрес клиники
 * @property string $phone телефон клиники
 * @property string $hash_id
 */
class ClinicsGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_clinics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city'], 'required'],
            [['city', 'region', 'in', 'address', 'phone', 'hash_id'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city' => 'город',
            'region' => 'район',
            'address' => 'адрес клиники',
            'phone' => 'телефон клиники',
            'hash_id' => 'Hash ID',
        ];
    }
}
