<?php

use app\models\Persons;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $personsDataProvider yii\data\ActiveDataProvider */
/* @var $showRemoved bool */
$this->params['breadcrumbs'][] = ['label' => 'Доктора'];

$gridColumns = [
    'person_id',
    'lastname',
    'firstname',
    'patronymic',
    ['class' => 'yii\grid\ActionColumn',
        'buttons' => [
            'update' => function ($url, Persons $model) {
                return Html::a(
                    '<i class="glyphicon glyphicon-pencil"></i>',
                    ['/persons/edit', 'id' => $model->person_id],
                    ['class' => 'btn btn-link', 'title' => 'Редактировать']
                );
            },
            'photo' => function ($url, Persons $model) {
                return Html::a(
                    '<i class="glyphicon glyphicon-camera"></i>',
                    ['/persons/load-photo', 'id' => $model->person_id],
                    ['class' => 'btn btn-link', 'title' => 'Фотография']
                );
            },
            'delete' => function ($url, Persons $model) {
                return Html::a(
                    '<i class="glyphicon glyphicon-' . ($model->removed ? 'export' : 'trash') . '"></i>',
                    [$model->removed ? '/persons/restore' : '/persons/delete', 'id' => $model->person_id],
                    ['class' => 'btn btn-link', 'title' => $model->removed ? 'Восстановить' : 'Удалить',
                        'data' => [
                            'method' => 'POST',
                            'confirm' => 'Вы уверены, что хотите ' . ($model->removed ? 'восстановить' : 'удалить') . ' ' . $model->fullName . '?'
                        ]
                    ]
                );
            },
        ],
        'template' => '{update} {photo} {delete}',
    ],
];
if ($showRemoved) {
    $gridColumns[] = 'removed';
}

?>
<div class="persons-list">
    <?= Html::a("Создать нового", ["/persons/edit"], ['class' => 'btn btn-success']) ?>
    <?= Html::a($showRemoved ? "Скрыть удаленных" : 'Показать удаленных'
        , $showRemoved ? ["/persons/list"] : ["/persons/list", 'showRemoved' => true]
        , ['class' => 'btn btn-info']
    ) ?>
    <?= GridView::widget([
        'dataProvider' => $personsDataProvider,
        'columns' => $gridColumns
    ]); ?>
</div>
