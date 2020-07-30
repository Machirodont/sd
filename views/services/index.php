<?php
/* @var $this yii\web\View
 * @var $groups array
 * @var $items array
 * @var $group \app\models\PriceGroup
 */

use yii\helpers\Html;

?>
<h1><?= $group ? $group->groupName : "Прайс-лист - цены на услуги" ?></h1>
<ul>
    <?php
    foreach ($groups as $group) {
        /**@var $group \app\models\PriceGroup */
        echo "<li>" . Html::a($group->groupName, ["/services/index", "id" => $group->id, "cid" => Yii::$app->session->get("cid")]) . "</li>";
    }
    ?>
</ul>

<ul>
    <?php
    foreach ($items as $item) {
        /**@var $item \app\models\PriceItems */
        if ($item->price) {
            echo "<li>" . $item->name . " - " . $item->price . " руб.</li>";
        }
    }
    ?>
</ul>
