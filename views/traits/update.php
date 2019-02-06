<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Traits */

$this->title = 'Update Traits: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Traits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->trait_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="traits-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
