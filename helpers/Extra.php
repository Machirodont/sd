<?php


namespace app\helpers;


class Extra
{
    /**
     * [
     *  [$field="val1"],
     *  [$field="val2"],
     *  [$field="val3"],
     * ]
     * = "val1 val2 val3"
     *
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

    /**
     * [
     *  [$field="val3"],
     *  [$field="val1"],
     *  [$field="val2"],
     * ]
     * =
     * [
     *  [$field="val1"],
     *  [$field="val2"],
     *  [$field="val3"],
     * ]
     *
     * @param $arr array
     * @param $field string
     * @return array
     */
    public static function sortByField($arr, $field)
    {
        $sorted = $arr;
        usort($sorted, function ($a, $b) use ($field) {
            return $a[$field] > $b[$field];
        });
        return $sorted;
    }

}