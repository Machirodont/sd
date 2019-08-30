<?php

/* @var $this yii\web\View */

/* @var $hits array */

use yii\helpers\Html;

function fio($reg)
{
    return $reg["lastname"] . "&nbsp"
        . mb_substr($reg["firstname"], 0, 1) . "."
        . mb_substr($reg["patronymic"], 0, 1) . ".";

}

?>

<table class="table">
    <?php foreach ($hits as $hit) { ?>
        <tr>
            <td><?= $hit["id"] ?></td>
            <td><?= $hit["cid"] ?></td>
            <td><?= $hit["hitTime"] ?></td>
            <td>
                <table class="table table-bordered">

                    <?php foreach ($hit["regs"] as $reg) { ?>
                        <tr>
                            <td><?= $reg["loadTime"] ?></td>
                            <td><?= fio($reg) ?></td>
                            <td><?= $reg["city"] . " (" . $reg["crm_id"] . ")" ?></td>
                            <td><?= $reg["start"] ?></td>
                            <td><?= $reg["end"] ?></td>
                            <td>
                                <?= Html::beginForm("/site/login-crm", "post", ['target' => "_blank"]) ?>
                                <input type="hidden" name="fio" value="<?= fio($reg) ?>">
                                <input type="hidden" name="date"
                                       value="<?= mb_substr($reg["start"], 0, mb_strpos($reg["start"], " ")) ?>">
                                <input type="hidden" name="start_time"
                                       value="<?= mb_substr($reg["start"], mb_strpos($reg["start"], " ")+1) ?>">
                                <input type="hidden" name="subdivision" value="<?= $reg["crm_id"] ?>">
                                <input type="hidden" name="record_time" value="<?= $reg["loadTime"] ?>">
                                <input type="submit" value="i">
                                <?= Html::endForm(); ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>


            </td>
        </tr>

        <?php
    }
    ?>
</table>
