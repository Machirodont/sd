<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \app\models\Promo;
use \app\models\Clinic;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Promos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Promo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'content' => function (Promo $promo) {
                    if (!$promo->fileName) return "<span class=\"not-set\">(not set)</span>";
                    return Html::img("/images/promo/" . $promo->fileName, ["style"=>"max-width:300px;"]);
                }
            ],
            'title:ntext',
            'startDate',
            'endDate',
            [
                "label" => "Клиники",
                'content' => function (Promo $promo) {
                    return implode(", ",
                        ArrayHelper::getColumn(
                            Clinic::find()->where(["id" => json_decode($promo->clinics)])->all(),
                            "city"
                        )
                    );
                }
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
