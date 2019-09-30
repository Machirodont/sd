<?php
header('Content-Type: text/html; charset=utf-8');

$filialPriceKey = [
    "Клинцы" => "Клинцы",
    "Климово" => "Климово",
    "Новозыбков" => "Клинцы",
    "Почеп" => "Климово",
    "Стародуб" => "Климово",
    "Унеча" => "Климово",
    "Трубчевск" => "Климово",
];

$filial = null;

if (array_key_exists("filial", $_GET) && array_key_exists($_GET["filial"], $filialPriceKey)) {
    $filial = $_GET["filial"];
}

if (is_null($filial)) {
    ?>
    <h3>Стоимость услуг в филиалах сети медицинских центров "Столичная диагностика":</h3>
    <?php
    foreach ($filialPriceKey as $fk => $fp) {
        ?>
        <li><a href="price_sdmed.php?filial=<?= $fk ?>"><?= $fk ?></a><br>
        <?php
    }
    exit;
}

$file_path = "gz_tmp.gz";
if ((time() - 60 * 60 * 12) > filemtime($file_path)) {
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'https://smartclinic.ms/506732/api.php?cmd=get_services_all&key=wj9et6piuKQ12itogh98ai4ax76Rex0p');
//curl_setopt($c, CURLOPT_URL, 'https://selenda24.ru/npcud_test/api.php?cmd=get_services_all&key=f611d62ad56645d4bf4a897a799ef7f6');
//curl_setopt($c, CURLOPT_URL, 'https://news.google.com/');
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_HEADER, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($c, CURLOPT_SSLVERSION, 3);
    $result = curl_exec($c);
    $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($c, CURLINFO_HEADER_SIZE);
    curl_close($c);

    if ($status != 200) {
        echo "Error: $status </br>";
        exit;
    } else {
        $content_gz = substr($result, $headerSize);
        $f = fopen($file_path, 'w');
        fwrite($f, $content_gz);
        fclose($f);
    }
}

$zp = gzopen($file_path, "r");
$data_links = gzread($zp, 10000000);
gzclose($zp);
$arr = json_decode($data_links, true);
?>
    <style>
        table.pricetable {
            border-collapse: collapse;
        }

        .pricetable td {
            border: solid 1px #AAA;
        }

        .pricetable tr:nth-child(odd) td {
            background-color: #dbe2e5;
        }
    </style>

    Стоимость услуг Медицинского Центра "<a href="/">Столичная Диагностика</a>"<br>
    Филиал г. <b><?= $filial; ?></b><br>
    <small><i>Последнее обновление данных: <?= date("Y-m-d H:i:s", filemtime($file_path)) ?></i></small><br><br>
    <table class='pricetable'>
        <tr>
            <td>Код</td>
            <td>Наименование</td>
            <td>Группа</td>
            <td>Цена, руб.</td>
            <td>Примечания</td>
        </tr>

        <?php
        for ($i = 0; $i < count($arr); $i++) {
            $groups = implode("; ", $arr[$i]["group"]);
            $terms = array_key_exists("terms", $arr[$i]) ? $arr[$i]["terms"] : "";
            $echoPrice = (array_key_exists($filialPriceKey[$filial], $arr[$i]["price_list"]) && $arr[$i]["price_list"][$filialPriceKey[$filial]] > 0)
                ? round($arr[$i]["price_list"][$filialPriceKey[$filial]])
                : "-";

            echo "<tr><td>" . $arr[$i]["code"] . "</td><td>" . $arr[$i]["name"] . "</td><td>" . $groups . "</td><td>" . ($echoPrice) . "</td><td>" . $terms . "</td></tr>";
        }

        ?>
    </table>
    <br><br>
    Вся информация на сайте является адресной, предназначена для лиц, нуждающихся в медицинской помощи и не является
    публичной офертой.
    <br>
    Многопрофильный медицинский центр «СТОЛИЧНАЯ ДИАГНОСТИКА» <?= date("Y") ?>