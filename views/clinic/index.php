<?php
/*
 * @var $this yii\web\View
 * @var $clinics array
 */

use \yii\helpers\Html;
$this->title = "Клиники";
?>
<h1>Клиники</h1>
<ul>
<?php
foreach ($clinics as $clinic){
   /* @var $clinic \app\models\Clinic */
    echo "<li>".Html::a($clinic->city, ["/clinic/contacts", "cid"=>$clinic->id])."</li>";
}
?>
</ul>
