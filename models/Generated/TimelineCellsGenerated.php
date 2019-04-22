<?php

namespace app\models\Generated;

use Yii;

/**
 * This is the model class for table "sd_timeline_cells".
 *
 * @property int $id
 * @property int $timelineId
 * @property string $start
 * @property string $end
 * @property int $free
 * @property string $source
 */
class TimelineCellsGenerated extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_timeline_cells';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['timelineId', 'free'], 'integer'],
            [['start', 'end'], 'safe'],
            [['source'], 'string'],
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
            'start' => 'Start',
            'end' => 'End',
            'free' => 'Free',
            'source' => 'Source',
        ];
    }
}
