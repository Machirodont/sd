<?php

namespace app\controllers;

use app\models\Clinic;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class ClinicController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $clinics = Clinic::find()->all();
        return $this->render('index', [
            'clinics' => $clinics,
        ]);
    }

    public function actionContacts()
    {
        $clinic = Clinic::findOne(\Yii::$app->session->get("cid"));
        if (!$clinic) return $this->redirect(["index", "id" => 2]);

        return $this->render('contacts', [
            'clinic' => $clinic,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Clinic::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
