<?php

use yii\bootstrap\Carousel;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Promo */

$this->title = $model->title;
?>
<?php
if (!Yii::$app->user->isGuest) {
    ?>
    <div class="align-right">
        <?= Html::a("Редактировать", ["promo/update", "id" => $model->id], ["class" => "btn btn-success"]) ?>

    </div>
    <hr>
    <?php
}
?>
<div class="promo-view">
    <h1><?= Html::encode($model->title) ?></h1>
    <div class="promo_dates">

        <?php
        if ($model->startDate && $model->endDate) {
            echo "Действует c " . $model->startDate . ' по ' . $model->endDate;
        } elseif ($model->startDate) {
            echo "Действует c " . $model->startDate;

        } elseif ($model->endDate) {
            echo "Действует до " . $model->endDate;

        } else {
            if (!Yii::$app->user->isGuest) {
                echo "Ограничения по срокам не указаны";
            }
        }
        ?>
    </div>

    <div class="promopic_wrapper">
        <?= Html::img("/images/promo/" . $model->fileName, ["class" => "promo_picture"]) ?>
    </div>
    <?= stripslashes($model->html) ?>

</div>
