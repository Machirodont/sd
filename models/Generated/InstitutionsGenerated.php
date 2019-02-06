<?php

namespace app\models\Generated;

use Yii;
use app\models\Traits;
use app\models\Persons;

/**
 * This is the model class for table "sd_institutions".
 *
 * @property int $institution_id
 * @property string $name название заведения
 * @property string $shortname сокращенное название заведения
 *
 * @property Persons[] $persons
 * @property Traits[] $traits
 */
class InstitutionsGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_institutions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'shortname'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'institution_id' => 'Institution ID',
            'name' => 'название заведения',
            'shortname' => 'сокращенное название заведения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersons()
    {
        return $this->hasMany(Persons::className(), ['education' => 'institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTraits()
    {
        return $this->hasMany(Traits::className(), ['institution_id' => 'institution_id']);
    }
}
