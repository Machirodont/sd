<?php

/* @var $this yii\web\View */

use app\models\Clinic;
use app\models\Persons;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

if ($clinic = Clinic::findOne(Yii::$app->session->get("cid"))) {
    echo $clinic->city . "<br>";;
    echo Html::a("Другая клиника ...", ["site/appointment", "cid" => 0]) . "<br>";
    if ($person = Persons::findOne(Yii::$app->request->get('personId'))) {
        $person->currentClinic = $clinic;
        echo "<br>";
        echo $person->fullName . "<br>";
        echo Html::a("Другой врач ...", ["site/appointment"]) . "<br>";

        if ($day = Yii::$app->request->get('day')) {
            ?>
            <br>
            <?= $day ?>
            <br>
            <?= Html::a("Другой день ...", ["site/appointment", "personId" => $person->person_id]) ?>
            <br>
            <?= Html::beginForm() ?>
            +7 <?= Html::input("tel", "phone", "", ["pattern" => "[0-9]*"]); ?>
            <button type="submit">Записаться</button>
            <?= Html::endForm() ?>
            <?php
        } else {
            foreach ($person->activeDays as $day) {
                echo Html::a($day->day, ["site/appointment", "personId" => $person->person_id, "day" => $day->day]) . "<br>";
            }
        }
    } else {
        foreach ($clinic->persons as $person) {
            echo Html::a($person->fullName . ": " . $person->primarySpec, ["site/appointment", "personId" => $person->person_id]) . "<br>";
        }
    }
} else {
    echo "Выберите клинику";
}

?>



