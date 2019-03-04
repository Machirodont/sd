<?php

namespace app\models\Generated;

use Yii;

/**
 * This is the model class for table "sd_shedule_days".
 *
 * @property int $id
 * @property string $day
 * @property string $shedule_hash
 * @property int $is_active
 */
class SheduleDaysGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_shedule_days';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['day', 'shedule_hash','workplace_hash'], 'safe'],
            [['is_active'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day' => 'Day',
            'shedule_hash' => 'Shedule Hash',
            'workplace_hash' => 'workplace hash',
            'is_active' => 'Is Active',
        ];
    }
}
