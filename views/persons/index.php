<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $clinic \app\models\Clinic|null */

$this->registerLinkTag(['rel' => 'canonical', 'href' => \yii\helpers\Url::to(["index"], true),]);

$this->title = "Врачи" . (is_object($clinic) ? " - " . $clinic->city : "");
if (is_object($clinic)) $this->params['breadcrumbs'][] = ['label' => $clinic->city, 'url' => ['/clinic/contacts', "cid" => $clinic->id]];
$this->params['breadcrumbs'][] = "Врачи";
?>
<div class="persons-index">

    <h2>Врачи медицинского центра «Столичная диагностика»<?= (is_object($clinic) ? " - " . $clinic->city : "") ?></h2>

    <div style="display:flex; flex-wrap: wrap">
              <?php
            $persons = $dataProvider->models;
            foreach ($persons as $person) {
                echo $this->render('_card', [
                    'model' => $person,
                ]);
            }
            ?>
    </div>
</div>
