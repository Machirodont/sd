<?php

/* @var $this yii\web\View
 * @var $id int
 * @var $status int
 */

use app\models\Appointment;
use yii\helpers\Html;

$params = [
    Appointment::STATUS_CREATED => [
        'name' => 'Отказаться',
        'title' => 'Отказаться от обработки заявки',
        'class' => 'btn btn-default',
    ],
    Appointment::STATUS_IN_PROGRESS => [
        'name' => 'Взять в работу',
        'title' => 'Взять в работу',
        'class' => 'btn btn-primary',
    ],
    Appointment::STATUS_CONFIRMED => [
        'name' => 'Подтвердить',
        'title' => 'Заявка подтвреждена?',
        'class' => 'btn btn-success',
    ],
    Appointment::STATUS_CANCELLED => [
        'name' => 'Отменить',
        'title' => 'Отменить заявку?',
        'class' => 'btn btn-danger',
    ],
]
?>

<?= Html::a($params[$status]['name'],
    ["/appointment/set-status"],
    [
        'class' => $params[$status]['class'],
        'title' => $params[$status]['title'],
        'data' => [
            'method' => 'post',
            'confirm' => $params[$status]['title'],
            'params' => [
                'id' => $id,
                'status' => $status,
            ],
        ]
    ]
); ?>





