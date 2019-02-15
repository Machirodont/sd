<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $clinic \app\models\Clinic|null */

$this->title = "Врачи" . (is_object($clinic) ? " - " . $clinic->city : "");
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persons-index">

    <h1>«Столичная диагностика»<?= (is_object($clinic) ? " - " . $clinic->city : "") ?></h1>
    <h2>Врачи</h2>

    <?php
    $persons = $dataProvider->models;
    foreach ($persons as $person) {
        echo $this->render('_card', [
            'model' => $person,
        ]);
    }
    ?>


    <hr>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'person_id',
            'firstname:ntext',
            'lastname:ntext',
            'patronymic:ntext',
            'education',
            //'years_work',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <p>
        <?= Html::a('Create Persons', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
