<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\components\SdUrlRule;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\ButtonDropdown;
use app\models\Clinic;

AppAsset::register($this);
$clinic = Clinic::findOne(\Yii::$app->session->get("cid"));
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="yandex-verification" content="10f48b318206f633"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript"> (function (m, e, t, r, i, k, a) {
        m[i] = m[i] || function () {
            (m[i].a = m[i].a || []).push(arguments)
        };
        m[i].l = 1 * new Date();
        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
    })(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
    ym(51184940, "init", {clickmap: true, trackLinks: true, accurateTrackBounce: true, webvisor: true}); </script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/51184940" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript> <!-- /Yandex.Metrika counter -->
<header class="header-a">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 header-logo">
                <a href="/">
                    <img src="/images/logo100_0.jpg">
                    <div class="head-name">
                        <?= $clinic ? "Медицинский центр" : "Сеть медицинских центров" ?><br>
                        &laquo;СТОЛИЧНАЯ ДИАГНОСТИКА&raquo;<br>
                        <?= $clinic ? "&nbsp;<strong>" . $clinic->city . "</strong>" : "" ?>
                    </div>
                </a>
            </div>
            <div class="col-sm-4 flex flex-column header-info">
                <?php $phone = $clinic ? $clinic->phone : "+7(915) 480-03-03"; ?>
                <div class="head-phone-number" data-cid="<?= ($clinic && $clinic->id) ? $clinic->id : 0 ?>">
                    <a href="tel:<?= $phone ?>"><?= $phone ?></a>
                </div>
                <div class="">
                    <?= ButtonDropdown::widget([
                        'label' => ($clinic ? 'Выбрать другую клинику' : 'Выберите клинику'),
                        'dropdown' => [
                            'items' => [
                                ['label' => 'Все', 'url' => SdUrlRule::urlWithCID(0)],
                                ['label' => 'Гагарин', 'url' => SdUrlRule::urlWithCID(5)],
                                ['label' => 'Руза', 'url' => SdUrlRule::urlWithCID(2)],
                                ['label' => 'Тучково', 'url' => SdUrlRule::urlWithCID(1)],
                            ],
                        ],
                        'options' => [
                            'class' => ($clinic ? "btn-info" : "btn-danger")
                        ]
                    ]);
                    ?>

                    <?=
                    Yii::$app->user->isGuest ? "" : Html::a("Запись к врачу", ["/appointment/create"], ['class' => "btn btn-success"])
                    ?>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="wrap">
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar navbar-default',
        ],
    ]);
    $pages = \app\models\Pages::find()->where("id > 4")->orderBy("title")->all();
    $pagesItems = [];
    foreach ($pages as $page) {
        $pagesItems[] = ["label" => $page->title, "url" => ['/site/page', "id" => $page->id]];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            /*
        [
            'label' => 'Запись к врачу',
            'url' => ['/appointment'],
            'options' => ["style" => "background-color:rgb(92, 184, 92);"],
            'linkOptions' => ["style" => "color: white;"]
        ],*/
            [
                'label' => 'Услуги',
                'items' => $pagesItems
            ],
            ['label' => 'Специалисты', 'url' => ['/persons/index', "cid" => Yii::$app->session->get("cid")]],
            ['label' => 'Клиники', 'url' => ['/clinic/index', "cid" => Yii::$app->session->get("cid")]],
            ['label' => 'Контакты', 'url' => ['/clinic/contacts', "cid" => Yii::$app->session->get("cid")]],
            ['label' => 'Юридическая информация', 'url' => ['/clinic/company', "cid" => Yii::$app->session->get("cid")]],
            ['label' => 'Цены', 'url' => ["services/index", "cid" => Yii::$app->session->get("cid")]],
            [
                'label' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->login : "guest",
                'visible' => !Yii::$app->user->isGuest,
                'items' => [
                    [
                        'label' => 'Промо',
                        'url' => ['/promo/index'],
                        'visible' => !Yii::$app->user->isGuest,
                    ],
                    [
                        'label' => 'Врачи',
                        'url' => ['/persons/list'],
                        'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->is_admin,
                    ],
                    [
                        'label' => 'Пользователи',
                        'url' => ['/users/index'],
                        'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->is_admin,
                    ],
                    [
                        'label' => 'Заявки',
                        'url' => ['/site/appointment-index'],
                        'visible' => !Yii::$app->user->isGuest,
                    ],
                    [
                        'label' => 'Выход',
                        'url' => ['site/logout'],
                        'visible' => !Yii::$app->user->isGuest,
                        'linkOptions' => [
                            'data' => [
                                'method' => 'post'
                            ]
                        ]
                    ],
                ]
            ],

        ],
    ]);
    NavBar::end();
    ?>

    <div class="container breadcrumb-container">
        <?= Breadcrumbs::widget([
            'homeLink' => [
                'label' => 'Главная',
                'url' => \yii\helpers\Url::toRoute(["/site/main-page"]),
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>
    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>


</div>

<footer class="footer">
    <div class="container text-center">
        «СТОЛИЧНАЯ ДИАГНОСТИКА» - сеть медицинских центров. &copy; <?= date("Y") ?>
    </div>
    <div>
        <!--LiveInternet counter-->
        <script type="text/javascript">
            document.write("<a href='//www.liveinternet.ru/click' " +
                "target=_blank><img src='//counter.yadro.ru/hit?t44.10;r" +
                escape(document.referrer) + ((typeof (screen) == "undefined") ? "" :
                    ";s" + screen.width + "*" + screen.height + "*" + (screen.colorDepth ?
                    screen.colorDepth : screen.pixelDepth)) + ";u" + escape(document.URL) +
                ";h" + escape(document.title.substring(0, 150)) + ";" + Math.random() +
                "' alt='' title='LiveInternet' " +
                "border='0' width='31' height='31'><\/a>")
        </script><!--/LiveInternet-->
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
