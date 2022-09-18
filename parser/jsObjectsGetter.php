
<?

// Получаем веб-страницу из Сети
if (true) {
    // $originalFileContent = file_get_contents("https://www.championat.com/football/_ucl/tournament/4993/calendar/");
    // echo $originalFileContent;

    $ch = curl_init("https://www.championat.com/football/_ucl/tournament/4993/calendar/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $html = curl_exec($ch);
    curl_close($ch);
    
    echo $html;
}
