<?php

/* @var $this yii\web\View */

use app\models\Clinic;
use app\models\Persons;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

echo "<h3>Запись на прием</h4>";;

if ($clinic = Clinic::findOne(Yii::$app->session->get("cid"))) {
    echo "<h4>Выбрана клиника: " . $clinic->city . "</h4>";;
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
            +7 <?= Html::input("tel", "phone", "", ["pattern" => "[0-9]*"]); ?>
            <button type="submit">Записаться</button>
            <?= Html::endForm() ?>
            <?php
        } else {
            ?>
            <div class="appoint_clinic_block">
                <?php
                foreach ($person->activeDays as $day) {
                    echo Html::a($day->day, ["appointment/create", "personId" => $person->person_id, "day" => $day->day]) . "<br>";
                }
                ?>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="appoint_clinic_block">
            <?php
            foreach ($clinic->persons as $person) {
                echo Html::a($person->fullName . "<br>" . $person->primarySpec, ["appointment/create", "personId" => $person->person_id], ["class" => "appoint_clinic"]);
            }
            ?>
        </div>
        <?php
    }
} else {
    ?>
    Выберите клинику:
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



