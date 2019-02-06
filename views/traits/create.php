<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Traits */

$this->title = 'Create Traits';
$this->params['breadcrumbs'][] = ['label' => 'Traits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="traits-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
