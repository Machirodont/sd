<?php

namespace app\controllers;

use app\components\actions\LoadScheduleAction;
use app\components\actions\MainPageAction;
use app\models\Pages;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;


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
            'main-page' => [
                'class' => MainPageAction::class,
            ],
            'load-schedule' => [
                'class' => LoadScheduleAction::class,
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

    public function actionScheduleParse()
    {
        echo "start<br>";
        echo shell_exec("php ../yii parse/schedules") . "<br>";
        echo "end<br>";
        exit;
    }

    public function actionCounter()
    {
        if (!is_null(Yii::$app->request->post("cid"))) {
            self::insertHit(Yii::$app->session["cid"], Yii::$app->request);
        }
    }

    public static function insertHit(?int $clinicId, Request $requestData)
    {
        $q = Yii::$app->db->createCommand()->insert('sd_hit_counter', [
            "cid" => intval($clinicId),
            "hit" => "tel",
            "hitTime" => date("Y-m-d H:i:s"),
            "ip" => $requestData->remoteIP,
            "useragent" => $requestData->userAgent,
            "screen" => $requestData->post("scrData"),
        ]);
        $q->execute();
    }
}
