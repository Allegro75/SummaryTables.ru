<?php
require_once('../../wildstat/parser-3_euroleague.php');
// echo($finYear);
$newFileRawContent = file_get_contents("http://itgid-php.ru/football/eurocups/euroleague/EL.php?year={$finYear}");
// echo($newFileRawContent);

file_put_contents("el_{$finYear}.html", $newFileRawContent);
