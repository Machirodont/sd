<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Institutions */

$this->title = 'Редактировать данные учреждения: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Учреждения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->institution_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="institutions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
