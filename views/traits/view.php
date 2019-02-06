<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Traits */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Traits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="traits-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->trait_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->trait_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'trait_id',
            'person_id',
            'title:ntext',
            'description:ntext',
            'institution_id',
        ],
    ]) ?>

</div>
