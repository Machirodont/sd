<?php

/* @var $this yii\web\View
 * @var $person Persons
 * @var $day string
 */

use app\models\Persons;
use yii\helpers\Html;

?>

<hr>
<h3>Выберите дату приема:</h3>
<div class="appoint_clinic_block">
    <?php
    foreach ($person->activeFutureDays as $tlDay) {
        $d = DateTime::createFromFormat('Y-m-d', $tlDay->day);
        echo Html::a($d->format('d.m.Y'), ["appointment/create", "personId" => $person->person_id, "day" => $tlDay->day], ["class" => "appoint_clinic"]) . "<br>";
    }
    ?>
</div>





