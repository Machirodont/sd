<?php
/**
 * Created by PhpStorm.
 * User: a.ivanitsky
 * Date: 15.01.2019
 * Time: 17:31
 */

namespace app\models;


use app\models\Generated\ShedulersGenerated;

class Sheduler extends ShedulersGenerated
{
    static public function parceFile($fileName)
    {
        $s=file_get_contents($fileName);
        $o=json_decode($s);
        return $o;
    }
}