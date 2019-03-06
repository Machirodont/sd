<?php

namespace app\models\Generated;

use Yii;

/**
 * This is the model class for table "sd_workplaces".
 *
 * @property int $id
 * @property string $workplace_hash
 * @property string $clinic_hash
 */
class WorkplacesGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_workplaces';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['workplace_hash'], 'required'],
            [['workplace_hash', 'clinic_hash'], 'string'],
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
            'clinic_hash' => 'Clinic Hash',
        ];
    }
}
