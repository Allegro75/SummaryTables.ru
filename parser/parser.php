
<?

// Сырой массив с клубами.
// Его элементы имеют вид "Ла Фиорита (Сан-Марино)"
$rawClubsArr = json_decode(file_get_contents('php://input'), true);
// echo json_encode($rawClubsArr);

// Выясняем название клуба и страну:
$processedClubsArr = [];
foreach ($rawClubsArr as $curClub) {

    $openBracketInd = mb_strpos($curClub, '(');
    $processedClubsArr[] = $openBracketInd;

}

echo json_encode($processedClubsArr);
