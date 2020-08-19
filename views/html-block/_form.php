<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HtmlBlock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="html-block-form">


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->label("")->widget(TinyMce::class, [
        'options' => ['rows' => 6],
        'language' => 'ru',
        'clientOptions' => [
            'statusbar' => false,
            'menubar' => false,
            'plugins' => [
                'advlist autolink lists link charmap  print hr preview pagebreak',
                'searchreplace wordcount textcolor visualblocks visualchars code fullscreen nonbreaking',
                'save insertdatetime media table contextmenu template paste'
            ],
            'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | removeformat code',
            'invalid_styles' => 'position transition z-index transform   rotate perspective perspective-origin content',
            'invalid_elements' => "form,input"
        ]
    ]) ?>


    <?= $form->field($model, 'order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
