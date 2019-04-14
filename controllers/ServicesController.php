<?php

namespace app\controllers;

use app\models\PriceGroup;
use app\models\PriceItems;

class ServicesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $id = \Yii::$app->request->get("id");
        $group=PriceGroup::findOne($id);
        $groups = PriceGroup::find()->where(["parentId" => $id])->all();
        $items = PriceItems::find()->where(["groupId" => $id])->all();
        return $this->render('index', [
            "group"=>$group,
            "groups" => $groups,
            "items" => $items,
        ]);
    }
}
