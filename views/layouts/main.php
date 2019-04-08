<?php

/* @var $this \yii\web\View */

/* @var $content string */

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
                <div class="head-phone-number"><?= $clinic ? $clinic->phone : "+7(915) 480-03-03" ?></div>
                <div class="">
                    <?php

                    function urlWithCID($cid)
                    {
                        $route = Yii::$app->request->queryParams;
                        $r = "/" . Yii::$app->requestedRoute;
                        unset($route["cid"]);
                        unset($route["r"]);
                        array_unshift($route, $r);
                        $route["cid"] = $cid;
                        return \yii\helpers\Url::toRoute($route);
                    }

                    ?>
                    <?= ButtonDropdown::widget([
                        'label' => ($clinic ? 'Выбрать другую клинику' : 'Выберите клинику'),
                        'dropdown' => [
                            'items' => [
                                ['label' => 'Все', 'url' => urlWithCID(0)],
                                ['label' => 'Гагарин', 'url' => urlWithCID(5)],
                                ['label' => 'Руза', 'url' => urlWithCID(2)],
                                ['label' => 'Тучково', 'url' => urlWithCID(1)],
                            ],
                        ],
                        'options' => [
                            'class' => ($clinic ? "btn-info" : "btn-danger")
                        ]
                    ]);
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
            [
                'label' => 'Услуги',
                'items' => $pagesItems
            ],
            ['label' => 'Специалисты', 'url' => ['/persons/index', "cid" => Yii::$app->session->get("cid")]],
            ['label' => 'Клиники', 'url' => ['/clinic/index', "cid" => Yii::$app->session->get("cid")]],
            ['label' => 'Контакты', 'url' => ['/clinic/contacts', "cid" => Yii::$app->session->get("cid")]],
            ['label' => 'Юридическая информация', 'url' => ['/clinic/company', "cid" => Yii::$app->session->get("cid")]],
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

<footer class="footer text-center">
    <div class="container">
        «СТОЛИЧНАЯ ДИАГНОСТИКА» - сеть медицинских центров. &copy; <?= date("Y") ?>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
