<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;


/* @var $this yii\web\View */
/* @var $model app\models\Persons */
/* @var $clinic \app\models\Clinic */

$this->title = $model->fullname;
if ($model->currentClinic) $this->params['breadcrumbs'][] = ['label' => $model->currentClinic->city, 'url' => ['/clinic/contacts', "cid" => $model->currentClinic->id]];
$this->params['breadcrumbs'][] = ['label' => 'Доктора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$mainSpecialization = isset($model->traits["специальность"]) && isset($model->traits["специальность"][0])
    ? mb_convert_case($model->traits["специальность"][0]->description, MB_CASE_TITLE)
    : "";


?>
<div class="persons-view row">


    <div class="row">
        <div class="col-sm-4 portrait">
            <?= Html::img($model->portraitUrl, [
                'title' => $mainSpecialization . " " . $model->fullname
            ]) ?>
        </div>
        <div class="col-sm-8" style="color:lightgrey;<?php //ToDo?>">
            <h1><?= $model->fullname ?></h1>
            <h2>
                <?= $model->traitString("специальность") ?>
            </h2>
            <?php if (!is_null($model->education)): ?>
                <p>
                    Образование: <?= $model->education0->name ?>
                </p>
            <?php endif; ?>
            <?php
            if (count($model->clinics) > 0) {
                echo "Ведет прием в отделениях: ";
                for ($i = 0; $i < count($model->clinics); $i++) {
                    if ($i > 0) echo ", ";
                    echo Html::a($model->clinics[$i]->city, ["clinic/contacts", "cid" => $model->clinics[$i]->id]);
                }
                echo "<br>Смотреть расписание отделении: ";
                for ($i = 0; $i < count($model->clinics); $i++) {
                    if ($i > 0) echo ", ";
                    echo Html::a($model->clinics[$i]->city, ["persons/view", "id" => $model->person_id, "cid" => $model->clinics[$i]->id]);
                }
            }
            ?>
            <hr>
            <?php
            //Календарь приема
            if ($model->timeLine) {
                $activeDays = $model->timeLine->activeDays;
                $dateCounter = new DateTime(date("Ymd"));
                $dateCounter = new DateTime("2018-12-15");
                $nowWeekDay = intval($dateCounter->format("N"));
                $dateCounter->sub(new DateInterval('P' . ($nowWeekDay - 1) . 'D'));
                $yesterdayMonth = "";
                $interval = new DateInterval('P1D');
                for ($i = 0; $i < (7 * 2); $i++) {
                    if ($yesterdayMonth !== $dateCounter->format("m")) {
                        echo $dateCounter->format("F");
                        echo "<table class=\"table\">";
                        if ($dateCounter->format("N") !== "1") {
                            echo "<td style='border:none;' colspan='" . (intval($dateCounter->format("N")) - 1) . "'> </td>";
                        }
                    }
                    if ($dateCounter->format("N") === "1") echo "<tr>";
                    ?>
                    <td class="text-center <?= array_key_exists($dateCounter->format("Y-m-d"), $activeDays) ? "success" : ""; ?>"> <?= $dateCounter->format("j"); ?></td>
                    <?php
                    if ($dateCounter->format("N") === "7") echo "</tr>";
                    if ($dateCounter->format("j") === $dateCounter->format("t")) echo "</table>";
                    $yesterdayMonth = $dateCounter->format("m");
                    $dateCounter->add($interval);
                }
            }
            ?>

            <?php
            if (false && $model->timeLine && is_array($model->timeLine->days)) {
                foreach ($model->timeLine->days as $day) {
                    /**@var $day \app\models\TimelineDays */
                    ?>
                    <tr class="<?= $day->is_active ? "success" : "" ?>">
                        <td><?= $day->day ?></td>
                        <td><?= $day->is_active ? "Принимает" : "" ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            </table>

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
