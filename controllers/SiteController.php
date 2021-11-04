<?php

namespace app\controllers;

use app\components\actions\MainPageAction;
use app\helpers\Extra;
use app\models\Appointment;
use app\models\Clinic;
use app\models\Pages;
use app\models\Persons;
use app\models\PriceGroup;
use app\models\PriceItems;
use app\models\Promo;
use app\models\TimelineDays;
use app\models\TimeLines;
use app\models\Workplaces;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SheduleDays;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'main-page'=>[
                'class' => MainPageAction::class,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($action->id == 'load-schedule') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionPage()
    {
        $pageId = intval(Yii::$app->request->get("id"));
        if (!$pageId) $pageId = 1;
        $page = Pages::findOne($pageId);
        return $this->render('page', [
            'page' => $page,
        ]);
    }

    public function actionLoadPrice()
    {
        echo "start";
        shell_exec("php ../yii parse/price-load");
        echo "end";
        exit;
    }


    public function actionParsePrice()
    {
        echo "start";
        shell_exec("php ../yii parse/price-parse");
        echo "end";
        exit;
    }


    public function actionLoadSchedule($code)
    {
        if ($code !== "41445463905c0ed3ebb1e694a8d7ab") {
            Extra::writeLog("ERROR: wrong GET code");
            return 'FALSE';
        }

        $postRaw = file_get_contents("php://input");
        if ($postRaw === false) {
            Extra::writeLog("ERROR: wrong php://input");
            return 'FALSE';
        }

        try {
            $postDecompressStr = gzdecode($postRaw);
        } catch (\Exception $e) {
            Extra::writeLog("ERROR: GZip exception " . $e->getCode());
            return 'FALSE';
        }

        if ($postDecompressStr === false) {
            Extra::writeLog("ERROR: GZip (false returned)");
            return 'FALSE';
        }
        $postData = array();
        parse_str($postDecompressStr, $postData);

        if (!array_key_exists('json', $postData)) {
            Extra::writeLog("ERROR: no json key in URL data");
            return 'FALSE';
        }

        $json = json_decode($postData['json'], true);
        if (!is_array($json)) {
            Extra::writeLog("ERROR: data is not json");
            return 'FALSE';
        }

        $fName = "schedule_" . date("Y-m-d-H-i-s") . ".json";
        $fn_suffix = 1;
        while (file_exists("../data/" . $fName)) {
            $fName = "schedule" . $fn_suffix . "_" . date("Y-m-d-H-i-s") . ".json";
            $fn_suffix++;
        }

        if (file_put_contents("../data/" . $fName, $postData['json'])) {
            Yii::$app->db->createCommand("INSERT INTO sd_loaded_schedules SET fileName=\"" . $fName . "\",  loadTime=\"" . date("Y-m-d H:i:s") . "\"")->execute();

            //Обрабока данных - дергаем через сокет скрипт, который дергает команду Yii (потому что скрипт сдохнет через 30 секунд, а команда отработает сколько надо)
            Extra::socketAsyncCall(["/site/schedule-parse"]);
        } else {
            Extra::writeLog("ERROR: can't write file " . $fName);
        }

        return 'TRUE';
    }


    public function actionScheduleParse()
    {
        echo "start<br>";
        //echo shell_exec("php ../yii parse/schedules")."<br>";
        echo shell_exec("php ../yii parse/schedules") . "<br>";
        echo "end<br>";
        exit;
    }

    public function actionCounter()
    {
        if (!is_null(Yii::$app->request->post("cid"))) {
            $q = Yii::$app->db->createCommand()->insert('sd_hit_counter', [
                "cid" => intval(Yii::$app->session["cid"]),
                "hit" => "tel",
                "hitTime" => date("Y-m-d H:i:s"),
                "ip" => Yii::$app->request->remoteIP,
                "useragent" => Yii::$app->request->userAgent,
                "screen" => Yii::$app->request->post("scrData"),
            ]);
            $q->execute();
        }
    }
}
