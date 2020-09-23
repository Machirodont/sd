<?php

use app\assets\PersonEdit;
use app\models\Persons;
use app\models\UploadForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $uploadForm UploadForm */

$person = $uploadForm->person;
$this->params['breadcrumbs'][] = ['label' => 'Доктора', 'url' => ['/persons/list']];
$this->params['breadcrumbs'][] = ['label' => $person->fullname, 'url' => ['/persons/view', "id" => $person->person_id]];
$this->params['breadcrumbs'][] = ['label' => "Загрузка фото"];

?>
<div class="persons-edit">
    <div class="col-sm-4 portrait">
        <?= Html::img($person->portraitUrl . "?nocache=" . mt_rand(), [
            'title' => $person->fullname
        ]) ?>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($uploadForm, 'imageFile')->fileInput() ?>

    <button type="submit">Submit</button>

    <?php ActiveForm::end() ?>

</div>
