<?php
/* @var $this yii\web\View
 * @var $clinic \app\models\Clinic
 */

use app\models\Clinic;
use yii\helpers\Html;

$this->title = "Контакты медицинского центра «Столичная диагностика» ".$clinic->in;
$this->registerMetaTag(["name" => "description", "content" => $this->title]);
$this->registerMetaTag(["name" => "keywords", "content" => "Медицинский центр, столичная диагностика, контакты, ".$clinic->city.", ".$clinic->phone]);


?>
<h2>Контакты медицинского центра «Столичная диагностика» - <?= $clinic->city ?></h2>
<?= Html::a("Специалисты", ["persons/index", "cid"=>$clinic->id], ["class"=>"clinic_select"]) ?>
<?= Html::a("Прайс-лист", ["services/index", "cid"=>$clinic->id], ["class"=>"clinic_select"]) ?>
<br><br>
<?= $clinic->htmlDescription ?>
