<?php

/* @var $this yii\web\View
 */

use app\assets\PhoneFormat;
use app\models\Clinic;
use yii\helpers\Html;

?>

<h3>Выберите клинику:</h3>
<div class="appoint_clinic_block">
    <?php
    $clinics = Clinic::find()->where(["not", ["phone" => null]])->all();
    foreach ($clinics as $clinic) {
        /* @var Clinic $clinic */
        echo Html::a("Клиника " . $clinic->in, ["appointment/create", "cid" => $clinic->id], ["class" => "appoint_clinic"]);
    }
    ?>
</div>




