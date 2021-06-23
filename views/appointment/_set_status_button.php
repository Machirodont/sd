<?php

/* @var $this yii\web\View
 * @var $id int
 * @var $status int
 * @var $appointment Appointment
 */

use app\models\Appointment;
use yii\helpers\Html;

$params = [
    Appointment::STATUS_CREATED => [
        'name' => 'Отказаться',
        'title' => 'Отказаться от обработки заявки',
        'class' => 'btn btn-default btn-small',
    ],
    Appointment::STATUS_IN_PROGRESS => [
        'name' => 'Взять в работу',
        'title' => 'Взять в работу',
        'class' => 'btn btn-primary btn-small',
    ],
    Appointment::STATUS_CONFIRMED => [
        'name' => 'Подтвердить',
        'title' => 'Заявка подтвреждена?',
        'class' => 'btn btn-success btn-small',
    ],
    Appointment::STATUS_CANCELLED => [
        'name' => 'Отменить',
        'title' => 'Отменить заявку?',
        'class' => 'btn btn-danger btn-small',
    ],
];

if ($status === Appointment::STATUS_CANCELLED) {

    ?>

    <a type="button" class="<?= $params[$status]['class'] ?>" data-toggle="modal" data-target="#myModal">
        Отменить
    </a>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Отмена заявки</h4>
                </div>
                <div class="modal-body">
                    <?= Html::beginForm(["/appointment/set-status"]) ?>
                    <?= Html::input('hidden', 'id', $id) ?>
                    <?= Html::input('hidden', 'status', $status) ?>
                    Заявка с номера +7 <?= $appointment->phone ?>
                    <br>
                    Причина отмены:
                    <?= Html::dropDownList('comment', null, ["Не дозвонились" => "Не дозвонились", "Чужой номер" => "Чужой номер", "Номер не существует" => "Номер не существует", "Не договорились" => "Не договорились"]) ?>
                    <br>
                    <?= Html::submitButton('Подтвердить отмену', ['class'=>'btn btn-danger']); ?>
                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>
    </div>
    <?php


} else {
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
    <?php
}
?>


