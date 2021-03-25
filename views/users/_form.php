<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'login')->input("text") ?>

    <?= $form->field($model, 'password1')->input("text") ?>
    <?= $form->field($model, 'password2')->input("text") ?>

    <?= $form->field($model, 'is_admin')->radioList(["0" => "нет", "1" => "да"]) ?>

    <?= $form->field($model, 'clinics')->input("text") ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
