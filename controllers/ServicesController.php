<?php

namespace app\controllers;

use app\models\PriceGroup;
use app\models\PriceItems;

class ServicesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $id = \Yii::$app->request->get("id");
        $groups = PriceGroup::find()->where(["parentId" => $id])->all();
        $items = PriceItems::find()->where(["groupId" => $id])->all();
        return $this->render('index', [
            "groups" => $groups,
            "items" => $items,
        ]);
    }
}
