<?php

namespace app\models\Generated;

use Yii;
use app\models\Institutions;
use app\models\Persons;

/**
 * This is the model class for table "sd_traits".
 *
 * @property int $trait_id
 * @property int $person_id врач
 * @property string $title
 * @property string $description
 * @property int $institution_id
 *
 * @property Institutions $institution
 * @property Persons $person
 */
class TraitsGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_traits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_id', 'institution_id'], 'integer'],
            [['title', 'description'], 'required'],
            [['title', 'description'], 'string'],
            [['institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => Institutions::className(), 'targetAttribute' => ['institution_id' => 'institution_id']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Persons::className(), 'targetAttribute' => ['person_id' => 'person_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'trait_id' => 'Trait ID',
            'person_id' => 'врач',
            'title' => 'Title',
            'description' => 'Description',
            'institution_id' => 'Institution ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitution()
    {
        return $this->hasOne(Institutions::className(), ['institution_id' => 'institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Persons::className(), ['person_id' => 'person_id']);
    }
}
