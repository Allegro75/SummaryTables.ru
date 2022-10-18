<?php

function changeFile($file) {
    $origContent = file_get_contents($file);

    $afterH1openIndex = strpos($origContent, '<h1>') + 4;
    $h1CloseIndex = strpos($origContent, '</h1>');
    $headerLength = $h1CloseIndex - $afterH1openIndex;
    $header = substr($origContent, $afterH1openIndex, $headerLength);
    // echo $header;

    // $dashIndex = strpos($header, ' - ');
    // $club1 = substr($header, 0, $dashIndex);
    // $club2 = substr($header, $dashIndex + 3);
    // echo '<br>'. $club1 . '<br>'. $club2;

    $strToInsert = $header . '. ';
    echo $strToInsert;
    $indexOfInsertStart = strpos($origContent, '"description" content="') + 23;

    $newContent = substr_replace($origContent, $strToInsert, $indexOfInsertStart, 0);
    // echo '<br>' . $newContent;
    file_put_contents($file, $newContent);
}

$dir = 'small-tables';
// $dir = 'st-test';
$folder = opendir($dir);
while ($doc = readdir($folder)) {
    if (($doc != '.') && ($doc != '..')) {
        $fileName = $dir . '/' . $doc;
        changeFile($fileName);
    }
}
closedir($folder);
