<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\HtmlBlock */

$this->title = 'Update Html Block: ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => "Блоки", 'url' => "/html-block/index"];
$this->params['breadcrumbs'][] = ['label' => Url::toRoute($model->entityRoute), 'url' =>$model->entityRoute];
$this->params['breadcrumbs'][] = 'Редактирование блока #'.$model->id;
?>
<div class="html-block-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
