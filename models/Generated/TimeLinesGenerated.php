<?php

namespace app\models\Generated;

use Yii;

/**
 * This is the model class for table "sd_timelines".
 *
 * @property int $id
 * @property string $workplace_hash
 * @property int $person_id
 */
class TimeLinesGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_timelines';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['workplace_hash', 'person_id'], 'required'],
            [['workplace_hash'], 'string'],
            [['person_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'workplace_hash' => 'Workplace Hash',
            'person_id' => 'Person ID',
        ];
    }
}
