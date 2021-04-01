<?php

namespace app\controllers;

use app\models\Appointment;
use Yii;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class AppointmentController extends Controller
{

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
        $dp = new ActiveDataProvider([
            'query' => Appointment::find(),
        ]);
        $dp->sort->defaultOrder = ["id" => SORT_DESC];
        $dp->pagination->pageSize = 0;

        $ownAppointments = Appointment::find()->where([
            "owner_id" => Yii::$app->user->id,
            "status" => Appointment::STATUS_IN_PROGRESS
        ])->all();


        return $this->render("appointment-index", [
            'dp' => $dp,
            'ownAppointments' => $ownAppointments,
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
            if ($newStatus === Appointment::STATUS_CREATED) {
                $appointment->owner_id = null;
            }
            $appointment->save();
        }
        $this->redirect(["/appointment/appointment-index"]);
    }
}
