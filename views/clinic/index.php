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

    echo "<li><h3>Медицинский центр ".$clinic->in."</h3><ul>";
    echo "<li>".Html::a("Контактная информация", ["/clinic/contacts", "cid"=>$clinic->id])."</li>";
    echo "<li>".Html::a("Юридическая информация", ["/clinic/company", "cid"=>$clinic->id])."</li>";
    echo "</ul></li>";
}
?>
</ul>
