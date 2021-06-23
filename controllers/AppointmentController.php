<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\AppointmentSettingsForm;
use Yii;
use app\models\Users;
use yii\base\BaseObject;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class AppointmentController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['appointment-index', 'appointments-by-number', 'pick-up', 'set-status'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create', 'view'],
                        'allow' => true,
                        'roles' => ['@', '?'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id === 'create' || $action->id === 'view') {
            if (Yii::$app->user->isGuest && !file_exists(AppointmentSettingsForm::FILE_APPOINTMENT_ENABLE)) {
                return $this->redirect('/');
            }
        }
        return parent::beforeAction($action);
    }

    public function actionCreate()
    {
        if (Yii::$app->request->post("phone")) {
            $cookie = Yii::$app->request->cookies->getValue(Appointment::COOKIE_NAME);
            if (!$cookie) {
                $cookie = bin2hex(random_bytes(32));
                Yii::$app->response->cookies->add(new Cookie(['name' => Appointment::COOKIE_NAME, 'value' => $cookie]));
            }

            $phone = Yii::$app->request->post("phone");
            $personId = Yii::$app->request->get("personId");

            $appointment = new Appointment([
                "phone" => Yii::$app->request->post("phone"),
                "ip" => Yii::$app->request->userIP,
                "person_id" => Yii::$app->request->get("personId"),
                "clinic_id" => Yii::$app->session->get("cid"),
                "day" => Yii::$app->request->get("day"),
                "status" => Appointment::STATUS_CREATED,
                "cookie" => $cookie,
                "created" => date("Y-m-d H:i:s"),
            ]);

            $doubleAppointment = Appointment::find()->where([
                "phone" => $appointment->phone,
                "person_id" => $appointment->person_id,
                "clinic_id" => $appointment->clinic_id,
                "status" => $appointment->status,
                "cookie" => $appointment->cookie,
            ])->one();


            if (!$doubleAppointment) {
                $appointment->save();
            } else {
                $appointment = $doubleAppointment;
            }

            if ($appointment->save()) {
                return $this->redirect(["/appointment/view", 'id' => $appointment->id]);
            }
        }
        return $this->render("create", [
        ]);
    }

    public function actionView($id)
    {
        $appointment = Appointment::findOne($id);
        if (!$appointment || $appointment->cookie !== Yii::$app->request->cookies->get(Appointment::COOKIE_NAME)->value) {
            return $this->redirect(["site/appointment"]);
        }
        return $this->render("appointment-view", [
            'appointment' => $appointment
        ]);
    }

    public function actionAppointmentIndex()
    {
        $query = Appointment::find()->where([
            "clinic_id" => Yii::$app->user->identity->clinicIdList,
        ]);
        if (!Yii::$app->user->identity->is_admin) {
            $query->andWhere(['owner_id' => Yii::$app->user->id]);
        }

        $dp = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dp->sort->defaultOrder = ["id" => SORT_DESC];
        $dp->pagination->pageSize = 0;

        /**@var Appointment[] $ownAppointments */
        $ownAppointments = Appointment::find()->where([
            "owner_id" => Yii::$app->user->id,
            "status" => Appointment::STATUS_IN_PROGRESS,
            "clinic_id" => Yii::$app->user->identity->clinicIdList,
        ])->all();

        /**@var Appointment[] $ownAppointmentSegments */
        $ownAppointmentSegments = [];
        foreach ($ownAppointments as $appointment) {
            if (!array_key_exists($appointment->phone, $ownAppointmentSegments)) {
                $ownAppointmentSegments[$appointment->phone] = [];
            }
            $ownAppointmentSegments[$appointment->phone][] = $appointment;
        }


        /**@var Appointment[] $newAppointments */
        $newAppointments = Appointment::find()->where([
            "status" => Appointment::STATUS_CREATED,
            "clinic_id" => Yii::$app->user->identity->clinicIdList,
        ])->all();

        /**@var Appointment[] $newAppointmentSegments */
        $newAppointmentSegments = [];
        foreach ($newAppointments as $appointment) {
            if (!array_key_exists($appointment->phone, $newAppointmentSegments)) {
                $newAppointmentSegments[$appointment->phone] = [];
            }
            $newAppointmentSegments[$appointment->phone][] = $appointment;
        }

        $settingsFormModel = new AppointmentSettingsForm();
        if ($settingsFormModel->load(Yii::$app->request->post())) {
            $settingsFormModel->save();
            $this->redirect(['appointment-index']);
        }

        return $this->render("appointment-index", [
            'dp' => $dp,
            'ownAppointmentSegments' => $ownAppointmentSegments,
            'newAppointmentSegments' => $newAppointmentSegments,
            'settingsFormModel' => $settingsFormModel,
        ]);
    }

    public function actionAppointmentsByNumber()
    {
        $dp = new ActiveDataProvider([
            'query' => Appointment::find()->where([
                "clinic_id" => Yii::$app->user->identity->clinicIdList,
                "phone" => Yii::$app->request->get("phone"),
            ]),
        ]);
        $dp->sort->defaultOrder = ["id" => SORT_DESC];
        $dp->pagination->pageSize = 0;

        return $this->render("appointments-by-number", [
            'phone' => Yii::$app->request->get("phone"),
            'dp' => $dp,
        ]);
    }


    public function actionPickUp()
    {
        $appointment = Appointment::findOne(Yii::$app->request->post("id"));
        if (!$appointment) throw new NotFoundHttpException('Страница не обнаружена');
        if ($appointment->owner_id && $appointment->owner_id !== Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'Заявка уже в работе у ' . $appointment->owner->login);
            $this->redirect(["/appointment/appointment-index"]);
        }
        if ($appointment->status === Appointment::STATUS_CREATED) {
            $appointment->status = Appointment::STATUS_IN_PROGRESS;
            $appointment->owner_id = Yii::$app->user->id;
            $appointment->save();
            /**@var Appointment[] $samePhoneAppointments */
            $samePhoneAppointments = Appointment::find()->where([
                'phone' => $appointment->phone,
                'status' => Appointment::STATUS_CREATED
            ])->all();
            foreach ($samePhoneAppointments as $app) {
                $app->status = Appointment::STATUS_IN_PROGRESS;
                $app->owner_id = Yii::$app->user->id;
                $app->save();
            }
        }
        $this->redirect(["/appointment/appointment-index"]);
    }

    public function actionSetStatus()
    {
        $appointment = Appointment::findOne(Yii::$app->request->post("id"));
        if (!$appointment) throw new NotFoundHttpException('Страница не обнаружена');
        $newStatus = (int)Yii::$app->request->post("status");
        if (
            in_array($newStatus, [Appointment::STATUS_CREATED, Appointment::STATUS_CONFIRMED, Appointment::STATUS_CANCELLED])
            && $appointment->owner_id === Yii::$app->user->id
        ) {
            $appointment->status = $newStatus;
            $appointment->comment = Yii::$app->request->post("comment");
            if ($newStatus === Appointment::STATUS_CREATED) {
                $appointment->owner_id = null;
            }
            $appointment->save();
        }
        $this->redirect(["/appointment/appointment-index"]);
    }
}
