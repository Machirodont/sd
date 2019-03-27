<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;


/* @var $this yii\web\View */
/* @var $model app\models\Persons */
/* @var $clinic \app\models\Clinic */

$this->registerLinkTag(['rel' => 'canonical', 'href' => \yii\helpers\Url::to(["view", "id" => $model->person_id], true),]);

$this->title = $model->fullname;
if ($model->currentClinic) $this->params['breadcrumbs'][] = ['label' => $model->currentClinic->city, 'url' => ['/clinic/contacts', "cid" => $model->currentClinic->id]];
$this->params['breadcrumbs'][] = ['label' => 'Доктора', 'url' => ['index', "cid" => Yii::$app->session->get("cid")]];
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
        <div class="col-sm-8">
            <h1><?= $model->fullname ?></h1>
            <h2>
                <?= $model->traitString("специальность") ?>
            </h2>
            <?php if (!is_null($model->education)): ?>
                <p>
                    Образование: <?= $model->education0->name ?>
                </p>
            <?php endif; ?>

            <p>
            <?php
            echo implode("<br>", $model->workExperiences);
            ?>
            </p>


            <?php if (!is_null($model->years_work)): ?>
                <p>
                    Имеет <?= $model->yearsWorkString ?> опыта.
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
                    "period" => 7 * 3,
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

    <?php echo $model->htmlDescription; ?>
</div>
