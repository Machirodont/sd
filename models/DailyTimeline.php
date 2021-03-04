<?php


namespace app\models;


class DailyTimeline
{

    public $day = null;//"2020-01-01"
    public $timelineId = null;
    public $cells = [];

    public function __construct($day, int $timelineId)
    {
        $this->day = $day;
        $this->timelineId = $timelineId;
        //ToDo проверка на корректность $day и существование timeline
        $loadedCells = TimelineCells::find()
            ->where(['and',
                ["timelineId" => $this->timelineId],
                ['>=', 'start', $day . " 00:00:00"],
                ['<=', 'end', $day . " 23:59:59"]
            ])->all();
        $this->cells = array_map(function (TimelineCells $cell) {
            return [
                'id' => $cell->id,
                'start' => substr($cell->start, strpos($cell->start, " ") + 1, -3),
                'end' => substr($cell->end, strpos($cell->end, " ") + 1, -3),
                'free' => $cell->free,
                'removed' => false
            ];
        }, $loadedCells);
    }

    /**
     * @param string $time_start "09:05"
     * @param string $time_end "09:15"
     * @param bool $free
     */
    public function add(string $time_start, string $time_end, bool $free)
    {
        //ToDo проверка на корректность входящих значений
        $newCells = [];
        foreach ($this->cells as $i=>$cell) {
            if ($this->cells[$i]['removed']) continue;

            if ($cell['start'] >= $time_start && $cell['end'] <= $time_end) {
                $this->cells[$i]['removed'] = true;
            }

            if ($cell['start'] < $time_end && $cell['end'] > $time_end) {
                $this->cells[$i]['removed'] = true;
                $newCells[] = [
                    'id' => null,
                    'start' => $time_end,
                    'end' => $cell['end'],
                    'free' => $cell['free'],
                    'removed' => false
                ];
            }

            if ($cell['start'] < $time_start && $cell['end'] > $time_start) {
                $this->cells[$i]['removed'] = true;
                $newCells[] = [
                    'id' => null,
                    'start' => $cell['start'],
                    'end' => $time_start,
                    'free' => $cell['free'],
                    'removed' => false
                ];
            }
        }

        $newCells[] = [
            'id' => null,
            'start' => $time_start,
            'end' => $time_end,
            'free' => $free,
            'removed' => false
        ];

        $this->cells = array_merge($this->cells, $newCells);
    }

    public function save()
    {

    }
}