<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Persons */
/* @var $form yii\widgets\ActiveForm */
/* @var $institutionsList app\models\Institutions[] */

?>

<div class="persons-form">


    <?php $form = ActiveForm::begin(); ?>


    <?php /*$form->field($model, 'lastname')->widget(CKEditor::class, [
        'options' => ['rows' => 6],
        'preset' => 'custom',
        'clientOptions' => [
            'extraPlugins' => 'image2,imagebrowser',
            'height' => 500,

            //Here you give the action who will handle the image upload
            'filebrowserUploadUrl' => '/site/ckeditor_image_upload',
            "imageBrowser_listUrl"=>  "/site/ckeditor_image_list",
            'toolbarGroups' => [
                ['name' => 'undo'],
                ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
                ['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align', 'bidi' ]],
                ['name' => 'styles'],
                ['name' => 'links', 'groups' => ['links', 'insert']]
            ]

        ]
    ]) */ ?>

    <?= $form->field($model, 'firstname')->textInput() ?>

    <?= $form->field($model, 'lastname')->textInput() ?>

    <?= $form->field($model, 'patronymic')->textInput() ?>

    <?= $form->field($model, 'education')->dropDownList(array_merge([""=>"Не выбрано"], $institutionsList) ) ?>

    <?= $form->field($model, 'years_work')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
