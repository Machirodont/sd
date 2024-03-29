<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\AppointmentSettingsForm;
use app\models\Clinic;
use app\models\Persons;
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
            if (Yii::$app->user->isGuest && !self::bookingEnabled()) {
                return $this->redirect('/');
            }
        }
        return parent::beforeAction($action);
    }

    private static function bookingEnabled(): bool
    {
        return file_exists(AppointmentSettingsForm::FILE_APPOINTMENT_ENABLE);
    }

    public static function appointmentCookieSign()
    {
        $cookie = Yii::$app->request->cookies->getValue(Appointment::COOKIE_NAME);
        if (!$cookie) {
            $cookie = bin2hex(random_bytes(32));
            Yii::$app->response->cookies->add(new Cookie(['name' => Appointment::COOKIE_NAME, 'value' => $cookie]));
        }
        return $cookie;
    }


    private function createViewBlocks(?Clinic $clinic, ?Persons $person, ?string $day): array
    {
        $blocks = [];
        if ($clinic) {
            $blocks[] = ["view" => "_selected_clinic", "params" => ["clinic" => $clinic]];
        } else {
            $blocks[] = ["view" => "_select_clinic", "params" => []];
            return $blocks;
        }

        if ($person) {
            $person->currentClinic = $clinic;
            $blocks[] = ["view" => "_selected_person", "params" => ["person" => $person]];
        } else {
            $blocks[] = ["view" => "_select_person", "params" => ["clinic" => $clinic]];
            return $blocks;
        }

        if ($day) {
            $blocks[] = ["view" => "_selected_day", "params" => ["person" => $person, "day" => $day]];
        } else {
            $blocks[] = ["view" => "_select_day", "params" => ["person" => $person]];
        }
        return $blocks;
    }

    public function actionCreate()
    {
        $clinic = Clinic::findOne(Yii::$app->session->get("cid"));
        $person = Persons::findOne(Yii::$app->request->get('personId'));
        $day = Yii::$app->request->get('day');

        if (!Yii::$app->request->post("phone")) {
            return $this->render("create", ["blocks" => self::createViewBlocks($clinic, $person, $day)]);
        }

        $cookie = self::appointmentCookieSign();

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

        //Если клиент пытается долбать эндпоинт одинаковыми запросами
        $appointment = $appointment->mergeDouble();

        if ($appointment->save()) {
            return $this->redirect(["/appointment/view", 'id' => $appointment->id]);
        }

        return $this->render("create", []);
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
            Appointment::statusIsValid($newStatus)
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
