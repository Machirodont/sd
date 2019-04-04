<?php

namespace app\controllers;

use app\models\Clinic;
use app\models\Pages;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class ClinicController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $clinics = Clinic::find()->where("NOT companyPage IS NULL")->all();
        return $this->render('index', [
            'clinics' => $clinics,
        ]);
    }

    public function actionContacts()
    {
        $clinic = Clinic::findOne(\Yii::$app->session->get("cid"));
        if (!$clinic) return $this->redirect(["index"]);

        return $this->render('contacts', [
            'clinic' => $clinic,
        ]);
    }

    public function actionCompany()
    {
        $clinic = Clinic::findOne(\Yii::$app->session->get("cid"));
        if (!$clinic) return $this->redirect(["index"]);
        if ($clinic->companyPage) {
            $page = Pages::findOne($clinic->companyPage);
            return $this->render('/site/page', [
                'page' => $page,
            ]);
        }

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
