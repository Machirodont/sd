<?php

/* @var $this yii\web\View
 * @var $dp yii\data\ActiveDataProvider
 * @var $phone string
 */

use app\models\Appointment;
use app\models\Clinic;
use app\models\Persons;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<h3>Все заявки с номера <u>+7 <?= $phone ?></u>:</h3>
<?= GridView::widget([
    'dataProvider' => $dp,
    'columns' => [
        "id",
        [
            'label' => 'Заявка',
            'content' => function (Appointment $appointment) {
                return $appointment->clinic->city
                    . ', '
                    . $appointment->person->fullName;
            }
        ],
        [
            'label' => 'Получено',
            'content' => function (Appointment $appointment) {
                return $appointment->created
                    . ' с '
                    . $appointment->ip;
            }
        ],

        [
            'label' => 'Статус',
            'content' => function (Appointment $appointment) {
                return Appointment::STATUS_NAME[$appointment->status];
            }
        ],


    ],
]); ?>

