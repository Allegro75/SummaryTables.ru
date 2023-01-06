
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

        // echo "<pre>";
        // var_dump($stagesByTourneysByClubs);
        // echo "</pre>";

}

{ // Из сырого массива с данными ($stagesByTourneysByClubs) формируем массив, в к-ром достижения клуба в каждом турнире будут оценены ($achievesByTourneysByClubs)

    $achievesByTourneysByClubs = [];
    require_once 'classes/Stages.php';
    require_once 'classes/Club.php';
    $newClub = new Club(['pathToRoot' => "../../"]);
    require_once 'classes/PairMatchesHistory.php';
    $newPairHistory = new PairMatchesHistory(['pathToRoot' => "../../"]);
    $stagesOrder = Stages::$stagesOrder;

    foreach ($stagesByTourneysByClubs as $curClubId => $curClubSummaryInfo) {

        $fullClubInfo = [];

        $achievesByTourneysByClubs[$curClubId]["clubInfo"] = $curClubSummaryInfo["clubInfo"];

        foreach ($curClubSummaryInfo["achievesInfo"] as $curTourTitle => $curTitleTourneyInfo) {

            foreach ($curTitleTourneyInfo as $curFinalYear => $curTourneyInfo) {                

                if (in_array("Финал", $curTourneyInfo["stages"])) {           
                    
                    $fullClubInfo = $newClub->getClubByName(["clubName" => $curClubSummaryInfo["clubInfo"]["clubName"]]);           
                    
                    $pairsMatchesHistory = $newPairHistory->getBasicTableHistory(["firstClub" => $fullClubInfo, "secClub" => $rivalFullClubInfo, "tourneyFinalYear" => $curFinalYear, "tourneyStage" => "Финал", "tourneyTitle" => $curTourTitle,]);
                    $finalResult = ($pairsMatchesHistory["duels"]["firstClubDuelsVictories"] == 1) ? "winner" : "Финал";

                    $achievesByTourneysByClubs[$curClubId]["achievesInfo"][] = [
                        "curTourneyTitle" => $curTourTitle,
                        "curTourneyFinalYear" => $curFinalYear,
                        "curTourneyResult" => $finalResult,
                        // "pairsMatchesHistorySql" => $pairsMatchesHistory["sql"],
                        // "fullHistory" => $pairsMatchesHistory,
                    ];

                }
                
                elseif ( 
                    (in_array($curTourTitle, ["Кубок чемпионов", "Лига чемпионов"])) 
                    && ($curFinalYear >= 1992) 
                    && ($curFinalYear <= 1994) 
                    && (in_array("группа", $curTourneyInfo["stages"]))
                    && ( ! (in_array("1/2 финала", $curTourneyInfo["stages"])) ) 
                ) {
                    $achievesByTourneysByClubs[$curClubId]["achievesInfo"][] = [
                        "curTourneyTitle" => $curTourTitle,
                        "curTourneyFinalYear" => $curFinalYear,
                        "curTourneyResult" => "группа",
                    ];
                }

                else {

                    $curTourneyStagesIndexes = []; // Массив с индексами стадий (пройденных данным клубом в данном турнире) в $stagesOrder
                    foreach ($curTourneyInfo["stages"] as $curStage) {
                        $curStageIndex = array_search($curStage, $stagesOrder);
                        $curTourneyStagesIndexes[$curStageIndex] = $curStage;
                    }
                    $minIndex = min(array_keys($curTourneyStagesIndexes));
                    $achievesByTourneysByClubs[$curClubId]["achievesInfo"][] = [
                        "curTourneyTitle" => $curTourTitle,
                        "curTourneyFinalYear" => $curFinalYear,                        
                        "curTourneyResult" => $curTourneyStagesIndexes[$minIndex],
                        // "curTourneyStagesIndexes" => $curTourneyStagesIndexes,
                    ];

                }

            }

        }

    }

    echo "<pre>";
    echo "achievesByTourneysByClubs:";
    var_dump($achievesByTourneysByClubs);
    echo "</pre>";

}

{ // Запись данных в `clubs_achievements`
// if (false) {

    $mainRangeMarksRules = [
        "newCL" => [
            "winner" => 12,
            "Финал" => 9,
            "1/2 финала" => 6,
            "1/4 финала" => 3,
        ],
        "oldCL" => [
            "winner" => 8,
            "Финал" => 6,
            "1/2 финала" => 4,
            "1/4 финала" => 2,
        ],
        "ordinaryCup" => [
            "winner" => 4,
            "Финал" => 3,
            "1/2 финала" => 2,
            "1/4 финала" => 1,
        ],
    ];

    $actualRangeMarksRule = [
        "winner" => 6,
        "Финал" => 5,
        "1/2 финала" => 4,
        "1/4 финала" => 3,
        "1/8 финала" => 2,
    ];

    // { // Пишем в базу:
    if (false) {

        $sqlDebugArr = [];

        foreach ($achievesByTourneysByClubs as $curClubId => $curClubInfo) {

            $curClubName = $curClubInfo["clubInfo"]["clubName"];
            
            foreach ($curClubInfo["achievesInfo"] as $curClubTourneyWayInfo) {

                { // Определение рейтинговых оценок: по основной шкале ($mainRangeMark) и по шкале типа "Десятилетие" ($actualPeriodsMark)

                    $mainRangeMark = $actualPeriodsMark = 0;
        
                    $curTourneyResult = $curClubTourneyWayInfo["curTourneyResult"];
        
                    if (in_array($curClubTourneyWayInfo["curTourneyTitle"], ["Кубок чемпионов", "Лига чемпионов"])) {
        
                        if ($curClubTourneyWayInfo["curTourneyFinalYear"] >= 2000) {
                            if (in_array($curTourneyResult, array_keys($mainRangeMarksRules["newCL"]))) {
                                $mainRangeMark = $mainRangeMarksRules["newCL"][$curTourneyResult];
                            }
                            if (($curClubTourneyWayInfo["curTourneyFinalYear"] >= 2004) && (in_array($curTourneyResult, array_keys($actualRangeMarksRule)))) {
                                $actualPeriodsMark = $actualRangeMarksRule[$curTourneyResult];
                            }
                        }
                        elseif ($curClubTourneyWayInfo["curTourneyFinalYear"] < 2000) {
                            if (in_array($curTourneyResult, array_keys($mainRangeMarksRules["oldCL"]))) {
                                $mainRangeMark = $mainRangeMarksRules["oldCL"][$curTourneyResult];
                            }
                            if (($curFinalYear >= 1992) && ($curFinalYear <= 1994)) {
                                if ($curTourneyResult === "группа") {
                                    $mainRangeMark = 2;
                                    if (($curFinalYear == 1992) && (in_array($curClubName, ["Спарта Прага", "Црвена звезда"]))) {
                                        $mainRangeMark = 4;
                                    }
                                    if (($curFinalYear == 1993) && (in_array($curClubName, ["Глазго Рейнджерс", "Гётеборг"]))) {
                                        $mainRangeMark = 4;
                                    }
                                }
                            }
                        }
        
                    }
        
                    elseif (in_array($curClubTourneyWayInfo["curTourneyTitle"], ["Лига Европы", "Кубок УЕФА", "Кубок ярмарок", "Кубок кубков",])) {
                        if (in_array($curTourneyResult, array_keys($mainRangeMarksRules["ordinaryCup"]))) {
                            $mainRangeMark = $mainRangeMarksRules["ordinaryCup"][$curTourneyResult];
                        }
                        if (($curFinalYear == 1958) && (in_array($curClubName, ["сб. Копенгагена", "сб. Франкфурта", "Интер Милан", "сб. Лейпцига",]))) {
                            $mainRangeMark = 1;
                        }                
                    }
        
                }            

                if (true) {

                    $sql =
                        "INSERT INTO `clubs_achievements` (
                            `clubId`, 
                            `clubName`,
                            `tourneyTitle`,
                            `tourneyFinalYear`,
                            `tourneyResult`,
                            `mainRangeMark`,
                            `actualPeriodsMark`
                        )
                        VALUES (
                            {$curClubId},
                            '{$curClubName}',
                            '{$curClubTourneyWayInfo["curTourneyTitle"]}',
                            {$curClubTourneyWayInfo["curTourneyFinalYear"]},
                            '{$curTourneyResult}',
                            {$mainRangeMark},
                            {$actualPeriodsMark}
                        )
                    ";
                    $sqlDebugArr[] = $sql;
                    mysqli_query($conn, $sql);
                }

            }

        }

    }

    // echo "<pre>";
    // echo "sqlDebugArr:";
    // var_dump($sqlDebugArr);
    // echo "</pre>";

}
