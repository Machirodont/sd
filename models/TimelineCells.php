<?php
/**
 * Created by PhpStorm.
 * User: a.ivanitsky
 * Date: 22.04.2019
 * Time: 14:56
 */

namespace app\models;


use app\models\Generated\TimelineCellsGenerated;

/**
 * Class TimelineCells
 * @property int $startT
 * @property int $endT
 * @property TimeLines $timeline
 * @package app\models
 */
class TimelineCells extends TimelineCellsGenerated
{
    public function getStartT()
    {
        if (!$this->start) return null;
        if ($d = date_create_from_format("Y-m-d H:i:s", $this->start)) return $d->getTimestamp();
        return null;
    }

    public function getEndT()
    {
        if (!$this->end) return null;
        if ($d = date_create_from_format("Y-m-d H:i:s", $this->end)) return $d->getTimestamp();
        return null;
    }

    public function getTimeline()
    {
        return TimeLines::findOne($this->timelineId);
    }
}