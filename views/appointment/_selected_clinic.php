<?php

/* @var $this yii\web\View
 * @var $clinic Clinic
 */

use app\models\Clinic;
use yii\helpers\Html;
?>

<h4>Выбрана клиника: <?= $clinic->city ?></h4>
<?= Html::a("Изменить выбор клиники ...", ["appointment/create", "cid" => 0]) ?> <br>






