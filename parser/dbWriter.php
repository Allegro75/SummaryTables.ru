
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

// Ищем клубы в базе.
// Формируем массив $clubsList, состоящий из двух элементов - existingClubs и newClubs.
// Добиваемся того, чтобы все клубы с веб-страницы были опознаны, т.е. все клубы были записаны в existingClubs
if (true) {

    require_once '../database/config/config.php';
    require_once '../database/config/connect.php';
    $conn = connect();

    $clubsList = [];    
    foreach ($processedClubsArr as $curClub) {
        switch ($curClub['country']) {
            // $countryName = ($curClub['country'] === 'Беларусь') ? 'Белоруссия' : $curClub['country'];
            // $countryName = ($curClub['country'] === 'Монако') ? 'Франция' : $curClub['country'];
            case 'Беларусь':
                $countryName = 'Белоруссия';
                break;
            case 'Монако':
                $countryName = 'Франция';
                break;
            case "Фарерские острова":
                $countryName = 'Фареры';
                break;
            default:
                $countryName = $curClub['country'];
                break;
        }
        $sql =
            "SELECT * 
            FROM `eurocups_clubs`
            WHERE 
                (
                    `basicFullName` = '{$curClub['title']}'
                    OR `shortName` = '{$curClub['title']}'
                    OR `altNames` LIKE '%{$curClub['title']}%'
                )
            AND `country` = '{$countryName}'
        ";
        if ($result = mysqli_query($conn, $sql)) {
            $clubIsFound = false;
            while ($item = mysqli_fetch_assoc($result)) {
                if ($curClub['title'] === $item['basicFullName']) {
                    $clubIsFound = true;
                } elseif ($curClub['title'] === $item['shortName']) {
                    $clubIsFound = true;
                } else {
                    $altNames = explode(',', $item['altNames']);
                    if (in_array($curClub['title'], $altNames)) {
                        $clubIsFound = true;
                    }
                }
                if ($clubIsFound === true) {
                    $clubsList['existingClubs'][] = [                    
                        'web' => $curClub,
                        'db' => $item,
                        // 'sql' => $sql,
                    ];
                    break;
                }
            } 
            if ($clubIsFound === false) {
                $clubsList['newClubs'][] = $curClub;
            }
        } 
        else {
            $clubsList['newClubs'][] = $curClub;
        }
    }
    // echo json_encode($clubsList);

}

// Определяем места проведения матчей
// Оказалось, как минимум слишком долго (плюс с налёту и вовсе не удалось добиться корректного результата на всём массиве сразу)
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

// Записываем матчи в базу:
if (true) {
// if (false) {

    $netMatchesArr = [];
    foreach ($clubsAndMatchesArr['matches'] as $ind => $curMatch) {

        if (true) {
        // if ($ind == 0) {

            // Ищем имена и индексы клубов, игравших в текущем матче
            $firstClubName = $secondClubName = '';
            foreach ($clubsList['existingClubs'] as $curClub) {

                $webClubTitle = "{$curClub['web']['title']} ({$curClub['web']['country']})";
                if (($firstClubName === '') && ($curMatch['firstClub'] === $webClubTitle)) {
                    $firstClubName = $curClub['db']['basicFullName'];
                    $firstClubId = $curClub['db']['id'];
                }
                if (($secondClubName === '') && ($curMatch['secClub'] === $webClubTitle)) {
                    $secondClubName = $curClub['db']['basicFullName'];
                    $secondClubId = $curClub['db']['id'];
                }
                if (($firstClubName !== '') && ($secondClubName !== '')) {
                    break;
                }

            }

            // Счёт матча:
            $score = $curMatch['score'];

            $netMatchesArr[] = [
                'firstClubName' => $firstClubName, 
                'firstClubId' => $firstClubId, 
                'secondClubName' => $secondClubName, 
                'secondClubId' => $secondClubId,
                'score' => $score,
            ];

        }

    }
    echo json_encode($netMatchesArr);

}
