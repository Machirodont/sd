<?php
/**
 * Created by PhpStorm.
 * User: a.ivanitsky
 * Date: 05.03.2019
 * Time: 17:26
 */

namespace app\models;

use app\models\Generated\TimeLinesGenerated;

/**
 * @property TimelineDays $days Дни расписания TimeLine
 * @property array $activeDays
 */
class TimeLines extends TimeLinesGenerated
{
    public function getDays()
    {
        return TimelineDays::find()
            ->where(["timelineId" => $this->id])
            ->all();
    }

    public function getActiveDays()
    {
        $days = TimelineDays::find()
            ->where(["timelineId" => $this->id, "is_active" => 1])
            ->indexBy("day")
            ->all();

        if (!is_array($days)) return [];
        return $days;
    }

}