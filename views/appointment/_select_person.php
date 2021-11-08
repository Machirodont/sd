<?php

/* @var $this yii\web\View
 * @var $clinic Clinic
 * @var $person Persons
 */

use app\assets\PhoneFormat;
use app\models\Clinic;
use app\models\Persons;
use yii\helpers\Html;

?>

<hr>
<h3>Выберите специалиста:</h3>
<div class="appoint_clinic_block">
    <?php
    foreach ($clinic->persons as $person) {
        $person->currentClinic = $clinic;
        if (is_array($person->activeFutureDays) && count($person->activeFutureDays)) {
            echo Html::a($person->fullName . "<br>" . $person->primarySpec, ["appointment/create", "personId" => $person->person_id], ["class" => "appoint_clinic"]);
        }
    }
    ?>
</div>




