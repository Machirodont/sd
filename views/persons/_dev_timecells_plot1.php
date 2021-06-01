<?php

/** Визуализация рабочего времени, применяется для тестирования и отладки
 * @var TimelineCells[] $timeCells
 * @var \app\models\Persons $model
 */

use app\models\TimelineCells;
use app\models\TimeLines;
?>
<div class='shadow_box'>
    <?php
    $freeCells = TimeLines::freeAppointments($model->timeCells);
    foreach ($freeCells as $date => $cells) {
        if (count($cells) > 0) {
            echo $date . "<div style='display: flex; flex-wrap: wrap'>";
            foreach ($cells as $cell) {
                echo "<a style='display:block; cursor:pointer; margin: 2px; padding: 2px 5px; background-color: rgb(223, 240, 216); border-radius: 5px; font-size: 14px'>" . $cell . "</a>";
            }
            echo "</div><hr>";
        }
    }
    ?>
</div>


