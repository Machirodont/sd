<?php

/* @var $this yii\web\View
 * @var $person Persons
 * @var $day string
 */

use app\models\Persons;
use yii\helpers\Html;

?>

<br>
<h4>Выбран день: <?= $day ?></h4>
<?= Html::a("Изменить день ...", ["appointment/create", "personId" => $person->person_id]) ?>
<?= Html::beginForm() ?>
<br><br>
+7 <?= Html::input("tel", "phone", "", ["pattern" => "[0-9]*", "id" => "phoneInput"]); ?>
<button type="submit">Записаться</button>
<?= Html::endForm() ?>





