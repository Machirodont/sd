<?php

use yii\helpers\Html;
use \yii\helpers\Url;
use app\models\Persons;

/* @var $this yii\web\View */
/* @var $model Persons */
?>

<a href="<?= Url::toRoute(["persons/view", "id" => $model->person_id, "cid" => Yii::$app->session->get("cid")]) ?>"
   class="ext_person_card">
    <h4>
        <nobr><?= $model->primarySpec ?></nobr>
    </h4>
    <div class="person_card_content">
        <div>
            <?= Html::img($model->portraitUrl, []) ?>
        </div>
        <div>
            <?= $model->fullname ?><br>
            <small><?= $model->secondarySpecs ?></small>
        </div>
    </div>
    <div>
        <small><b><?= implode("<br>", $model->workExperiences); ?></b></small>
    </div>

</a>
