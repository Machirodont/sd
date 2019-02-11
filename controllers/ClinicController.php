<?php

namespace app\controllers;

use app\models\Clinic;
use yii\web\NotFoundHttpException;

class ClinicController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionContacts($cid)
    {
        $clinic=$this->findModel($cid);

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
