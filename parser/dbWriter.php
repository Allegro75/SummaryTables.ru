
<?

$clubsAndMatchesArr = json_decode(file_get_contents('php://input'), true);
$rawClubsArr = $clubsAndMatchesArr['clubs']; // Сырой массив с клубами. Его элементы имеют вид 'ПСВ Эйндховен (Нидерланды)'

// Выясняем название клуба и страну:
$processedClubsArr = [];
foreach ($rawClubsArr as $curClub) {
    $arr = explode('(', $curClub);
    $processedClubsArr[] = [
        'title' => trim($arr[0]),
        'country' => trim(mb_substr($arr[1], 0, mb_strlen($arr[1]) - 1)),
    ];
}
// echo json_encode($processedClubsArr);

// Ищем клубы в базе:
if (true) {

    require_once '../database/config/config.php';
    require_once '../database/config/connect.php';
    $conn = connect();

    $clubsList = [];    
    foreach ($processedClubsArr as $curClub) {
        $countryName = ($curClub['country'] === 'Беларусь') ? 'Белоруссия' : $curClub['country'];
        $sql =
            "SELECT * 
            FROM `eurocups_clubs`
            WHERE `basicFullName` = '{$curClub['title']}'
            OR `shortName` = '{$curClub['title']}'
            OR `altNames` LIKE '%{$curClub['title']}%'
            AND `country` = '{$countryName}'
        ";
        if ($result = mysqli_query($conn, $sql)) {
            if ($item = mysqli_fetch_assoc($result)) {
                $clubsList['existingClubs'][] = [                    
                    // "dbId" => $item["id"],
                    // 'basicFullName' => $item['basicFullName'],
                    'web' => $curClub,
                    'db' => $item,
                ];
            } else {
                $clubsList['newClubs'][] = $curClub;
            }
        } else {
            $clubsList['newClubs'][] = $curClub;
        }
    }
    echo json_encode($clubsList);

}

// Определяем места проведения матчей
if (false) {
    $netMatchesArr = [];
    foreach ($clubsAndMatchesArr['matches'] as $ind => $curMatch) {

        // Получаем веб-страницу из Сети
        if (true) {
        // if ($ind == 100) {
            // $originalFileContent = file_get_contents("https://www.championat.com/football/_ucl/tournament/4993/calendar/");
            // echo $originalFileContent;

            $originalFileContent = '';
            $headers = array(
                'cache-control: max-age=0',
                'upgrade-insecure-requests: 1',
                'user-agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36',
                'sec-fetch-user: ?1',
                'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
                'x-compress: null',
                'sec-fetch-site: none',
                'sec-fetch-mode: navigate',
                'accept-encoding: deflate, br',
                'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
            );
            
            $ch = curl_init("https://www.championat.com{$curMatch['matchWebPage']}");
            curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, true);
            $originalFileContent = curl_exec($ch);
            curl_close($ch);        
            // echo $originalFileContent;

            $approximateNeededNodeIndex = mb_strpos($originalFileContent, 'match-info__extra-row');
            $startInd = mb_strpos($originalFileContent, '(', $approximateNeededNodeIndex);
            $endInd = mb_strpos($originalFileContent, ')', $approximateNeededNodeIndex);
            $rawPlaceInfo = mb_substr($originalFileContent, $startInd + 1, $endInd - $startInd - 1);
            $netMatchesArr[] = $rawPlaceInfo;

        }

    }
    echo json_encode($netMatchesArr);
}
