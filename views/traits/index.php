<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TraitsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Traits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="traits-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Traits', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'trait_id',
            'person_id',
            'title:ntext',
            'description:ntext',
            'institution_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
