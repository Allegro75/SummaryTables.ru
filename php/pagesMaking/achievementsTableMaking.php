
<?

// Для формирования в БД таблицы `clubs_achievements`
require_once '../../database/config/config.php';
require_once '../../database/config/connect.php';
$conn = connect();

{ // Собираем массив всех клубов со всеми турнирами, в к-рых участвовал данный клуб, и со всеми стадиями в к-рых он играл в этих турнирах
// if (false) {

        $stagesByTourneysByClubs = [];

        $sql =
            "SELECT firstClubId, firstClubName, secondClubId, secondClubName, tourneyTitle, tourneyFinalYear, tourneyStage
            FROM `matches`
            WHERE `tourneyFinalYear` = {$curYear}
        ";
        if ($result = mysqli_query($conn, $sql)) {
            while ($item = mysqli_fetch_assoc($result)) {

                $curMatchFirstClubId = $item["firstClubId"];
                $curMatchFirstClubName = $item["firstClubName"];
                $curMatchSecondClubId = $item["secondClubId"];
                $curMatchSecondClubName = $item["secondClubName"];
                $curMatchTourneyTitle = $item["tourneyTitle"];
                $curMatchTourneyFinalYear = $item["tourneyFinalYear"];
                $curMatchTourneyStage = $item["tourneyStage"];

                if ( ! (isset($stagesByTourneysByClubs[$curMatchFirstClubId])) ) {
                    $stagesByTourneysByClubs[$curMatchFirstClubId]["clubInfo"] = [
                        "clubId" => $curMatchFirstClubId,
                        "clubName" => $curMatchFirstClubName,
                    ];
                }

                if ( ! (isset($stagesByTourneysByClubs[$curMatchSecondClubId])) ) {
                    $stagesByTourneysByClubs[$curMatchSecondClubId]["clubInfo"] = [
                        "clubId" => $curMatchSecondClubId,
                        "clubName" => $curMatchSecondClubName,
                    ];
                }

                if ( ! (isset($stagesByTourneysByClubs[$curMatchFirstClubId]["achievesInfo"][$curMatchTourneyTitle][$curMatchTourneyFinalYear]["stages"])) ) {
                    $stagesByTourneysByClubs[$curMatchFirstClubId]["achievesInfo"][$curMatchTourneyTitle][$curMatchTourneyFinalYear]["stages"] = [$curMatchTourneyStage];
                }
                elseif ((isset($stagesByTourneysByClubs[$curMatchFirstClubId]["achievesInfo"][$curMatchTourneyTitle][$curMatchTourneyFinalYear]["stages"])) && ( ! (in_array($curMatchTourneyStage, $stagesByTourneysByClubs[$curMatchFirstClubId]["achievesInfo"][$curMatchTourneyTitle][$curMatchTourneyFinalYear]["stages"])) )) {
                    $stagesByTourneysByClubs[$curMatchFirstClubId]["achievesInfo"][$curMatchTourneyTitle][$curMatchTourneyFinalYear]["stages"][] = $curMatchTourneyStage;
                }

                if ( ! (isset($stagesByTourneysByClubs[$curMatchSecondClubId]["achievesInfo"][$curMatchTourneyTitle][$curMatchTourneyFinalYear]["stages"])) ) {
                    $stagesByTourneysByClubs[$curMatchSecondClubId]["achievesInfo"][$curMatchTourneyTitle][$curMatchTourneyFinalYear]["stages"] = [$curMatchTourneyStage];
                }
                elseif ((isset($stagesByTourneysByClubs[$curMatchFirstClubId]["achievesInfo"][$curMatchTourneyTitle][$curMatchTourneyFinalYear]["stages"])) && ( ! (in_array($curMatchTourneyStage, $stagesByTourneysByClubs[$curMatchSecondClubId]["achievesInfo"][$curMatchTourneyTitle][$curMatchTourneyFinalYear]["stages"])) )) {
                    $stagesByTourneysByClubs[$curMatchSecondClubId]["achievesInfo"][$curMatchTourneyTitle][$curMatchTourneyFinalYear]["stages"][] = $curMatchTourneyStage;
                }                

            }
        } 

        echo "<pre>";
        var_dump($stagesByTourneysByClubs);
        echo "</pre>";

}



// if (true) {
if (false) {

    $netMatchesArr = []; // Готовим массив $netMatchesArr с матчами под запись в базу:

    // Пишем в базу:
    if (false) {
    // if (true) {
        $sqlDebugArr = [];
        foreach ($netMatchesArr as $ind => $curMatch) {

            if (true) {
            // if ($ind == 3) {
            // if (($ind >= 0) && ($ind <= 13)) {
            // if (($ind >= 14) && ($ind <= 33)) {
            // if (($ind >= 41) && ($ind <= 76)) {
            // if (($ind >= 77) && ($ind <= 88)) {
            // if (($ind >= 34)) {
                $sql =
                    "INSERT INTO `matches` (
                        `firstClubName`, 
                        `firstClubId`, 
                        `secondClubName`, 
                        `secondClubId`,
                        `score`,
                        `home`,
                        `tourneyTitle`,
                        `tourneyFinalYear`,
                        `tourneyStartYear`,
                        `tourneyStage`,
                        `year`,
                        `date`,
                        `matchDate`,
                        `fieldCity`,
                        `firstClubGoals`,
                        `secondClubGoals`,
                        `fCVictory`,
                        `fCDraw`,
                        `fCLesion`,
                        `hadEfficientAddTime`,
                        `hadPenalties`,
                        `penaltiesWinner`
                    )
                    VALUES (
                        '{$curMatch['firstClubName']}', 
                        '{$curMatch['firstClubId']}', 
                        '{$curMatch['secondClubName']}', 
                        '{$curMatch['secondClubId']}',
                        '{$curMatch['score']}',
                        '{$curMatch['home']}',
                        '{$curMatch['tourneyTitle']}',
                        '{$curMatch['tourneyFinalYear']}',
                        '{$curMatch['tourneyStartYear']}',
                        '{$curMatch['tourneyStage']}',
                        '{$curMatch['year']}',
                        '{$curMatch['date']}',
                        '{$curMatch['matchDate']}',
                        '{$curMatch['fieldCity']}',
                        '{$curMatch['firstClubGoals']}',
                        '{$curMatch['secondClubGoals']}',
                        '{$curMatch['fCVictory']}',
                        '{$curMatch['fCDraw']}',
                        '{$curMatch['fCLesion']}',
                        '{$curMatch['hadEfficientAddTime']}',
                        '{$curMatch['hadPenalties']}',
                        '{$curMatch['penaltiesWinner']}'
                    )
                ";
                $sqlDebugArr[$ind] = $sql;
                mysqli_query($conn, $sql);
            }

        }
        // echo json_encode($sqlDebugArr);
    }

}
