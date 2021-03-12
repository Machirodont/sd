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

    public function searchActiveDays(\DateTime $from, \DateTime $to)
    {
        $days = TimelineDays::find()
            ->where(["and",
                ["timelineId" => $this->id, "is_active" => 1],
                [">", "day", $from->format("Y-m-d")],
                ["<", "day", $to->format("Y-m-d")],
            ])
            ->indexBy("day")
            ->all();
        if (!is_array($days)) return [];
        return $days;
    }

    /** Возвращает индексированные по датам массивы ячеек, отсортированных по времени
     * @param TimelineCells[] $timeCells
     * @param bool $showCrossLvl Проверять пересечения ячеек
     * @return array
     */
    public static function indexTimeCells(array $timeCells, $showCrossLvl = false): array
    {
        $timeCellIndex = [];
        if ($timeCells) {
            foreach ($timeCells as $tc) {
                $date = substr($tc->start, 0, strpos($tc->start, " "));
                if (!array_key_exists($date, $timeCellIndex)) {
                    $timeCellIndex[$date] = [];
                }
                $start = substr($tc->start, strpos($tc->start, " ") + 1);
                $end = substr($tc->end, strpos($tc->end, " ") + 1);
                $crossLvl = null;

                if ($showCrossLvl) {
                    $crossLvl = 0;
                    foreach ($timeCellIndex[$date] as $dateToCross) {
                        $isForward = $start >= $dateToCross['end'] && $end >= $dateToCross['end'];
                        $isBack = $start <= $dateToCross['start'] && $end <= $dateToCross['start'];
                        if (($crossLvl === $dateToCross["cross"]) && !($isForward || $isBack)) {
                            $crossLvl = max($crossLvl, ($dateToCross["cross"] + 1));
                        }
                    }
                }

                $timeCellIndex[$date][] = [
                    "start" => $start,
                    "end" => $end,
                    "free" => $tc->free,
                    "cross" => $crossLvl,
                    "id" => $tc->id,
                ];
            }
            ksort($timeCellIndex);
        }

        foreach ($timeCellIndex as $date => $cells) {
            usort($timeCellIndex[$date], function ($a, $b) {
                if ($a["start"] === $b["start"]) return 0;
                return ($a["start"] < $b["start"]) ? -1 : 1;
            });
        }
        return $timeCellIndex;
    }

    /** Индексированный по датам массив со свободными периодами
     * @param array $timeCellIndex - сюда запихнуть вывод indexTimeCells
     * @return array
     */
    public static function freeRanges(array $timeCellIndex)
    {
        $timeRangeIndex = [];
        foreach ($timeCellIndex as $date => $cells) {
            $rangeStart = null;
            $rangeEnd = null;
            $timeRangeIndex[$date] = [];
            for ($i = 0; $i < count($cells); $i++) {
                if (is_null($rangeStart)) {
                    if ($cells[$i]['free']) {
                        $rangeStart = $cells[$i]['start'];
                        $rangeEnd = $cells[$i]['end'];
                    }
                } else {
                    if ($cells[$i]['free']) {
                        if ($rangeEnd === $cells[$i]['start']) {
                            $rangeEnd = $cells[$i]['end'];
                        } else {
                            if (!is_null($rangeStart)) $timeRangeIndex[$date][] = ["start" => $rangeStart, "end" => $rangeEnd];
                            $rangeStart = $cells[$i]['start'];
                            $rangeEnd = $cells[$i]['end'];
                        }
                    } else {
                        if (!is_null($rangeStart)) $timeRangeIndex[$date][] = ["start" => $rangeStart, "end" => $rangeEnd];
                        $rangeStart = null;
                        $rangeEnd = null;
                    }
                }
            }
            if (!is_null($rangeStart)) $timeRangeIndex[$date][] = ["start" => $rangeStart, "end" => $rangeEnd];
        }
        return $timeRangeIndex;
    }


    /** Индексированный по датам массив с доступными вариантами времени для записи,
     * @param array $timeRangeIndex - сюда запихнуть вывод freeRanges
     */
    public static function freeAppointmentsFromRanges(array $timeRangeIndex)
    {
        $availableCells = [];
        foreach ($timeRangeIndex as $date => $cells) {
            $minAppointment = 30; //минимальное время приема, мин.
            $cluster = 5; //шаг округления, мин.
            $availableCells[$date] = [];
            foreach ($cells as $cell) {
                $rangeSize = TimeLines::dayMinute($cell['end']) - TimeLines::dayMinute($cell['start']);
                if ($rangeSize < $minAppointment) continue;
                $pieces = floor($rangeSize / $minAppointment);
                $pieceSize = floor($rangeSize / ($pieces * $cluster)) * $cluster;

                $segment = 0;
                while (($segment + 1) * $pieceSize <= $rangeSize) {
                    $minuteStart = TimeLines::dayMinute($cell['start']) + $segment * $pieceSize;
                    $availableCells[$date][] = floor($minuteStart / 60) . ":" . sprintf("%02d", $minuteStart % 60);
                    $segment++;
                }
            }
        }
        return $availableCells;
    }

    /** Индексированный по датам массив с доступными вариантами времени для записи,
     * сформированный на основе TimelineCells.
     *
     * пример return:
     * [
     *      "01-31-2020"=>["9:30", "10:00", "12:30"],
     *      "02-03-2020"=>[...],
     *      ...
     * ]
     *
     * Зачем это надо:
     * Ячейки, приходящие из API, имеют длительность 5 минут.
     * Свободное время бывает фрагментировано кратно длительности ячеек.
     * А записывать пациентов надо на достаточно длинный свободный интервал.
     * Эти интервалы функция и формирует.
     * @param TimelineCells[] $timeCells
     * @return array
     */
    public static function freeAppointments(array $timeCells): array
    {
        return self::freeAppointmentsFromRanges(
            self::freeRanges(
                self::indexTimeCells($timeCells)
            )
        );
    }


    public static function dayMinute(string $d): int
    {
        $d = trim($d);
        if (preg_match("/^([0-9]{1,2}):([0-9]{1,2})/", $d, $matches)) {
            return (int)$matches[1] * 60 + (int)$matches[2];
        }
        return 0;
    }

}