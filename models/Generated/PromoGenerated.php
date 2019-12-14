<?php

namespace app\models\Generated;

use Yii;

/**
 * This is the model class for table "sd_promo".
 *
 * @property int $id
 * @property string $title
 * @property string $startDate
 * @property string $endDate
 * @property string $clinics
 * @property string $html
 */
class PromoGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_promo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'clinics'], 'required'],
            [['title', 'clinics'], 'string'],
            [['startDate', 'endDate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'startDate' => 'Start Date',
            'endDate' => 'End Date',
            'clinics' => 'Clinics',
        ];
    }
}
