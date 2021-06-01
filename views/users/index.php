<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'login:ntext',
            [
                'label' => 'админ',
                'content' => function (\app\models\Users $user) {
                    return $user->is_admin ? 'да' : 'нет';
                }
            ],
            [
                'label' => 'клиники',
                'content' => function (\app\models\Users $user) {
                    return array_reduce($user->clinicList, function ($textList, \app\models\Clinic $clinic) {
                        if (!$textList) return $clinic->city;
                        return $textList . ", " . $clinic->city;
                    }, "");
                }

            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
