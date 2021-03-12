<?php

/** Визуализация рабочего времени, применяется для тестирования и отладки
 * @var TimelineCells[] $timeCells
 */

use app\models\TimelineCells;
use app\models\TimeLines;

$timeCellIndex = TimeLines::indexTimeCells($timeCells, true);
$timeRangeIndex = TimeLines::freeRanges($timeCellIndex);
$availableCells = TimeLines::freeAppointmentsFromRanges($timeRangeIndex);

$dayStart = "23:59:59";
$dayEnd = "00:00:00";
foreach ($timeCellIndex as $date => $cells) {
    foreach ($cells as $cell) {
        if ($dayStart > $cell["start"]) $dayStart = $cell["start"];
        if ($dayEnd < $cell["end"]) $dayEnd = $cell["end"];
        if($cell["cross"]) echo "ПЕРЕСЕЧЕНИЕ ИНТЕРВАЛОВ<br>";
    }
}

$minuteDayStart = TimeLines::dayMinute($dayStart);
$minuteDayEnd = TimeLines::dayMinute($dayEnd);
echo "<hr><table class='table small'>";
foreach ($timeCellIndex as $date => $cells) {
    echo "<tr><td>" . $date . "</td><td><div style='width:" . ($minuteDayEnd - $minuteDayStart) . "px; border:solid 1px red; height:36px; position: relative;'>";
    $odd = false;
    foreach ($cells as $cell) {
        $odd = !$odd;
        $color = "hsl(" . ($cell['free'] ? "100" : "0") . ", 100%, " . ($odd ? "60" : "70") . "%)";
        $left = TimeLines::dayMinute($cell['start']) - $minuteDayStart;
        $width = (TimeLines::dayMinute($cell['end']) - TimeLines::dayMinute($cell['start']));
        echo "<div style='top:" . ($cell['cross'] * 10) . "px; background-color: " . $color . "; height: 10px; width: " . $width . "px; left:" . $left . "px; position: absolute' title='" . $cell['start'] . "-" . $cell['end'] . " [" . $cell['id'] . "]'> </div>";
    }

    foreach ($timeRangeIndex[$date] as $cell) {
        $color = "hsl(100 , 100%, 30%)";
        $left = TimeLines::dayMinute($cell['start']) - $minuteDayStart;
        $width = (TimeLines::dayMinute($cell['end']) - TimeLines::dayMinute($cell['start']));
        echo "<div style='top:" . (13) . "px; background-color: " . $color . "; height: 10px; width: " . $width . "px; left:" . $left . "px; position: absolute' title='" . $cell['start'] . "-" . $cell['end'] . "'> </div>";
    }

    foreach ($availableCells[$date] as $cell) {
        $odd = !$odd;
        $color = "hsl( 40 , 100%, " . ($odd ? "60" : "70") . "%)";
        $left = TimeLines::dayMinute($cell) - $minuteDayStart;
        $width = 5;
        echo "<div style='top:" . (23) . "px; background-color: " . $color . "; border:solid 1px #ff7a7a;  height: 10px; width: " . $width . "px; left:" . $left . "px; position: absolute' title='" . $cell . "'> </div>";
    }
    echo "</div></td></tr>";
}
echo "</table>";