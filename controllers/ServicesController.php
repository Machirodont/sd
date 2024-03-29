<?php

namespace app\controllers;

use app\models\Clinic;
use app\models\PriceGroup;
use app\models\PriceItems;
use Yii;

class ServicesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $id = \Yii::$app->request->get("id");
        $group = PriceGroup::findOne($id);
        $groups = PriceGroup::find()->where(["parentId" => $id, 'removed' => null])->orderBy(['groupName' => SORT_ASC])->all();
        $items = PriceItems::find()->where(["groupId" => $id, 'removed' => null])->all();
        if (!Yii::$app->session->get("cid")) {
            return $this->render('clinic_list', [
                'clinicList' => Clinic::getActiveList()
            ]);
        }
        return $this->render('index', [
            "group" => $group,
            "groups" => $groups,
            "items" => $items,
        ]);
    }
}
