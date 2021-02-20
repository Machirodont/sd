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
        $host = $parts['host'];

        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false
            ]
        ]);

        $hostname = "ssl://" . $host . ":443";
        $fp = stream_socket_client($hostname, $errno, $errstr, ini_get("default_socket_timeout"), STREAM_CLIENT_CONNECT, $context);

        if (!$fp) {
            echo $errno . ":" . $errstr;
            return false;
        }

        $send = "";

        $send .= "GET " . (!empty($parts['path']) ? $parts['path'] : '/') . " HTTP/1.1\r\n";
        $send .= "Host: " . $host . "\r\n";
        $send .= "Connection: close\r\n\r\n";
        fputs($fp, $send);
        fclose($fp);
        return true;
    }

    public static function writeLog($text, $fName = null)
    {
        if (is_null($fName)) $fName = __DIR__ . "/../stage/" . "error_log.txt";
        $f = false;
        $stuckGuard = 0;
        while ($f === false && $stuckGuard < 1000) {
            try {
                $f = fopen($fName, 'a');
            } catch (\Exception $e) {
                $f = false;
            }
            $stuckGuard++;
        }
        if ($f) {
            $s = date("Y-m-d H:i:s " . (array_key_exists("REMOTE_ADDR", $_SERVER) ? $_SERVER["REMOTE_ADDR"] : "local")) . " " . $text . "\n";
            fwrite($f, $s);
            fclose($f);
        }
    }

}