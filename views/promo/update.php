<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Promo */

$this->title = 'Редактирование промо: #' . $model->id." ".$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Promos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "#" . $model->id . " " . $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="promo-update">

    <h1>Редактирование промо #<?= $model->id ?> </h1>

    <?= $this->render('_form', [
        'model' => $model,
        'avaliableClinics' => $avaliableClinics,
    ]) ?>

</div>
