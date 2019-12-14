<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\Promo
 * @var \app\models\Clinic[] $avaliableClinics
 * @var $form yii\widgets\ActiveForm
 */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?php ActiveForm::end(); ?>
<?= $form->field($model, 'title')->textInput(['form' => $form->id, "placeholder"=>"Заголовок"])->label(false) ?>

<div class="promo-form">

    <div class="promo_img">
         <?php

        if ($model->fileName) {
            echo Html::img("/images/promo/" . $model->fileName,["style"=>"max-width:300px;"]);
        } else {
            echo "NO PICTURE";
        }
        ?>
        <?= $form->field($model, 'imageFile')->fileInput(['form' => $form->id]) ?>
    </div>
    <div class="promo_info">


        <?= $form->field($model, 'startDate')->widget(DatePicker::class, [
            'options' => ['placeholder' => 'бессрочно', 'form' => $form->id],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true
            ]
        ]) ?>

        <?= $form->field($model, 'endDate')->widget(DatePicker::class, [
            'options' => ['placeholder' => 'бессрочно', 'form' => $form->id],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true
            ]
        ]) ?>
    </div>
    <div class="promo_info">
        <?= $form->field($model, 'clinicList')->checkboxList($avaliableClinics, ['itemOptions' => ['form' => $form->id]]) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'form' => $form->id]) ?>
        </div>
        <small>* Отображать, если пользователь не выбирал клинику в шапке</small><br>
        <small>** Если нужно, чтобы промо отображалось всегда, нужно снять галочки со всех пунктов</small>
    </div>

</div>
<?= $form->field($model, 'html')->widget(TinyMce::class, [
    'options' => ['rows' => 20, 'form' => $form->id],
    'language' => 'ru',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    ]
])->label("Подробное описание");?>
