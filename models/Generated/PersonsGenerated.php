<?php

namespace app\models\Generated;

use Yii;
use app\models\Institutions;
use app\models\Traits;

/**
 * This is the model class for table "sd_persons".
 *
 * @property int $person_id
 * @property string $firstname Имя
 * @property string $lastname Фамилия
 * @property string $patronymic Отчество
 * @property int $education Основное образование
 * @property int $years_work Стаж работы, лет
 *
 * @property Institutions $education0
 * @property Traits[] $allTraits
 * @property Traits[][] $traits
 */
class PersonsGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_persons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname'], 'required'],
            [['firstname', 'lastname', 'patronymic'], 'string'],
            [['education', 'years_work'], 'integer'],
            [['education'], 'exist', 'skipOnError' => true, 'targetClass' => Institutions::className(), 'targetAttribute' => ['education' => 'institution_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'person_id' => 'Person ID',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'education' => 'Основное образование',
            'years_work' => 'Стаж работы, лет',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducation0()
    {
        return $this->hasOne(Institutions::class, ['institution_id' => 'education']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllTraits()
    {
        return $this->hasMany(Traits::class, ['person_id' => 'person_id']);
    }

    private $_sortedTraits=null;

    public function getTraits(){
        if(is_null($this->_sortedTraits)) {
            $traits = $this->allTraits;
            $this->_sortedTraits = [];
            foreach ($traits as $trait) {
                $this->_sortedTraits[$trait->title][] = $trait;
            }
        }
        return $this->_sortedTraits;
    }
}
