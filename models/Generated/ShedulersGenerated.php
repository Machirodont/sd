<?php

namespace app\models\Generated;

use Yii;

/**
 * This is the model class for table "sd_shedulers".
 *
 * @property int $id
 * @property string $hash
 * @property string $person_name
 * @property string $workplace_hash
 * @property string $workplace_name
 * @property string $subdivision_hash
 * @property string $subdivision_name
 */
class ShedulersGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_schedule_parsing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['hash', 'person_name', 'workplace_hash', 'workplace_name', 'subdivision_hash', 'subdivision_name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash' => 'Hash',
            'person_name' => 'Person Name',
            'workplace_hash' => 'Workplace Hash',
            'workplace_name' => 'Workplace Name',
            'subdivision_hash' => 'Subdivision Hash',
            'subdivision_name' => 'Subdivision Name',
        ];
    }
}
