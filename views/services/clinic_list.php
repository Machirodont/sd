<?php
/* @var $this yii\web\View
 * @var $groups array
 * @var $items array
 * @var $group \app\models\PriceGroup
 */

use yii\helpers\Html;

?>
<h1>Выберите клинику:</h1>
<ul>
    <li><?= Html::a("Гагарин", ["/services/index", "cid" => 5]) ?></li>
    <li><?= Html::a("Руза", ["/services/index", "cid" => 2]) ?></li>
    <li><?= Html::a("Тучково", ["/services/index", "cid" => 1]) ?></li>
</ul>
