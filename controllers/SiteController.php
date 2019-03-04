<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Sheduler;
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
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

    public function actionParce()
    {
        $s = Sheduler::parceFile("r.json");
        $r = "<table>";
        foreach ($s->subdivisions as $subdiv_hash => $subdiv) {
            foreach ($subdiv->workplaces as $workplace_hash => $workplace) {
                foreach ($workplace->schedules as $schedule_hash => $schedule) {
                    $sh = new Sheduler();
                    $sh->hash = $schedule_hash;
                    $sh->person_name = $schedule->name;
                    $sh->workplace_hash = $workplace_hash;
                    $sh->workplace_name = $workplace->name;
                    $sh->subdivision_hash = $subdiv_hash;
                    $sh->subdivision_name = $subdiv->name;
                    //$sh->save();
                    $days = "";
                    /*
                     * ToDo shedule hash - фигня, надо ориентироваться на shedule_id
                     * И ввести workplaces как базовую сущность
                     * Врач может быть связан с несколькими workplaces
                     * Workplace может быть связан с несколькими врачами
                     * Shedule связано только с одним врачом и одним workplace
                     * Далее workplace привязано только к одной клинике
                    */
                    foreach ($schedule->days_active as $date => $day_is_active) {
                        $days .= $date . " : " . $day_is_active . "<br>";
                        $shedule_day = SheduleDays::findOne(["day" => $date, "shedule_hash" => $schedule_hash, "workplace_hash" => $workplace_hash]);
                        if (is_null($shedule_day)) {
                            $shedule_day = new SheduleDays(["day" => $date, "shedule_hash" => $schedule_hash, "workplace_hash" => $workplace_hash]);
                        }
                        $shedule_day->is_active = intval($day_is_active);
                        $shedule_day->save();
                    }

                }


                $r .= <<<EOT
<tr>
<td>" . $subdiv_hash . "</td>
<td>" . $subdiv->name . "</td>
<td>" . $workplace_hash . "</td>
<td>" . $workplace->name . "</td>
<td>" . $schedule_hash . "</td>
<td>" . $schedule->name . "</td>
<td>" . $days . "</td>
</tr>
EOT;
            }
        }


        $r .= "</table>";


        return $r;
    }


}
