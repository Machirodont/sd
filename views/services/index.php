<?php
/* @var $this yii\web\View
 * @var $groups array
 * @var $items array
 */

use yii\helpers\Html;
?>
<ul>
<?php
foreach ($groups as $group){
    /**@var $group \app\models\PriceGroup */
    echo "<li>".Html::a($group->groupName, ["/services/index", "id"=>$group->id])."</li>";
}
?>
</ul>

<ul>
    <?php
    foreach ($items as $item){
        /**@var $item \app\models\PriceItems */
        if($item->price) {
            echo "<li>" . $item->name . " - " . $item->price . "</li>";
        }
    }
    ?>
</ul>
