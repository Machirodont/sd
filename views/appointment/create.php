<?php

/* @var $this yii\web\View */

use app\assets\PhoneFormat;
use app\models\Clinic;
use app\models\Persons;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

echo "<h3>Запись на прием</h4>";;
PhoneFormat::register($this);

if ($clinic = Clinic::findOne(Yii::$app->session->get("cid"))) {
    echo "<h4>Выбрана клиника: " . $clinic->city . "</h4>";
    echo Html::a("Изменить выбор клиники ...", ["appointment/create", "cid" => 0]) . "<br>";
    if ($person = Persons::findOne(Yii::$app->request->get('personId'))) {
        $person->currentClinic = $clinic;
        echo "<br>";
        echo "<h4>Выбран специалист: " . $person->fullName . ", " . $person->primarySpec . "</h4>";;
        echo Html::a("Изменить выбор специалиста  ...", ["appointment/create"]) . "<br>";

        if ($day = Yii::$app->request->get('day')) {
            ?>
            <br>
            <h4>Выбран день: <?= $day ?></h4>
            <?= Html::a("Изменить день ...", ["appointment/create", "personId" => $person->person_id]) ?>
            <?= Html::beginForm() ?>
            <br><br>
            +7 <?= Html::input("tel", "phone", "", ["pattern" => "[0-9]*", "id" => "phoneInput"]); ?>
            <button type="submit">Записаться</button>
            <?= Html::endForm() ?>
            <?php
        } else {
            ?>
            <hr>
            <h3>Выберите дату приема:</h3>
            <div class="appoint_clinic_block">
                <?php
                foreach ($person->activeFutureDays as $day) {
                    $d = DateTime::createFromFormat('Y-m-d', $day->day);
                    echo Html::a($d->format('d.m.Y'), ["appointment/create", "personId" => $person->person_id, "day" => $day->day], ["class" => "appoint_clinic"]) . "<br>";
                }
                ?>
            </div>
            <?php
        }
    } else {
        ?>
        <hr>
        <h3>Выберите специалиста:</h3>
        <div class="appoint_clinic_block">
            <?php
            $currentClinic = Clinic::findOne(Yii::$app->session->get("cid"));
            foreach ($clinic->persons as $person) {
                $person->currentClinic = $currentClinic;
                if (is_array($person->activeFutureDays) && count($person->activeFutureDays)) {
                    echo Html::a($person->fullName . "<br>" . $person->primarySpec, ["appointment/create", "personId" => $person->person_id], ["class" => "appoint_clinic"]);
                }
            }
            ?>
        </div>
        <?php
    }
} else {
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
    <?php
}
?>



