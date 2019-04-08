<?php
/* @var $this yii\web\View
 * @var $clinic \app\models\Clinic
 */

use app\models\Clinic;
use yii\helpers\Html;
?>
<h2>Контакты медицинского центра «Столичная диагностика» - <?= $clinic->city ?></h2>
<?= Html::a("Специалисты", ["persons/index", "cid"=>$clinic->id], ["class"=>"clinic_select"]) ?>
<?= Html::a("Прайс-лист", ["services/index", "cid"=>$clinic->id], ["class"=>"clinic_select"]) ?>
<br><br>
<?= $clinic->htmlDescription ?>
