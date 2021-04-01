<?php

/* @var $this yii\web\View
 * @var $dp yii\data\ActiveDataProvider
 * @var $ownAppointments Appointment[]
 */

use app\models\Appointment;
use app\models\Clinic;
use app\models\Persons;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<?php
if (count($ownAppointments)) {
    ?>
    <div class="panel panel-primary">
        <div class="panel-heading">Заявки в работе</div>
        <div class="panel-body">
            <?php
            foreach ($ownAppointments as $appointment) {
                ?>
                <div class="appoint_admin_block">
                    <div>
                        <b>+7 <?= $appointment->phone ?></b>
                        <br>
                        <small>
                            <?= date_create($appointment->created)->format("H:i:s d M y") ?>
                            [<?= $appointment->ip ?>]
                        </small>
                        <br>
                        <?= $appointment->person->fullName ?>,
                        <?= $appointment->person->primarySpec ?>,
                        <?= $appointment->clinic->city ?>,
                        <i><?= date_create($appointment->day)->format("d M y") ?></i>
                    </div>
                    <div>
                        <?= $this->render("_set_status_button", [
                            "id" => $appointment->id,
                            "status" => Appointment::STATUS_CONFIRMED
                        ]); ?>
                        <?= $this->render("_set_status_button", [
                            "id" => $appointment->id,
                            "status" => Appointment::STATUS_CANCELLED
                        ]); ?>
                        <?= $this->render("_set_status_button", [
                            "id" => $appointment->id,
                            "status" => Appointment::STATUS_CREATED
                        ]); ?>

                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}
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
            'template' => '{pickup} {confirm} {cancel} {discharge}',
            'visibleButtons' => [
                'pickup' => function (Appointment $appointment, $key) {
                    return $appointment->status === Appointment::STATUS_CREATED;
                },
                'confirm' => function (Appointment $appointment, $key) {
                    return $appointment->status === Appointment::STATUS_IN_PROGRESS
                        && $appointment->owner_id === Yii::$app->user->id;
                },
                'cancel' => function (Appointment $appointment, $key) {
                    return $appointment->status === Appointment::STATUS_IN_PROGRESS
                        && $appointment->owner_id === Yii::$app->user->id;
                },
                'discharge' => function (Appointment $appointment, $key) {
                    return $appointment->status === Appointment::STATUS_IN_PROGRESS
                        && $appointment->owner_id === Yii::$app->user->id;
                },
            ],
            'buttons' => [
                'pickup' => function ($url, Appointment $appointment, $key) {
                    return Html::a("",
                        ["/appointment/pick-up"],
                        [
                            'class' => 'glyphicon glyphicon-play-circle',
                            'title' => 'Взять в работу',
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Взять в работу?',
                                'params' => [
                                    'id' => $appointment->id,
                                ],
                            ]
                        ]
                    );
                },
                'confirm' => function ($url, Appointment $appointment, $key) {
                    return Html::a("",
                        ["/appointment/set-status"],
                        [
                            'class' => 'glyphicon glyphicon-ok-sign',
                            'title' => 'Подтвердить',
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Заявка подтвреждена?',
                                'params' => [
                                    'id' => $appointment->id,
                                    'status' => Appointment::STATUS_CONFIRMED,
                                ],
                            ]
                        ]
                    );
                },
                'cancel' => function ($url, Appointment $appointment, $key) {
                    return Html::a("",
                        ["/appointment/set-status"],
                        [
                            'class' => 'glyphicon glyphicon-remove-sign',
                            'title' => 'Отменить',
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Отменить заявку?',
                                'params' => [
                                    'id' => $appointment->id,
                                    'status' => Appointment::STATUS_CANCELLED,
                                ],
                            ]
                        ]
                    );
                },
                'discharge' => function ($url, Appointment $appointment, $key) {
                    return Html::a("",
                        ["/appointment/set-status"],
                        [
                            'class' => 'glyphicon glyphicon-fast-backward',
                            'title' => 'Отказаться от обработки заявки',
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Отказаться от обработки заявки?',
                                'params' => [
                                    'id' => $appointment->id,
                                    'status' => Appointment::STATUS_CREATED,
                                ],
                            ]
                        ]
                    );
                },
            ]
        ],
    ],
]); ?>

