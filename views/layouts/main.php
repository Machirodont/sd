<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\dropdown\DropdownX;
use yii\bootstrap\Dropdown;
use yii\bootstrap\ButtonDropdown;


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
                        'label' => 'Выберите клинику',
                        'dropdown' => [
                            'items' => [
                                ['label' => 'Все', 'url' => urlWithCID(0)],
                                'Московская область',
                                ['label' => 'Руза', 'url' => urlWithCID(2)],
                                ['label' => 'Тучково', 'url' => urlWithCID(1)],
                                '<li class="divider"></li>',
                                'Брянская область',
                                ['label' => 'Клинцы', 'url' => urlWithCID(6)],
                                ['label' => 'Новозыбков', 'url' => urlWithCID(7)],
                                ['label' => 'Климово', 'url' => urlWithCID(9)],
                                ['label' => 'Почеп', 'url' => urlWithCID(8)],
                                ['label' => 'Стародуб', 'url' => urlWithCID(4)],
                            ],
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
            'class' => 'navbar',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Сотрудники', 'url' => ['/persons/index', "cid" => Yii::$app->session->get("cid")]],
            ['label' => 'Клиники', 'url' => ['/clinic/index', "cid" => Yii::$app->session->get("cid")]],
            ['label' => 'Контакты', 'url' => ['/clinic/contacts', "cid" => Yii::$app->session->get("cid")]],
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
