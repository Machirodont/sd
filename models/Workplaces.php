<?php
/**
 * Created by PhpStorm.
 * User: a.ivanitsky
 * Date: 05.03.2019
 * Time: 17:25
 */

namespace app\models;


use app\models\Generated\WorkplacesGenerated;

class Workplaces extends WorkplacesGenerated
{
    public static function findByHash($hash)
    {
        $res = Workplaces::find()
            ->where(["workplace_hash" => $hash])
            ->all();
        if (count($res) === 1) return $res[0];
        return null;
    }

}