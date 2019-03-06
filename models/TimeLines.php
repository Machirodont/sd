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
 *
 */
class TimeLines extends TimeLinesGenerated
{
    public function getDays()
    {
        return TimelineDays::find()
            ->where(["timelineId" => $this->id])
            ->all();
    }
}