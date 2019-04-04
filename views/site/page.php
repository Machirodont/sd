<?php

/* @var $this yii\web\View */
/* @var $page \app\models\Pages */

use yii\helpers\Html;
use \yii\helpers\Url;

$this->title = $page->title;
$this->registerMetaTag(["name"=>"description", "content"=>$page->description]);
$this->registerMetaTag(["name"=>"keywords", "content"=>$page->keywords]);
$this->registerLinkTag(["rel"=>"canonical", "href"=>Url::toRoute(["/site/page", "id"=>$page->id], true)]);
?>

<?= $page->content ?>