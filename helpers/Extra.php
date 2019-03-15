<?php


namespace app\helpers;


class Extra
{
    /**
     * @param $arr array
     * @param $field string
     * @return string
     */
    public static function implodeField($arr, $field, $glue = " ")
    {
        $s = "";
        if (count($arr) === 0) return "";
        for ($i = 0; $i < count($arr); $i++) {
            if ($i > 0) $s .= $glue;
            if (isset($arr[$i][$field]))
                $s .= $arr[$i][$field];
        }
        return $s;
    }

    public static function sortByField($arr, $field)
    {
        $sorted = $arr;
        usort($sorted, function ($a, $b) use ($field) {
            return $a[$field] > $b[$field];
        });
        return $sorted;
    }

}