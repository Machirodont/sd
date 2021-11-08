<?php

/* @var $this yii\web\View
 * @var $person Persons
 */

use app\models\Persons;
use yii\helpers\Html;
?>
<br>
<h4>Выбран специалист: <?= $person->fullName ?>, <?= $person->primarySpec ?></h4>
<?= Html::a("Изменить выбор специалиста  ...", ["appointment/create"]) ?> <br>




