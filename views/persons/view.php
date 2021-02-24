<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use \app\helpers\Extra;


/* @var $this yii\web\View */
/* @var $model app\models\Persons */

$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(["view", "id" => $model->person_id], true),]);

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

            <?= !Yii::$app->user->isGuest ? Html::a("Редактировать профиль врача", ["/persons/edit", "id" => $model->person_id], ["class" => "btn btn-warning"]) : ""; ?>

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

            //            $timeCells=$model->findTimeCells("2020-07-31");
            $timeCells = $model->timeCells;
            /*
                if ($timeCells) {
                    echo "<hr><table class='table small'>";
                    $prevTc = $timeCells[0];
                    foreach ($timeCells as $tc) {
                        $style = "";
                        if ($tc->start !== $prevTc->end
                            && substr($tc->start, 0, 10) === substr($prevTc->start, 0, 10)
                        ) $style = "color:red; ";
                        if ($tc->free) $style .= "background-color:#EEE;";
                        $prevTc = $tc;
                        echo "<tr style='$style'><td>" . $tc->timelineId . "</td><td>" . $tc->start . "</td><td>" . $tc->end . "</td><td>" . $tc->source . "</td></tr>";
                    }
                    echo "</table>";
                }
                */


            $timeCellIndex = [];
            if ($timeCells) {
                foreach ($timeCells as $tc) {
                    $date = substr($tc->start, 0, strpos($tc->start, " "));
                    if (!array_key_exists($date, $timeCellIndex)) {
                        $timeCellIndex[$date] = [];
                    }
                    $timeCellIndex[$date][] = [
                        "start" => substr($tc->start, strpos($tc->start, " ")),
                        "end" => substr($tc->end, strpos($tc->end, " "))
                    ];
                }
                ksort($timeCellIndex);
            }

            function dayMinute(string $d)
            {
                if (preg_match("/([0-9]{1,2}):([0-9]{1,2}):[0-9]{1,2}/", $d, $matches)) {
                    return (int)$matches[1] * 60 + (int)$matches[2];
                }
                return 0;
            }

            echo "<hr><table class='table small'>";
            foreach ($timeCellIndex as $date => $cells) {
                echo "<tr><td>" . $date . "</td><td><div style='width:1440px; border:solid 1px red; height:20px; position: relative;'>";
                $odd = false;
                foreach ($cells as $cell) {
                    $odd = !$odd;
                    echo "<div style='background-color: " . ($odd ? "green" : "blue") . "; height: 10px; width: " . (dayMinute($cell['end']) - dayMinute($cell['start'])) . "px; left:" . dayMinute($cell['start']) . "px; position: absolute' title='".$cell['start']."-".$cell['end']."'> </div>";

                }
                echo "</div></td></tr>";
            }
            echo "</table>";

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
