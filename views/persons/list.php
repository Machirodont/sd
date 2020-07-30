<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $personsDataProvider yii\data\ActiveDataProvider */
?>
<div class="persons-list">
    <?= GridView::widget([
        'dataProvider' => $personsDataProvider,
        'columns' => [
            'person_id',
            'lastname',
            'firstname',
            'patronymic',
            'removed',
            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<i class="glyphicon glyphicon-pencil"></i>',
                            ['/persons/edit', 'id' => $model->person_id],
                            ['class' => 'btn btn-link', 'title' => 'Редактировать']
                        ) ;
                    },
                ],
                'template' => '{changePass} {update}',
            ],
        ]
    ]); ?>
</div>
