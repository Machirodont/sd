<?php
use yii\helpers\Html;
use \yii\helpers\Url;
use app\models\Persons;

/* @var $activeDays array */
/* @var $startDay string */
/* @var $period integer */
?>

<?php
    $dateCounter = new DateTime(date("Ymd"));
    $dateCounter = new DateTime($startDay);
    $startWeekDay = intval($dateCounter->format("N"));
    $dateCounter->sub(new DateInterval('P' . ($startWeekDay - 1) . 'D'));
    $yesterdayMonth = "";
    $interval = new DateInterval('P1D');
    for ($i = 0; $i < $period; $i++) {
        if ($yesterdayMonth !== $dateCounter->format("m")) {
            echo $dateCounter->format("F");
            echo "<table class=\"table\">";
            if ($dateCounter->format("N") !== "1") {
                echo "<td style='border:none;' colspan='" . (intval($dateCounter->format("N")) - 1) . "'> </td>";
            }
        }
        if ($dateCounter->format("N") === "1") echo "<tr>";
        ?>
        <td class="text-center <?= array_key_exists($dateCounter->format("Y-m-d"), $activeDays) ? "success" : ""; ?>"> <?= $dateCounter->format("j"); ?></td>
        <?php
        if ($dateCounter->format("N") === "7") echo "</tr>";
        if ($dateCounter->format("j") === $dateCounter->format("t")) echo "</table>";
        $yesterdayMonth = $dateCounter->format("m");
        $dateCounter->add($interval);
    }
?>