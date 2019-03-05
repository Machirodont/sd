<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Persons */
/* @var $institutionsList app\models\Institutions[] */

$this->title = 'Update Persons: ' . $model->person_id;
$this->params['breadcrumbs'][] = ['label' => 'Persons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullname, 'url' => ['view', 'id' => $model->person_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="persons-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'institutionsList' => $institutionsList,
    ]) ?>



</div>
