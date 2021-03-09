<?php

use app\models\DailyTimeline;
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


            $timeCells = $model->timeCells;
            $timeCellIndex = [];
            $minTime = "23:59:59";
            $maxTime = "00:00:00";
            $timeLines = [];
            if ($timeCells) {
                foreach ($timeCells as $tc) {
                    if (!in_array($tc->timelineId, $timeLines)) {
                        $timeLines[] = $tc->timelineId;
                    }
                    $date = substr($tc->start, 0, strpos($tc->start, " "));
                    if (!array_key_exists($date, $timeCellIndex)) {
                        $timeCellIndex[$date] = [];
                    }
                    $start = substr($tc->start, strpos($tc->start, " ") + 1);
                    $end = substr($tc->end, strpos($tc->end, " ") + 1);
                    $crossLvl = 0;

                    foreach ($timeCellIndex[$date] as $dateToCross) {
                        $isForward = $start >= $dateToCross['end'] && $end >= $dateToCross['end'];
                        $isBack = $start <= $dateToCross['start'] && $end <= $dateToCross['start'];
                        if (($crossLvl === $dateToCross["cross"]) && !($isForward || $isBack)) {
                            $crossLvl = max($crossLvl, ($dateToCross["cross"] + 1));
                        }
                    }

                    $timeCellIndex[$date][] = [
                        "start" => $start,
                        "end" => $end,
                        "free" => $tc->free,
                        "cross" => $crossLvl,
                        "id" => $tc->id,
                    ];
                    $maxTime = ($end > $maxTime) ? $end : $maxTime;
                    $minTime = ($start < $minTime) ? $start : $minTime;
                }
                ksort($timeCellIndex);
            }

            foreach ($timeCellIndex as $date => $cells) {
                usort($timeCellIndex[$date], function ($a, $b) {
                    if ($a["start"] === $b["start"]) return 0;
                    return ($a["start"] < $b["start"]) ? -1 : 1;
                });
            }

            $timeRangeIndex = [];
            foreach ($timeCellIndex as $date => $cells) {
                $rangeStart = null;
                $rangeEnd = null;
                $timeRangeIndex[$date] = [];
                for ($i = 0; $i < count($cells); $i++) {
                    if (is_null($rangeStart)) {
                        if ($cells[$i]['free']) {
                            $rangeStart = $cells[$i]['start'];
                            $rangeEnd = $cells[$i]['end'];
                        }
                    } else {
                        if ($cells[$i]['free']) {
                            if ($rangeEnd === $cells[$i]['start']) {
                                $rangeEnd = $cells[$i]['end'];
                            } else {
                                if (!is_null($rangeStart)) $timeRangeIndex[$date][] = ["start" => $rangeStart, "end" => $rangeEnd];
                                $rangeStart = $cells[$i]['start'];
                                $rangeEnd = $cells[$i]['end'];
                            }
                        } else {
                            if (!is_null($rangeStart)) $timeRangeIndex[$date][] = ["start" => $rangeStart, "end" => $rangeEnd];
                            $rangeStart = null;
                            $rangeEnd = null;
                        }
                    }
                }
                if (!is_null($rangeStart)) $timeRangeIndex[$date][] = ["start" => $rangeStart, "end" => $rangeEnd];
            }
            echo json_encode($timeRangeIndex);


            function dayMinute(string $d)
            {
                if (preg_match("/([0-9]{1,2}):([0-9]{1,2}):[0-9]{1,2}/", $d, $matches)) {
                    return (int)$matches[1] * 60 + (int)$matches[2];
                }
                return 0;
            }

            $minuteDayStart = dayMinute($minTime);
            $minuteDayEnd = dayMinute($maxTime);
            echo "<hr><table class='table small'>";
            foreach ($timeCellIndex as $date => $cells) {
                echo "<tr><td>" . $date . "</td><td><div style='width:" . ($minuteDayEnd - $minuteDayStart) . "px; border:solid 1px red; height:20px; position: relative;'>";
                $odd = false;
                foreach ($cells as $cell) {
                    $odd = !$odd;
                    $color = "hsl(" . ($cell['free'] ? "100" : "0") . ", 100%, " . ($odd ? "60" : "70") . "%)";
                    $left = dayMinute($cell['start']) - $minuteDayStart;
                    $width = (dayMinute($cell['end']) - dayMinute($cell['start']));
                    echo "<div style='top:" . ($cell['cross'] * 10) . "px; background-color: " . $color . "; height: 10px; width: " . $width . "px; left:" . $left . "px; position: absolute' title='" . $cell['start'] . "-" . $cell['end'] . " [" . $cell['id'] . "]'> </div>";
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
