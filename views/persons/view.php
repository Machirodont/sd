<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use \app\helpers\Extra;


/* @var $this yii\web\View */
/* @var $model app\models\Persons */
/* @var $clinic \app\models\Clinic */

$this->registerLinkTag(['rel' => 'canonical', 'href' => \yii\helpers\Url::to(["view", "id" => $model->person_id], true),]);

$primarySpec = mb_substr($model->primarySpec, 0, 1) . mb_strtolower(mb_substr($model->primarySpec, 1));
$personClinics = $model->clinics;
$where = Extra::implodeField($personClinics, "in", ", ");
if (count($personClinics) == 1) $where = "медцентр " . $where;
if (count($personClinics) > 1) $where = "медцентры " . $where;

$this->title = $primarySpec . " " . $model->fullname . " " . $model->secondarySpecs . " - " . $where . " \"Столичная Диагностика\"";
$this->registerMetaTag(["name" => "description", "content" => $this->title]);
$keywords = $primarySpec . ($model->secondarySpecs ? ", " . $model->secondarySpecs : "") . ", " . Extra::implodeField($personClinics, "city", ", ") . ", медицинский центр столичная диагностика";
$this->registerMetaTag(["name" => "keywords", "content" => $keywords]);

if ($model->currentClinic) $this->params['breadcrumbs'][] = ['label' => $model->currentClinic->city, 'url' => ['/clinic/contacts', "cid" => $model->currentClinic->id]];
$this->params['breadcrumbs'][] = ['label' => 'Доктора', 'url' => ['index', "cid" => Yii::$app->session->get("cid")]];
$this->params['breadcrumbs'][] = $model->fullname . ", " . $primarySpec;;

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
                echo "<br>Смотреть расписание специалиста: ";
                for ($i = 0; $i < count($model->clinics); $i++) {
                    $isCurrentClinc = $model->currentClinic && $model->clinics[$i]->id === $model->currentClinic->id;
                    echo Html::a("<nobr>" . $model->clinics[$i]->in . "</nobr>", ["persons/view", "id" => $model->person_id, "cid" => $model->clinics[$i]->id], ["class" => 'clinic_select' . ($isCurrentClinc ? " current" : "")]);
                }
                echo "<div class='shadow_box'>";
                //Календарь приема
                $today = (new DateTime())->sub(new DateInterval("P1D"));
                $after2weeks = (new DateTime())->add(new DateInterval("P14D"));
                if ($model->currentClinic) {
                    if ($model->searchActiveDays($today, $after2weeks)) {
                        echo $this->render('_calendar', [
                            "startDay" => date("Y-m-d"),
                            "period" => 7 * 2,
                            "activeDays" => $model->searchActiveDays($today, $after2weeks)
                        ]);
                    } else {
                        echo "Индивидуальная запись. Звоните <a href=\"tel:" . $model->currentClinic->phone . "\">" . $model->currentClinic->phone . "</a>";
                    }
                }
                echo "</div>";
            }

            /*
            if ($model->timeCells) {
                echo "<hr><table class='table small'>";
                $prevTc = $model->timeCells[0];
                foreach ($model->timeCells as $tc) {
                    $style = "";
                    if ($tc->start !== $prevTc->end) $style = "color:red; ";
                    if ($tc->free) $style .= "background-color:#EEE;";
                    $prevTc = $tc;
                    echo "<tr style='$style'><td>" . $tc->timelineId . "</td><td>" . $tc->start . "</td><td>" . $tc->end . "</td><td>" . $tc->source . "</td></tr>";
                }
                echo "</table>";
            }
            */

            ?>

            <?php
            if (false && $model->activeDays && is_array($model->activeDays)) {
                foreach ($model->activeDays as $day) {
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

        </div>
    </div>

    <?php echo $model->htmlDescription; ?>
</div>
