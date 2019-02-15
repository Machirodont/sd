<?php
/* @var $this yii\web\View
 * @var $clinic \app\models\Clinic
 */

use app\models\Clinic;
use yii\helpers\Html;
?>
<h1>«Столичная диагностика» - <?= $clinic->city ?></h1>
<h2>Контакты</h2>
<?= Html::a("Врачи", ["persons/index", "cid"=>$clinic->id]) ?>