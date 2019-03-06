<?php

namespace app\models\Generated;

use app\models\TimeLines;
use Yii;

/**
 * This is the model class for table "sd_timeline_days".
 *
 * @property int $id
 * @property int $timelineId
 * @property string $day
 * @property int $is_active
 *
 * @property TimeLines $timeline
 */
class TimelineDaysGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_timeline_days';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['timelineId', 'is_active'], 'integer'],
            [['day'], 'required'],
            [['day'], 'safe'],
            [['timelineId', 'day'], 'unique', 'targetAttribute' => ['timelineId', 'day']],
            [['timelineId'], 'exist', 'skipOnError' => true, 'targetClass' => TimeLines::class, 'targetAttribute' => ['timelineId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'timelineId' => 'Timeline ID',
            'day' => 'Day',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimeline()
    {
        return $this->hasOne(Timelines::class, ['id' => 'timelineId']);
    }
}
