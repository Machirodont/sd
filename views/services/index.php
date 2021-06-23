<?php
/* @var $this yii\web\View
 * @var $groups array
 * @var $items array
 * @var $group \app\models\PriceGroup
 */

use yii\helpers\Html;

?>
Прайс-лист - цены на услуги*
<h1><?= $group ? $group->groupName : '' ?></h1>
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
<small>
    *Информация представлена в ознакомительных целях и не является публичной офертой.
    Обратите внимание, что актуальные цены могут отличаться от представленных на сайте из-за задержки синхронизации. <br>
    <?= file_exists('../stage/load_price_time.txt') ? 'Последняя проверка '.date("H:i d.m.Y", file_get_contents('../stage/load_price_time.txt')+3*60*60/*+3 МСК*/) : "" ?>.
    <?= file_exists('../stage/parse_price_time.txt') ? 'Последнее обновление '.date("H:i d.m.Y", file_get_contents('../stage/parse_price_time.txt')+3*60*60/*+3 МСК*/) : "" ?>.
</small>