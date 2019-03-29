<?php

namespace app\controllers;

use app\models\Pages;
use app\models\Persons;
use app\models\TimelineDays;
use app\models\TimeLines;
use app\models\Workplaces;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
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


    public function actionCkeditor_image_upload()
    {
        $funcNum = $_REQUEST['CKEditorFuncNum'];

        if ($_FILES['upload']) {

            $message = '';
            if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name']))) {
                $message = Yii::t('app', "Please Upload an image.");
            } else if ($_FILES['upload']["size"] == 0 OR $_FILES['upload']["size"] > 5 * 1024 * 1024) {
                $message = Yii::t('app', "The image should not exceed 5MB.");
            } else if (($_FILES['upload']["type"] != "image/jpg")
                AND ($_FILES['upload']["type"] != "image/jpeg")
                AND ($_FILES['upload']["type"] != "image/png")) {
                $message = Yii::t('app', "The image type should be JPG , JPEG Or PNG.");
            } else if (!is_uploaded_file($_FILES['upload']["tmp_name"])) {

                $message = Yii::t('app', "Upload Error, Please try again.");
            } else {
                //you need this (use yii\db\Expression;) for RAND() method
                $random = rand(123456789, 9876543210);

                $extension = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);

                //Rename the image here the way you want
                $name = date("m-d-Y-h-i-s", time()) . "-" . $random . '.' . $extension;

                // Here is the folder where you will save the images
                $folder = 'uploads/ckeditor_images/';

                $url = Yii::$app->urlManager->createAbsoluteUrl($folder . $name);

                move_uploaded_file($_FILES['upload']['tmp_name'], $folder . $name);
            }

            echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'
                . $funcNum . '", "' . $url . '", "' . $message . '" );</script>';
        }
    }

    public function actionCkeditor_image_list()
    {
        $f = [];
        $folder = "/uploads/ckeditor_images/";
        foreach (glob("." . $folder . "*.*") as $filename) {
            $f[] = [
                "image" => $folder . basename($filename),
                "thumb" => $folder . basename($filename),
            ];
        }


        return json_encode($f);
    }

    public function actionLoadSchedule($code)
    {
        function writeLog($text, $fName = "error_log.txt")
        {
            $f = fopen($fName, 'a');
            $s = date("Y-m-d H:i:s " . $_SERVER["REMOTE_ADDR"]) . " " . $text . "\n";
            fwrite($f, $s);
        }

        if ($code !== "799855594adc0f2bd7302c69d3234b5a") {
            writeLog("ERROR: wrong GET code");
            return 'FALSE';
        }

        $postRaw = file_get_contents("php://input");
        if ($postRaw === false) {
            writeLog("ERROR: wrong php://input");
            return 'FALSE';
        }

        try {
            $postDecompressStr = gzdecode($postRaw);
        } catch (\Exception $e) {
            writeLog("ERROR: GZip exception " . $e->getCode());
            return 'FALSE';
        }

        if ($postDecompressStr === false) {
            writeLog("ERROR: GZip (false returned)");
            return 'FALSE';
        }
        $postData = array();
        parse_str($postDecompressStr, $postData);

        if (!array_key_exists('json', $postData)) {
            writeLog("ERROR: no json key in URL data");
            return 'FALSE';
        }

        $json = json_decode($postData['json'], true);
        if (!is_array($json)) {
            writeLog("ERROR: data is not json");
            return 'FALSE';
        }

        if (file_exists("../data/schedule.json")) {
            rename("../data/schedule.json", "../data/schedule_" . date("Y-m-d-H-j-s") . ".json");
        }
        file_put_contents("../data/schedule.json", $postData['json']);

        //Обрабока данных
        return 'TRUE ';
    }

    public function actionParce()
    {

        $s = json_decode(file_get_contents("../data/schedule.json"));
        $r = "<table>";
        foreach ($s->subdivisions as $subdiv_hash => $subdiv) {
            foreach ($subdiv->workplaces as $workplace_hash => $workplace) {

                //Добавляем в sd_workplaces новый Workplace, если его там еще нет
                if (!Workplaces::findByHash($workplace_hash)) {
                    $w = new Workplaces([
                        "workplace_hash" => $workplace_hash,
                        "clinic_hash" => $subdiv_hash
                    ]);
                    $w->save();
                    //ToDo - проверка и реакция, если сохранение не прошло
                }

                foreach ($workplace->schedules as $schedule_hash => $schedule) {
                    $person = Persons::findBySheduleHash($schedule_hash);
                    $days = "";
                    if ($person) {
                        $person_id = $person->person_id;

                        //Добавляем в sd_timelines новый Timeline, если его там еще нет
                        $tl = TimeLines::findOne(["workplace_hash" => $workplace_hash, "person_id" => $person_id]);
                        if (!$tl) {
                            $tl = new TimeLines(["workplace_hash" => $workplace_hash, "person_id" => $person_id]);
                            $tl->save();
                            //ToDo - проверка и реакция, если сохранение не прошло
                        }

                        foreach ($schedule->days_active as $date => $day_is_active) {
                            $days .= $date . " : " . $day_is_active . "<br>";
                            $d = TimelineDays::findOne(["timelineId" => $tl->id, "day" => $date]);
                            if (!$d) {
                                $d = new TimelineDays(["timelineId" => $tl->id, "day" => $date]);
                            }
                            $d->is_active = intval($day_is_active);
                            $d->save();
                            //ToDo - проверка и реакция, если сохранение не прошло
                        }
                    }

                    $color = $person ? "palegreen" : "#ffd1c6";

                    $r .= <<<EOT
<tr>
<td> $subdiv_hash </td>
<td> $subdiv->name </td>
<td> $workplace_hash </td>
<td> $workplace->name </td>
<td style="background-color: $color;"> $schedule_hash </td>
<td> $schedule->name </td>
<td>$days </td>
</tr>
EOT;
                }
            }
        }
        $r .= "</table>";
        return $r;
    }


}
