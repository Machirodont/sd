<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;


/* @var $this yii\web\View */
/* @var $model app\models\Persons */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Доктора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="persons-view row">


    <div class="row">
        <div class="col-sm-4 portrait">
            <?= Html::img($model->portraitUrl, [
                'title' => mb_convert_case($model->traits["специальность"][0]->description, MB_CASE_TITLE) . " " . $model->fullname
            ]) ?>
        </div>
        <div class="col-sm-8" style="color:lightgrey;<?php //ToDo?>">
            <h1><?= $model->fullname ?></h1>
            <h2>
                <?php
                if (is_array($model->traits["специальность"])) {
                    for ($i = 0; $i < count($model->traits["специальность"]); $i++) {
                        if ($i > 0) echo ", ";
                        echo $model->traits["специальность"][$i]->description;
                    }
                }
                ?>
            </h2>
            <?php if (!is_null($model->education)): ?>
                <p>
                    Образование: <?= $model->education0->name ?>
                </p>
            <?php endif; ?>
            <?php
            if(count($model->clinics)>0) {
                echo "Ведет прием в отделениях: ";
                for ($i = 0; $i < count($model->clinics); $i++) {
                    if ($i > 0) echo ", ";
                    echo Html::a($model->clinics[$i]->city, ["clinic/contacts", "cid"=>$model->clinics[$i]->id]);
                }
            }

            ?>
        </div>
    </div>
    <hr>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->person_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->person_id], [
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
            'person_id',
            'firstname:ntext',
            'lastname:ntext',
            'patronymic:ntext',
            [
                'attribute' => 'education0.name',
                'label' => 'Образование'
            ],
            'years_work',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $model->allTraits,
        ]),
        'columns' => [
            'trait_id',
            'title:ntext',
            'description:ntext',
            'institution_id',

        ],
    ]); ?>

</div>
