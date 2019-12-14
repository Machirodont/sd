<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Promo */

$this->title = 'Create Promo';
$this->params['breadcrumbs'][] = ['label' => 'Promos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'avaliableClinics' => $avaliableClinics,
    ]) ?>

</div>
