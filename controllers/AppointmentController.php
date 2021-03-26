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
                return $this->redirect("/appointment/view/?id=" . $appointment->id);
            }
        }
        return $this->render("create", [
        ]);
    }

    public function actionAppointmentView($id)
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


        return $this->render("appointment-index", [
            'dp' => $dp
        ]);
    }
}
