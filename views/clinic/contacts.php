<?php
/* @var $this yii\web\View
 * @var $clinic \app\models\Clinic
 */

use app\models\Clinic;
use yii\helpers\Html;
?>
<h2>Контакты медицинского центра «Столичная диагностика» - <?= $clinic->city ?></h2>
<?= Html::a("Врачи >> ", ["persons/index", "cid"=>$clinic->id]) ?>
<br><br>
<?= $clinic->htmlDescription ?>
