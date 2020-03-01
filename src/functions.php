<?php

function debug($code)
{
    echo '<pre>';
    print_r($code);
    echo '</pre>';
}

function task1($file)
{
    $fileData = file_get_contents($file);
    $xmlObj = new SimpleXMLElement($fileData);
    ?>

    <style>
        div {
            display: inline-block;
        }

        .parent, .wrapper {
            display: block;
        }

        .body {
            max-width: 250px;
            width: 100%;
            border: thin solid lightgray;
            border-radius: 4px;
            padding: 10px;
            margin: 5px;
        }
    </style>

    <div>
        <? foreach ($xmlObj->attributes() as $key => $attr) {
            if ($attr) { ?>
                <p><?= $key . ': ' . $attr ?></p>
            <? }
        } ?>
    </div>
    <div class="parent">
        <? foreach ($xmlObj as $a => $item) { ?>
            <? if ($a == 'Address') { ?>
                <div class="body">

                    <? foreach ($item->attributes() as $attr) {
                        if ($attr) { ?>

                            <p>
                                Type: <?= $attr ?>
                            </p>

                        <? }
                    } ?>


                    <? foreach ($item as $key => $value) { ?>

                        <p><?= $key . ': ' . $value ?></p>

                    <? } ?>


                </div>
            <? } elseif ($a == 'Items') { ?>
                <div class="wrapper">
                    <? foreach ($item as $key => $value) { ?>
                        <div class="body">
                            <? if ($key == 'Item') { ?>
                                <? foreach ($value as $num => $el) { ?>
                                    <p><?= $num . ': ' . $el ?></p>
                                <? } ?>
                            <? } else { ?>
                                <p><?= $key . ': ' . $value ?></p>
                            <? } ?>
                        </div>
                    <? } ?>
                </div>
            <? } ?>
        <? } ?>
    </div>
    <p><?= $xmlObj->DeliveryNotes; ?></p>

<? }

function task2()
{
    $arr = [
        'a' => 1,
        'b' => 'text',
        'c' => [
            0 => 'text',
            1 => 'text2'
        ]
    ];

    $filename = 'output.json';

    file_put_contents($filename, json_encode($arr));

    $rand = rand(0, 1);
    if ($rand == 1) {
        $file = fopen($filename, 'c+');
        $text = fread($file, filesize($filename));
        $text = json_decode($text);
        $text->d = rand(3,15);
        file_put_contents('output2.json', json_encode($text));
    }

    $out1 = file_get_contents($filename);
    $out2 = file_get_contents('output2.json');

    $out1 = (array) json_decode($out1);
    $out2 = (array) json_decode($out2);

    $res = array_diff_assoc($out2, $out1);
    debug($res);
}

function task3()
{
    $arr = [];
    for ($i = 1; $i <= 50; $i++) {
        $arr[$i] = rand(1, 100);
    }

    $fp = fopen('file.csv', 'w');
    fputcsv($fp, $arr, ';');
    fclose($fp);

    $fp = fopen('file.csv', 'r');
    $sum = 0;
    $arrRes = [];
    while ($data = (fgetcsv($fp, 1000*1024, ';'))) {
        $arrRes = $data;
    }

    for ($i = 0; $i <= count($arrRes); $i++) {
        if ($arrRes[$i] % 2 == 0) {
            $sum += $arrRes[$i];
        }
    }

    debug($sum);

}

function task4($addr)
{
    $res = file_get_contents($addr);
    $res = (array) json_decode($res);
    $res = (array) $res['query']->pages;

    debug($res['15580374'] -> pageid);
    debug($res['15580374'] -> title);
}