<?php

use yii\helpers\Html;


/* @var $this yii\web\View */

$this->title = $model->fullname;
if ($model->currentClinic) $this->params['breadcrumbs'][] = ['label' => $model->currentClinic->city, 'url' => ['/clinic/contacts', "cid" => $model->currentClinic->id]];
$this->params['breadcrumbs'][] = ['label' => 'Доктора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

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
                echo $this->render('_calendar', [
                    "startDay" => date("Y-m-d"),
                    "period" => 7*3,
                    "activeDays" => $model->timeLine->activeDays
                ]);
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
    <?= $model->htmlDescription; ?>
</div>
