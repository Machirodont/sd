<?php

/* @var $this yii\web\View
 * @var $dp yii\data\ActiveDataProvider
 */

use app\models\Appointment;
use app\models\Clinic;
use app\models\Persons;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<?= GridView::widget([
    'dataProvider' => $dp,
    'columns' => [
        "id",
        "phone",
        [
            'label' => 'Клиника',
            'content' => function (Appointment $appointment) {
                return $appointment->clinic->city;
            }
        ],
        [
            'label' => 'Врач',
            'content' => function (Appointment $appointment) {
                return $appointment->person->fullName;
            }
        ],
        [
            'label' => 'Статус',
            'content' => function (Appointment $appointment) {
                switch ($appointment->status) {
                    case Appointment::STATUS_CREATED :
                        return "НОВОЕ";
                    case Appointment::STATUS_IN_PROGRESS :
                        return "В РАБОТЕ";
                    case Appointment::STATUS_CONFIRMED :
                        return "ПОДТВЕРЖДЕНО";
                    case Appointment::STATUS_CANCELLED :
                        return "ОТМЕНЕНО";
                }
            }
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{cancel}',
            'buttons' => [
                'cancel' => function ($url, Appointment $appointment, $key) {
                    return Html::a("", ["/site/appointment"], ['class'=>'glyphicon glyphicon-remove-circle']);
                }
            ]
        ],
    ],
]); ?>

