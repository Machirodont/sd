<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\HtmlBlock;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Блоки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="html-block-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'itemKey',
            'itemTable:ntext',
            'order:ntext',
            [
                'label' => 'Page',
                'content' => function (HtmlBlock $model) {
                    return Html::a(Url::toRoute($model->entityRoute), $model->entityRoute);
                }

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>
</div>
