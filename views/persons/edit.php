<?php

use app\assets\PersonEdit;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $person app\models\Persons */
/* @var string[] $institutions */
/* @var string[] $traitTypes */

PersonEdit::register($this);
?>
<div class="persons-edit">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($person, 'lastname')->textInput() ?>
    <?= $form->field($person, 'firstname')->textInput() ?>
    <?= $form->field($person, 'patronymic')->textInput() ?>
    <?= $form->field($person, 'years_work')->textInput() ?>
    <?= $form->field($person, 'education')->dropDownList($institutions) ?>


    <style>
        .trait_table td {
            border: solid 1px blueviolet;
            padding: 3px;
        }

        .trait_table select {
            width: 200px;
        }

    </style>
    <table class="trait_table">
        <?php
        foreach ($person->allTraits as $trait) {
            ?>
            <tr>
                <td><?= Html::input("hidden", "Persons[loadedTraits][trait_id][]", $trait->trait_id) ?></td>
                <td><?= Html::input("hidden", "Persons[loadedTraits][person_id][]", $trait->person_id) ?></td>
                <td><?= Html::dropDownList("Persons[loadedTraits][title][]", $trait->title, $traitTypes) ?></td>
                <td><?= Html::input("text", "Persons[loadedTraits][description][]", $trait->description) ?></td>
                <td><?= Html::input("text", "Persons[loadedTraits][sort][]", $trait->sort) ?></td>
                <td><?= Html::dropDownList("Persons[loadedTraits][institution_id][]", $trait->institution_id, $institutions) ?></td>
                <td><?= Html::a("x", ["/persons/remove-trait", 'id' => $trait->trait_id], ["data" => ["method" => "post", 'confirm'=>"Удалить параметр?"]]) ?></td>
            </tr>
            <?php
        }
        ?>
        <tr class="new_trait">
            <td><?= Html::input("hidden", "Persons[loadedTraits][trait_id][]") ?></td>
            <td><?= Html::input("hidden", "Persons[loadedTraits][person_id][]", $person->person_id) ?></td>
            <td><?= Html::dropDownList("Persons[loadedTraits][title][]", null, $traitTypes) ?></td>
            <td><?= Html::input("text", "Persons[loadedTraits][description][]") ?></td>
            <td><?= Html::input("text", "Persons[loadedTraits][sort][]") ?></td>
            <td><?= Html::dropDownList("Persons[loadedTraits][institution_id][]", null, $institutions) ?></td>
        </tr>
    </table>


    <?= Html::submitButton() ?>
    <?= Html::button("+", ["class" => "addTraitButton"]) ?>
    <?php ActiveForm::end(); ?>
</div>
