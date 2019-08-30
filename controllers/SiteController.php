<?php

namespace app\controllers;

use app\helpers\Extra;
use app\models\Pages;
use app\models\Persons;
use app\models\PriceGroup;
use app\models\PriceItems;
use app\models\TimelineDays;
use app\models\TimeLines;
use app\models\Workplaces;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Url;
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

    public function actionTest()
    {
        Extra::socketAsyncCall(["/site/schedule-parse"]);
    }

    public function actionMainPage()
    {
        $allPersons = Persons::find()->
        select("p.*")->distinct()
            ->from(["p" => "sd_persons"])
            ->leftJoin(["t" => "sd_traits"], "p.person_id = t.person_id")
            ->where(["and",
                ["not", ["p.education" => null]],
                ["p.removed" => null],
                ["t.title" => "Основное место работы"]

            ])->all();
        $persons = [];
        if (count($allPersons) <= 3) {
            $persons = $allPersons;
        } else {
            $loopGuard = 0;
            while (count($persons) < 3 && $loopGuard < 1000) {
                $addedPerson = $allPersons[mt_rand(0, count($allPersons) - 1)];
                if (!in_array($addedPerson, $persons)) {
                    $persons[] = $addedPerson;
                }
                $loopGuard++;
            }
        }
        return $this->render('main-page', [
            "persons" => $persons,
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

    public function actionLoadPrice()
    {
        $file_path = __DIR__ . "/../data/gz_tmp.gz";
        $time_file = "load_price_time.txt";
//        $url='https://selenda24.ru/npcud/api.php?cmd=get_services_all&key=f611d62ad56645d4bf4a897a799ef7f6';
        $url = "https://smartclinic.ms/506732/api.php?cmd=get_services_all&key=wj9et6piuKQ12itogh98ai4ax76Rex0p";
        $status = 0;
        $last_load_time = intval(file_get_contents($time_file));
        if ((time() - $last_load_time) > (60 * 60 * 24)) {
            echo "Пытаюсь грузить<br>";
            $c = curl_init();
            curl_setopt($c, CURLOPT_URL, $url);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c, CURLOPT_HEADER, true);
            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($c, CURLOPT_SSLVERSION, 3);
            $result = curl_exec($c);
            $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
            $headerSize = curl_getinfo($c, CURLINFO_HEADER_SIZE);
            curl_close($c);
        } else {
            echo "Не время еще";
            exit;
        }
        if ($status == 200) {
            $content_gz = substr($result, $headerSize);
            $f = fopen($file_path, 'w');
            fwrite($f, $content_gz);
            fclose($f);
            file_put_contents($time_file, time());
        } else {
            echo "Ошибка чет " . $status;
            exit;
        }
        echo "Все вроде ок";
        exit;
    }


    public function actionParsePrice()
    {
        echo "start";
        shell_exec("php ../yii parse/price");
        echo "end";
        exit;
    }


    public function actionLoadSchedule($code)
    {
        function writeLog($text, $fName = "error_log.txt")
        {
            $f = fopen($fName, 'a');
            $s = date("Y-m-d H:i:s " . $_SERVER["REMOTE_ADDR"]) . " " . $text . "\n";
            fwrite($f, $s);
        }

        if ($code !== "41445463905c0ed3ebb1e694a8d7ab") {
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

        $fName = "schedule_" . date("Y-m-d-H-i-s") . ".json";
        $fn_suffix = 1;
        while (file_exists("../data/" . $fName)) {
            $fName = "schedule" . $fn_suffix . "_" . date("Y-m-d-H-i-s") . ".json";
            $fn_suffix++;
        }

        file_put_contents("../data/" . $fName, $postData['json']);
        Yii::$app->db->createCommand("INSERT INTO sd_loaded_schedules SET fileName=\"" . $fName . "\",  loadTime=\"" . date("Y-m-d H:i:s") . "\"")->execute();

        //Обрабока данных - дергаем через сокет скрипт, который дергает команду Yii (потому что скрипт сдохнет через 30 секунд, а команда отработает сколько надо)
        Extra::socketAsyncCall(["/site/schedule-parse"]);

        return 'TRUE';
    }


    public function actionScheduleParse()
    {
        echo "start<br>";
        shell_exec("php ../yii parse/schedules");
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

    public function actionRegistrationAnalysis()
    {
        if (Yii::$app->params["mainHost"] === "http://sd") {
            $registerStartDelay = .5; //min
            $registerEndDelay = 10; //min
            $hits = (new Query())->select("*")
                ->from("sd_hit_counter")
                ->all();

            foreach ($hits as $key => $hit) {
                $hits[$key]["startPeriod"] = date("Y-m-d H:i:s", (strtotime($hit["hitTime"]) + 60 * $registerStartDelay));
                $hits[$key]["endPeriod"] = date("Y-m-d H:i:s", (strtotime($hit["hitTime"]) + 60 * $registerEndDelay));
                $hits[$key]["regs"] = (new Query())->select("tc.timelineId, ls.loadTime, p.lastname, p.firstname, p.patronymic, c.city, c.crm_id, tc.start, tc.end")
                    ->from(["tc" => "sd_timeline_cells"])
                    ->leftJoin(["ls" => "sd_loaded_schedules"], "ls.fileName=tc.source")
                    ->leftJoin(["tl" => "sd_timelines"], "tc.timelineId=tl.id")
                    ->leftJoin(["p" => "sd_persons"], "p.person_id=tl.person_id")
                    ->leftJoin(["wp" => "sd_workplaces"], "wp.workplace_hash=tl.workplace_hash")
                    ->leftJoin(["c" => "sd_clinics"], "c.hash_id=wp.clinic_hash")
                    ->where(["and",
                            ["free" => 0],
                            [">", "ls.loadTime", $hits[$key]["startPeriod"]],
                            ["<", "ls.loadTime", $hits[$key]["endPeriod"]],
                            //Разница между моментом, когда зарегистрирован талон и временем посещения врача - не менее 6 часов
                            //Чтобы отфильтровать варианты, когда запись производится по факту посещения
                            "ADDTIME(ls.loadTime, \"6:0:0\")<tc.start",
                            //Посещения, произошедшие к настоящему моменту
                            ["<", "tc.start", date("Y-m-d H:i:s")]
                        ]

                    )
                    ->all();
            }

            return $this->render("registration-analysis", [
                "hits" => $hits
            ]);
        }
    }

    public function actionLoginCrm()
    {
        $client = new Client([
            'verify' => false,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0',
                'Cookie' => 'PHPSESSID_506732=08i9skqho66bo9ats5r5po3m85',
            ]
        ]);

        $page3 = $client->request("POST", 'https://smartclinic.ms/506732/index.php', [
            'form_params' => [
                'AjaxRequest' => 'getDoctSchedEv',
                'subdivision' => Yii::$app->request->post("subdivision"),
                'model' => '0',
                'schedule_mode' => '1',
                'workdays' => 'true',
                'client_time' => date("Y-m-d H:i:s"),
                'date' => Yii::$app->request->post("date"),
            ],
        ]);
        $json = $page3->getBody()->getContents();
        $resp = json_decode($json);
        preg_match_all(
            "|onclick=\"showDoctSchedule\\((.+?),(.+?)\\)\" ><span class=\"gEvDSName\".*?>([А-Я].+?)</span>|",
            $resp->grid,
            $matches
        );
        $personIds = [];
        foreach ($matches[3] as $n => $fio) {
            $personIds[$matches[3][$n]] = $matches[1][$n];
        }
        $doctorName = str_replace(" ", "&nbsp;", Yii::$app->request->post("fio"));
        $personNames = [];
        foreach ($matches[3] as $n => $fio) {
            $personNames["id" . $matches[1][$n]] = $matches[3][$n];
        }

       foreach ($resp->gridEvents as $k => $v) {
            if (array_key_exists("id" . $v->id_doct_schedule, $personNames)) {
                if ($personNames["id" . $v->id_doct_schedule] === $doctorName) {
                    if ($v->start_time === Yii::$app->request->post("start_time")) {
                        $ret = "<table><tr><td>";
                        $ret .= Yii::$app->request->post("record_time") . "</td><td>";
                        $ret .= Yii::$app->request->post("subdivision") . "</td><td>";
                        $ret .= $personNames["id" . $v->id_doct_schedule] . "</td><td>";
                        $ret .= Yii::$app->request->post("date")." ".$v->start_time  . "</td><td>";
                        $ret .= $v->id_patient . "<td><td>";
                        $ret .= $v->name . "<td><td>";
                      //  $ret .= "id_doct_schedule:".$v->id_doct_schedule. "<td><td>";
                        $ret .= "</tr></table><br><br>";

                        $pageRec=$client->get("https://smartclinic.ms/506732/index.php?AjaxRequest=load_template&name=patient_services&id_patient=".$v->id_patient);

                        $ret .= $pageRec->getBody()->getContents();
                        $ret .= "<br><br>";
                    }
                }
            }
        }

        return $ret;
    }
}
