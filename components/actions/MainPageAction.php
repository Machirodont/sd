<?php


namespace app\components\actions;


use app\models\Clinic;
use app\models\Persons;
use app\models\Promo;
use yii\base\Action;
use yii\helpers\Html;

class MainPageAction extends Action
{
    public function run()
    {
        $clinic = Clinic::findOne(\Yii::$app->session->get("cid"));
        return $this->controller->render('main-page', [
            "persons" => self::selectRandomPersons(3),
            "promoList" => Promo::getListForClinic($clinic),
            'clinicList' => Clinic::getActiveList()
        ]);
    }

    /**
     * @param int $limit
     * @return Persons[]
     */
    private static function selectRandomPersons(int $limit)
    {
        return Persons::find()->
        select("p.*")->distinct()
            ->from(["p" => "sd_persons"])
            ->leftJoin(["t" => "sd_traits"], "p.person_id = t.person_id")
            ->where(["and",
                ["not", ["p.education" => null]],
                ["p.removed" => null],
                ["t.title" => "Основное место работы"]
            ])->orderBy(["RAND()" => SORT_DESC])->limit($limit)->all();
    }
}