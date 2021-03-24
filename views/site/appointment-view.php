<?php

/* @var $this yii\web\View
 * @var Appointment $appointment
 */

use app\models\Appointment;
use app\models\Clinic;
use app\models\Persons;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<h3>Вы отправили заявку на прием</h3>
Филиал: <?= $appointment->clinic->city ?>
<br>
<?= $appointment->person->primarySpec ?>: <?= $appointment->person->fullName ?>
<br>
Дата записи: <?= $appointment->day ?>
<br>
Ваш телефон: <?= $appointment->phone ?>
<h4>В ближайшее время мы свяжемся с Вами для уточнения времени приема. Спасибо.</h4>




