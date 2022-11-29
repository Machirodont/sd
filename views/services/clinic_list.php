<?php
/* @var $this yii\web\View
 * @var $clinicList \app\models\Clinic[]
 */

use yii\helpers\Html;

?>
<h1>Выберите клинику:</h1>
<ul>
    <?php
    foreach ($clinicList as $clinic) {
        ?>
        <li><?= Html::a($clinic->city, ["/services/index", "cid" => $clinic->id]) ?></li>
        <?php
    }
    ?>
</ul>
