<?php

/* @var $this yii\web\View */

use app\models\Clinic;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

if ($clinic = Clinic::findOne(Yii::$app->session->get("cid"))) {
    echo $clinic->city;
    echo "<br>";
    foreach ($clinic->persons as $person) {
        echo $person->fullName .": ".$person->primarySpec."<br>";
    }
} else {
    echo "Выберите клинику";
}

?>



