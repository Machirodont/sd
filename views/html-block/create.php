<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\HtmlBlock */

$this->title = 'Create Html Block';
$this->params['breadcrumbs'][] = ['label' => "Блоки", 'url' => "/html-block/index"];
$this->params['breadcrumbs'][] = ['label' => Url::toRoute($model->entityRoute), 'url' => $model->entityRoute];
$this->params['breadcrumbs'][] = 'Добавление блока';
?>
<div class="html-block-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
