<?php

/* @var $this yii\web\View
 * @var $blocks array
 */

use app\assets\PhoneFormat;
use yii\helpers\Html;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);
PhoneFormat::register($this);
?>
    <h3>Запись на прием</h3>
<?php
foreach ($blocks as $block) {
    echo $this->render($block["view"], $block["params"]);
}








