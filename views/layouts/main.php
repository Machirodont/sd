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
            <div class="col-sm-6"><img src="/images/tmp_logo100.jpg"></div> <?php //ToDO obf ?>
            <div class="col-sm-6 header-info">
                <div class="col-md-6 head-phone-number" style="color:#141f93">+7(800)123-45-67</div> <?php //ToDO obf ?>
                <div class="col-md-6">
                    <?= Html::dropDownList("place", null,
                        [
                            "" => "Выберите ваше подразделение",//ToDO obf
                            "Московская область" => [
                                "1" => "Руза",
                                "2" => "Тучково",
                            ],
                            "Брянская область" => [
                                "1" => "Клинцы",
                                "2" => "Новозыбков",
                                "3" => "Климово",
                                "4" => "Почеп",
                                "5" => "Стародуб",
                                "6" => "Унеча",
                            ],
                        ],
                        [
                            'class' => "form-control"
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
   //     'brandLabel' => Yii::$app->name,
   //     'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Сотрудники', 'url' => ['/persons/index']],
            ['label' => 'Клиники', 'url' => ['/clinic/index']],
            ['label' => 'Учреждения', 'url' => ['/institutions/index']],
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
            ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
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
