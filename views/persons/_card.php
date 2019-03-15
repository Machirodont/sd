<?php
use yii\helpers\Html;
use \yii\helpers\Url;
use app\models\Persons;

/* @var $this yii\web\View */
/* @var $model Persons */
?>

<a href="<?= Url::toRoute(["persons/view", "id"=>$model->person_id]) ?>" class="person_card">
    <h4><?= $model->primarySpec ?></h4>
    <?= Html::img($model->portraitUrl, [
    ]) ?>
    <div><nobr><?= $model->fullname ?></nobr></div>
    <div><?= $model->secondarySpecs ?></div>
</a>
