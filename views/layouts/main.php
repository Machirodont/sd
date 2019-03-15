<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="http://bg.allfont.net/allfont.css?fonts=benguiat-rus" rel="stylesheet" type="text/css"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header class="header-a">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 header-logo"><a href="/"><img src="/images/logo100.jpg"></a></div>
            <div class="col-sm-6 header-info">
                <div class="col-md-6 head-phone-number">+7(800)123-45-67</div>
                <div class="col-md-6">
                    <?php
                    $route = Yii::$app->request->queryParams;
                    $r = "/" . Yii::$app->requestedRoute;
                    unset($route["cid"]);
                    unset($route["r"]);
                    array_unshift($route, $r);
                    $url_tmp = \yii\helpers\Url::toRoute($route);
                    $url_tmp .= (strpos($url_tmp, "?") === false) ? "?" : "&";
                    ?>
                    <?= Html::dropDownList("place", Yii::$app->session->get("cid"),
                        [
                            "" => "Выберите",//ToDO obf
                            "Московская область" => [
                                "2" => "Руза",
                                "1" => "Тучково",
                            ],
                            "Брянская область" => [
                                "6" => "Клинцы",
                                "7" => "Новозыбков",
                                "9" => "Климово",
                                "8" => "Почеп",
                                "4" => "Стародуб",
                            ],
                        ],
                        [
                            'class' => "form-control",
                            'onChange' => 'window.location.href="' . $url_tmp . 'cid="+this.value+"";',
                        ]
                    )
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
            'class' => 'navbar',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Сотрудники', 'url' => ['/persons/index']],
            ['label' => 'Клиники', 'url' => ['/clinic/index']],
            ['label' => 'Контакты', 'url' => ['/clinic/contacts']],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container breadcrumb-container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
