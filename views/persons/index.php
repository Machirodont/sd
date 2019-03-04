<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $clinic \app\models\Clinic|null */

$this->title = "Врачи" . (is_object($clinic) ? " - " . $clinic->city : "");
if (is_object($clinic)) $this->params['breadcrumbs'][] = ['label' => $clinic->city, 'url' => ['/clinic/contacts', "cid" => $clinic->id]];
$this->params['breadcrumbs'][] = "Врачи";
?>
<div class="persons-index">

    <h1>«Столичная диагностика»<?= (is_object($clinic) ? " - " . $clinic->city : "") ?></h1>
    <h2>Врачи</h2>

    <div style="display:flex; flex-wrap: wrap">
              <?php
            $persons = $dataProvider->models;
            foreach ($persons as $person) {
                echo $this->render('_card', [
                    'model' => $person,
                ]);
            }
            ?>
    </div>

    <!--hr>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'person_id',
            'firstname:ntext',
            'lastname:ntext',
            'patronymic:ntext',
            'education',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <p>
        <?= Html::a('Create Persons', ['create'], ['class' => 'btn btn-success']) ?>
    </p-->
</div>
