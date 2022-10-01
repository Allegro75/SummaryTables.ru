
<?

// Сырой массив с клубами.
// Его элементы имеют вид 'ПСВ Эйндховен (Нидерланды)'
$rawClubsArr = json_decode(file_get_contents('php://input'), true);
// echo json_encode($rawClubsArr);

// Выясняем название клуба и страну:
$processedClubsArr = [];
foreach ($rawClubsArr as $curClub) {

    // $openBracketInd = mb_strpos($curClub, '(');
    // $processedClubsArr[] = $openBracketInd;

    $arr = explode('(', $curClub);
    $processedClubsArr[] = [
        'title' => trim($arr[0]),
        'country' => trim(mb_substr($arr[1], 0, mb_strlen($arr[1]) - 1)),
    ];

}

echo json_encode($processedClubsArr);
