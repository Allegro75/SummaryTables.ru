
<?

// Сырой массив с клубами.
// Его элементы имеют вид 'ПСВ Эйндховен (Нидерланды)'
$rawClubsArr = json_decode(file_get_contents('php://input'), true);
// echo json_encode($rawClubsArr);

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
        $sql =
            "SELECT * 
            FROM `eurocups_clubs`
            WHERE `basicFullName` = {$curClub['title']}
            OR `shortName` = {$curClub['title']}
            OR `altNames` = {$curClub['title']}
            AND `country` = {$curClub['country']}
        ";
        if ($result = mysqli_query($conn, $sql)) {
            while ($item = mysqli_fetch_assoc($result)) {
                $clubsList['existingClubs'][] = [
                    "dbId" => $item["id"],
                    'basicFullName' => $item['basicFullName'],
                ];
            }
        }
        else {
            // $clubsList['newClubs'][] = $curClub;
            $clubsList['newClubs'][] = $sql;
        }
    }
    echo json_encode($clubsList);

}