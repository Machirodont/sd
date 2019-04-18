<?php


namespace app\helpers;

use yii\helpers\Url;


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

    /**
     * @param $route array
     */
    public static function socketAsyncCall($route)
    {
        $parts = parse_url(Url::toRoute($route, true));

        if (!$fp = fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80)) {
            return false;
        }

        fwrite($fp, "GET " . (!empty($parts['path']) ? $parts['path'] : '/') . " HTTP/1.1\r\n");
        fwrite($fp, "Host: " . $parts['host'] . "\r\n");
        fwrite($fp, "Connection: Close\r\n\r\n");
        fclose($fp);
        return true;
    }

    public static function writeLog($text, $fName = "error_log.txt")
    {
        $f = fopen($fName, 'a');
        $s = date("Y-m-d H:i:s " . (array_key_exists("REMOTE_ADDR",$_SERVER) ? $_SERVER["REMOTE_ADDR"] : "local")) . " " . $text . "\n";
        fwrite($f, $s);
    }

}