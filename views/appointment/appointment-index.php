<?php

/* @var $this yii\web\View
 * @var $dp yii\data\ActiveDataProvider
 * @var $ownAppointmentSegments Appointment[][] $ownAppointmentSegments[phoneNumber]=appointment
 * @var $newAppointmentSegments Appointment[][] $newAppointmentSegments[phoneNumber]=appointment
 * @var $settingsFormModel AppointmentSettingsForm
 */

use app\models\Appointment;
use app\models\AppointmentSettingsForm;
use app\models\Clinic;
use app\models\Persons;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>


<?php
if (count($ownAppointmentSegments)) {
    ?>
    <div class="panel panel-success">
        <div class="panel-heading">Заявки в работе</div>
        <div class="panel-body">
            <?php
            foreach ($ownAppointmentSegments as $phone => $appointments) {
                ?>
                <div class="appoint_admin_block">
                    <div>
                        <b><?= Html::a('+7 ' . $phone, ['appointments-by-number', 'phone' => $phone]) ?></b>
                        <?php
                        foreach ($appointments as $appointment) {
                            /** @var Appointment $appointment */
                            ?>
                            <div class="appoint_admin_block">
                                <div>
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
                                        "status" => Appointment::STATUS_CONFIRMED,
                                        'appointment' => $appointment
                                    ]); ?>
                                    <?= $this->render("_set_status_button", [
                                        "id" => $appointment->id,
                                        "status" => Appointment::STATUS_CANCELLED,
                                        'appointment' => $appointment
                                    ]); ?>
                                    <?= $this->render("_set_status_button", [
                                        "id" => $appointment->id,
                                        "status" => Appointment::STATUS_CREATED,
                                        'appointment' => $appointment
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
        </div>
    </div>
    <?php
}
?>

<?php
if (count($newAppointmentSegments)) {
    ?>
    <div class="panel panel-danger">
        <div class="panel-heading">Новые заявки</div>
        <div class="panel-body">
            <?php
            foreach ($newAppointmentSegments as $phone => $appointments) {
                ?>
                <div class="appoint_admin_block">
                    <div>
                        <?= Html::a("Взять в работу",
                            ["/appointment/pick-up"],
                            [
                                'class' => 'btn btn-primary btn-small',
                                'title' => 'Взять в работу',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => 'Взять в работу?',
                                    'params' => [
                                        'id' => $appointments[0]->id,
                                    ],
                                ]
                            ]
                        ); ?>
                        <?php
                        foreach ($appointments as $appointment) {
                            /** @var Appointment $appointment */
                            ?>
                            <div>
                                <?= $appointment->clinic->city ?>:
                                <?= $appointment->person->fullName ?>
                            </div>
                            <?php
                        }
                        ?>
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


<?php
if (Yii::$app->user->identity->is_admin) {
    $form = ActiveForm::begin([])
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">Настройки</div>
        <div class="panel-body">
            <?= $form->field($settingsFormModel, 'enableAppointment')->checkbox()->label('Включить прием заявок') ?>
            <!-- <?= $form->field($settingsFormModel, 'enableCaptcha')->checkbox(['disabled' => true])->label('Включить Google CAPTCHA') ?> -->
            <?= Html::submitButton('Сохранить настройки') ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
    <?php
}

$gridColumns = [
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
            return Appointment::STATUS_NAME[$appointment->status];
        }
    ],
    'comment'
];

if (Yii::$app->user->identity->is_admin) {
    $gridColumns[] = [
        'label' => 'Обработал',
        'content' => function (Appointment $appointment) {
            $owner = $appointment->owner;
            return $owner ? $owner->login : "";
        }
    ];
    $gridColumns[] = [
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
    ];

}
?>

<?= GridView::widget([
    'dataProvider' => $dp,
    'columns' => $gridColumns,
]); ?>

