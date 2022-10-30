            
<?

// Получение данных об истории противостояний конкретной пары клубов
class PairMatchesHistory
{

    private $db;

    public function __construct($opts = [])
    {
        $pathToRoot = $opts["pathToRoot"];
        require_once "{$pathToRoot}database/config/config.php";
        require_once "{$pathToRoot}database/config/connect.php";
        $this->db = connect();
    }

    // Получение данных для представления в большинстве таблиц (таблиц типа history.html)
    public function getBasicTableHistory($opts = [])
    {

        $firstClub = $opts["firstClub"];
        $secClub = $opts["secClub"];

        $firstClubId = $firstClub["id"];
        $secClubId = $secClub["id"];

        $firstClubFullName = $firstClub['basicFullName'];
        $firstClubShortName = $firstClub['shortName'];
        $firstClubAltNames = $firstClub['altNames'];

        $history = [];

        // Определяем набор матчей данной пары:
        $sql =
            "SELECT * 
            FROM `matches` 
            WHERE 
                (
                        (
                            firstClubId = '{$firstClubId}' 
                            AND secondClubId = '{$secClubId}'
                        ) 
                    OR 
                        (
                            firstClubId = '{$secClubId}' 
                            AND secondClubId = '{$firstClubId}'
                        )
                )
            AND `score` != ''
        ";
        $matchesArr = array();
        if ($result = mysqli_query($this->db, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $matchesArr[] = $row;
                }
            }
        }
        $noHistory = false;
        if (count($matchesArr) === 0) {
            $noHistory = true;
        }
        // $history = count($matchesArr);

        // Про победы, ничьи, поражения:
        if (true) {

            $firstVictories = 0;
            $draws = 0;
            for ($i = 0; $i < count($matchesArr); $i++) {
                $draws += $matchesArr[$i]['fCDraw'];
                if ($matchesArr[$i]['firstClubId'] == $firstClubId) {
                    $firstVictories += $matchesArr[$i]['fCVictory'];
                } else {
                    $firstVictories += $matchesArr[$i]['fCLesion'];
                }
            }
            $firstLesions = count($matchesArr) - $firstVictories - $draws;
            $history = [
                "firstVictories" => $firstVictories,
                "draws" => $draws,
                "firstLesions" => $firstLesions,
            ];

            // Про разницу мячей:
            $firstGoals = 0;
            $secondGoals = 0;
            for ($i = 0; $i < count($matchesArr); $i++) {
                if ($matchesArr[$i]['firstClubId'] == $firstClubId) {
                    $firstGoals += $matchesArr[$i]['firstClubGoals'];
                    $secondGoals += $matchesArr[$i]['secondClubGoals'];
                } else {
                    $firstGoals += $matchesArr[$i]['secondClubGoals'];
                    $secondGoals += $matchesArr[$i]['firstClubGoals'];
                }
            }
            $history["firstGoals"] = $firstGoals;
            $history["secondGoals"] = $secondGoals;
        }

        // Про ДУЭЛИ:
        if (true) {

            // Массив дуэлей ($duelsArr):
            $duelsArr = [];
            foreach ($matchesArr as $curMatch) {
                $duelFullIndicatorArr = [
                    "tourFinYear" => $curMatch["tourneyFinalYear"],
                    "tourneyStage" => $curMatch["tourneyStage"],
                ];
                $duelShortIndicator = serialize($duelFullIndicatorArr);
                // if ( ! (isset($duelsArr[$duelShortIndicator])) ) {
                $duelsArr[$duelShortIndicator][] = $curMatch;
                // }
            }
            // echo '<pre>';
            // var_dump($duelsArr);
            // echo '</pre>';
            // echo '<pre>';
            // var_dump(array_keys($duelsArr));
            // echo '</pre>';

            // Сортируем массив дуэлей по датам и стадиям:
            uksort($duelsArr, function ($a, $b) {
                $a = unserialize($a);
                $b = unserialize($b);
                if ($a["tourFinYear"] < $b["tourFinYear"]) {
                    return -1;
                } elseif ($a["tourFinYear"] > $b["tourFinYear"]) {
                    return 1;
                } elseif ($a["tourFinYear"] == $b["tourFinYear"]) {
                    // Стандартный порядок стадий:
                    $stagesOrder = [
                        "Финал",
                        "1/2 финала",
                        "1/4 финала",
                        "группа2",
                        "1/8 финала",
                        "1/16 финала",
                        "группа",
                        "1/32 финала",
                        "1/64 финала",
                        "Раунд плей-офф",
                        "Третий квалификационный раунд",
                        "Третий отборочный раунд",
                        "3-й квалификационный раунд",
                        "2-й квалификационный раунд",
                        "Второй квалификационный раунд",
                        "Второй отборочный раунд",
                        "1-й квалификационный раунд",
                        "Первый квалификационный раунд",
                        "Первый отборочный раунд",
                        "Первый раунд",
                        "Квалификационный раунд",
                        "Отборочный раунд",
                        'Предварительный раунд - Финал',
                        "Предварительный раунд, финал",
                        'Предварительный раунд - 1/2 финала',
                        "Предварительный раунд, 1/2 финала",
                        "Предварительный раунд",
                    ];
                    if (array_search($a["tourneyStage"], $stagesOrder) < array_search($b["tourneyStage"], $stagesOrder)) {
                        return 1;
                    } else {
                        return -1;
                    }
                }
            });
            // echo '<pre>';
            // var_dump(array_keys($duelsArr));
            // echo '</pre>';

            // Число дуэлей:
            $duelsNumber = count($duelsArr);

            // Исходы дуэлей:
            if (true) {

                // Нужны костыли для:
                // - ДинамоК отбор против датчан, кажется, в районе 1994-го года в ЛЧ

                $duelsResults = [];
                foreach ($duelsArr as $duelInd => $curDuel) {

                    $curDuelInd = unserialize($duelInd);
                    // echo '<pre>';
                    // var_dump($curDuelInd);
                    // echo '</pre>';  

                    // Определение победителя дуэли для финалов:
                    if ($curDuelInd["tourneyStage"] === "Финал") {

                        if (count($curDuel) === 1) { // Если финальный матч один

                            if ($curDuel[0]["penaltiesWinner"] != "") { // Если была серия пенальти
                                if (($curDuel[0]["penaltiesWinner"] === $firstClubFullName) || ($curDuel[0]["penaltiesWinner"] === $firstClubShortName) || ($curDuel[0]["penaltiesWinner"] === $firstClubAltNames)) {
                                    $duelsResults[$duelInd]["result"] = "firstClubVictory";
                                } else {
                                    $duelsResults[$duelInd]["result"] = "secondClubVictory";
                                }
                            } elseif ($curDuel[0]["fCVictory"] === "1") {
                                if ($curDuel[0]["firstClubName"] === $firstClubFullName) {
                                    $duelsResults[$duelInd]["result"] = "firstClubVictory";
                                } else {
                                    $duelsResults[$duelInd]["result"] = "secondClubVictory";
                                }
                            } elseif ($curDuel[0]["fCVictory"] === "0") {
                                if ($curDuel[0]["firstClubName"] === $firstClubFullName) {
                                    $duelsResults[$duelInd]["result"] = "secondClubVictory";
                                } else {
                                    $duelsResults[$duelInd]["result"] = "firstClubVictory";
                                }
                            }
                        } elseif (count($curDuel) === 2) { // Если финальных матчей в этом турнире два

                            if (($curDuel[0]["penaltiesWinner"] != "") || ($curDuel[1]["penaltiesWinner"] != "")) { // Если была серия пенальти

                                $penaltiesWinner = ($curDuel[0]["penaltiesWinner"] != "") ? $curDuel[0]["penaltiesWinner"] : $curDuel[1]["penaltiesWinner"];
                                if ($penaltiesWinner === $firstClubFullName) {
                                    $duelsResults[$duelInd]["result"] = "firstClubVictory";
                                } else {
                                    $duelsResults[$duelInd]["result"] = "secondClubVictory";
                                }
                            } else { // Если пенальти не было:

                                // Если был доп. матч:
                                if (($curDuel[0]["comments"] === "доп. матч") || ($curDuel[1]["comments"] === "доп. матч")) {

                                    // Номер доп. матча:
                                    $addMatchNum = ($curDuel[0]["comments"] === "доп. матч") ? 0 : 1;

                                    $fClubName = $curDuel[$addMatchNum]["firstClubName"];

                                    if ($curDuel[$addMatchNum]["fCVictory"] === "1") {

                                        if ($fClubName === $firstClubFullName) {
                                            $duelsResults[$duelInd]["result"] = "firstClubVictory";
                                        } else {
                                            $duelsResults[$duelInd]["result"] = "secondClubVictory";
                                        }
                                    } elseif ($curDuel[$addMatchNum]["fCLesion"] === "1") {

                                        if ($fClubName === $firstClubFullName) {
                                            $duelsResults[$duelInd]["result"] = "secondClubVictory";
                                        } else {
                                            $duelsResults[$duelInd]["result"] = "firstClubVictory";
                                        }
                                    }
                                }

                                // Если доп. матча не было:
                                else {

                                    // Считаем голы:
                                    // Всего (за два матча) голов первой (по базе) команды в первом матче:
                                    $firstMatchFirstTeamTotalGoalsNumber = $curDuel[0]["firstClubGoals"] + $curDuel[1]["secondClubGoals"];
                                    // Всего (за два матча) голов ВТОРОЙ команды в первом матче:
                                    $firstMatchSECONDTeamTotalGoalsNumber = $curDuel[0]["secondClubGoals"] + $curDuel[1]["firstClubGoals"];

                                    if ($firstMatchFirstTeamTotalGoalsNumber !== $firstMatchSECONDTeamTotalGoalsNumber) { // Если можно выяснить победителя по числу голов в двух матчах

                                        $fClubName = $curDuel[0]["firstClubName"];

                                        if ($firstMatchFirstTeamTotalGoalsNumber > $firstMatchSECONDTeamTotalGoalsNumber) {

                                            if ($fClubName === $firstClubFullName) {
                                                $duelsResults[$duelInd]["result"] = "firstClubVictory";
                                            } else {
                                                $duelsResults[$duelInd]["result"] = "secondClubVictory";
                                            }
                                        } elseif ($firstMatchFirstTeamTotalGoalsNumber < $firstMatchSECONDTeamTotalGoalsNumber) {

                                            if ($fClubName === $firstClubFullName) {
                                                $duelsResults[$duelInd]["result"] = "secondClubVictory";
                                            } else {
                                                $duelsResults[$duelInd]["result"] = "firstClubVictory";
                                            }
                                        }
                                    } elseif ($firstMatchFirstTeamTotalGoalsNumber === $firstMatchSECONDTeamTotalGoalsNumber) { // Если число голов равное

                                        // Считаем голы на чужом поле:
                                        // Определяем номер матча на СВОЁМ поле для первой команды в первом матче:
                                        if ($curDuel[0]["home"] !== "neutral") {
                                            if ($curDuel[0]["home"] === $curDuel[0]["firstClubName"]) {
                                                $homeMatchNum = 0;
                                            }
                                        } else { // Если первый матч на поле со статусом "neutral"
                                            if ($curDuel[1]["home"] === $curDuel[0]["firstClubName"]) {
                                                $homeMatchNum = 1;
                                            }
                                        }

                                        $guestMatchNum = ($homeMatchNum === 0) ? 1 : 0;

                                        // Число гостевых голов первой команды первого матча:
                                        $firstTeamGuestGoals = $curDuel[$guestMatchNum]["secondClubGoals"];

                                        // Число гостевых голов второй команды первого матча:
                                        $secondTeamGuestGoals = $curDuel[$homeMatchNum]["secondClubGoals"];

                                        if ($firstTeamGuestGoals > $secondTeamGuestGoals) {

                                            if ($curDuel[0]["firstClubName"] === $firstClubFullName) {
                                                $duelsResults[$duelInd]["result"] = "firstClubVictory";
                                            } else {
                                                $duelsResults[$duelInd]["result"] = "secondClubVictory";
                                            }
                                        } elseif ($firstTeamGuestGoals < $secondTeamGuestGoals) {

                                            if ($curDuel[0]["firstClubName"] === $firstClubFullName) {
                                                $duelsResults[$duelInd]["result"] = "secondClubVictory";
                                            } else {
                                                $duelsResults[$duelInd]["result"] = "firstClubVictory";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    // Определение победителя дуэли для более ранних (чем финал) стадий:
                    else {

                        // Стандартный порядок стадий:
                        $stagesOrder = [
                            "Финал",
                            "1/2 финала",
                            "1/4 финала",
                            "группа2",
                            "1/8 финала",
                            "1/16 финала",
                            "группа",
                            "1/32 финала",
                            "1/64 финала",
                            "Раунд плей-офф",
                            "Первый раунд",
                            "Третий квалификационный раунд",
                            "Третий отборочный раунд",
                            "3-й квалификационный раунд",
                            "2-й квалификационный раунд",
                            "Второй квалификационный раунд",
                            "Второй отборочный раунд",
                            "1-й квалификационный раунд",
                            "Первый квалификационный раунд",
                            "Первый отборочный раунд",
                            "Квалификационный раунд",
                            "Отборочный раунд",
                            'Предварительный раунд - Финал',
                            "Предварительный раунд, финал",
                            'Предварительный раунд - 1/2 финала',
                            "Предварительный раунд, 1/2 финала",
                            "Предварительный раунд",
                        ];
                        // Порядок стадий в ЛЧ с 92 по 94 отличается:  
                        if (($curDuelInd["tourFinYear"] >= 1992) && ($curDuelInd["tourFinYear"] <= 1994)) {
                            $stagesOrder[4] = "группа";
                            $stagesOrder[5] = "1/8 финала";
                            $stagesOrder[6] = "1/16 финала";
                        }

                        // Массив более высоких (по отношению к ракссматриваемой дуэли) стадий турнира $higherStages:
                        $stageInd = array_search($curDuelInd["tourneyStage"], $stagesOrder);
                        $higherStages = array_slice($stagesOrder, 0, $stageInd);
                        // echo '<pre>';
                        // var_dump($higherStages);
                        // echo '</pre>';

                        // Выясняем, есть ли упоминания о клубах на более высоких стадиях турнира:
                        $highStagesWQuotes = array_map(function ($a) {
                            return "'{$a}'";
                        }, $higherStages);
                        $higherStagesStr = implode(",", $highStagesWQuotes);
                        $tourName = $curDuel[0]["tourneyTitle"];
                        $sql =
                            "SELECT COUNT(*) AS `count`
                                    FROM `matches` 
                                    WHERE `tourneyStage` IN ({$higherStagesStr})
                                    AND `tourneyFinalYear` = {$curDuelInd["tourFinYear"]}
                                    AND `tourneyTitle` = '{$tourName}'
                                    AND
                                        (
                                            `firstClubId` = {$firstClubId}
                                            OR `secondClubId` = {$firstClubId}
                                        )
                                ";
                        // echo '<pre>';
                        // var_dump($sql);
                        // echo '</pre>';  

                        if ($res = mysqli_query($this->db, $sql)) {
                            if ($row = mysqli_fetch_assoc($res)) {
                                $hasFirstClubAdvance = ($row["count"] > 0) ? true : false;
                            }
                        }

                        $sql =
                            "SELECT COUNT(*) AS `count`
                                    FROM `matches` 
                                    WHERE `tourneyStage` IN ({$higherStagesStr})
                                    AND `tourneyFinalYear` = {$curDuelInd["tourFinYear"]}
                                    AND `tourneyTitle` = '{$tourName}'
                                    AND
                                        (
                                            `firstClubId` = {$secClubId}
                                            OR `secondClubId` = {$secClubId}
                                        )
                                ";
                        if ($res = mysqli_query($this->db, $sql)) {
                            if ($row = mysqli_fetch_assoc($res)) {
                                $hasSecondClubAdvance = ($row["count"] > 0) ? true : false;
                            }
                        }

                        if ($hasFirstClubAdvance && !$hasSecondClubAdvance) {
                            $duelsResults[$duelInd]["result"] = "firstClubVictory";
                        } else if (!$hasFirstClubAdvance && $hasSecondClubAdvance) {
                            $duelsResults[$duelInd]["result"] = "secondClubVictory";
                        } else if ($hasFirstClubAdvance && $hasSecondClubAdvance) {
                            $duelsResults[$duelInd]["result"] = "draw";
                        }
                        // В случае, если обе команды не продвинулись в турнире, надо проверять участие в ЛЕ:
                        else {
                            $sql =
                                "SELECT COUNT(*) AS `count`
                                        FROM `matches` 
                                        WHERE `tourneyStage` IN ({$higherStagesStr})
                                        AND `tourneyFinalYear` = {$curDuelInd["tourFinYear"]}
                                        AND `tourneyTitle` IN ('Кубок УЕФА', 'Лига Европы')
                                        AND
                                            (
                                                `firstClubId` = {$firstClubId}
                                                OR `secondClubId` = {$firstClubId}
                                            )
                                    ";
                            if ($res = mysqli_query($this->db, $sql)) {
                                if ($row = mysqli_fetch_assoc($res)) {
                                    $hasFCEuroLeagueAdvance = ($row["count"] > 0) ? true : false;
                                }
                            }
                            if ($hasFCEuroLeagueAdvance) {
                                $duelsResults[$duelInd]["result"] = "firstClubVictory";
                            } else {
                                $sql =
                                    "SELECT COUNT(*) AS `count`
                                            FROM `matches` 
                                            WHERE `tourneyStage` IN ({$higherStagesStr})
                                            AND `tourneyFinalYear` = {$curDuelInd["tourFinYear"]}
                                            AND `tourneyTitle` IN ('Кубок УЕФА', 'Лига Европы')
                                            AND
                                                (
                                                    `firstClubId` = {$secClubId}
                                                    OR `secondClubId` = {$secClubId}
                                                )
                                        ";
                                if ($res = mysqli_query($this->db, $sql)) {
                                    if ($row = mysqli_fetch_assoc($res)) {
                                        // $duelsResults[$duelInd]["result"] = ($row["count"] > 0) ? "secondClubVictory" : "draw";
                                        if ($row["count"] > 0) {
                                            $duelsResults[$duelInd]["result"] = "secondClubVictory";
                                        } else {
                                            if (($curDuelInd["tourFinYear"] == 2023) && (($curDuelInd["tourneyStage"] == "1/2 финала") || ($curDuelInd["tourneyStage"] == "1/4 финала") || ($curDuelInd["tourneyStage"] == "1/8 финала") || ($curDuelInd["tourneyStage"] == "1/16 финала") || ($curDuelInd["tourneyStage"] == "группа"))) { // для незавершенных дуэлей 2022/2023
                                                $duelsResults[$duelInd]["result"] = "notFinished";
                                            } else {
                                                $duelsResults[$duelInd]["result"] = "draw";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    // Число побед и поражений в дуэлях во всей истории встреч:
                    $firstClubDuelsVictories = $firstClubDuelsLesions = $duelDraws = $notFinishedDuels = 0;
                    foreach ($duelsResults as $duelData) {
                        if ($duelData["result"] === "firstClubVictory") {
                            $firstClubDuelsVictories++;
                        } elseif ($duelData["result"] === "secondClubVictory") {
                            $firstClubDuelsLesions++;
                        } elseif ($duelData["result"] === "draw") {
                            $duelDraws++;
                        } elseif ($duelData["result"] === "notFinished") {
                            $notFinishedDuels++;
                        }
                    }
                    $history["duels"]["firstClubDuelsVictories"] = $firstClubDuelsVictories;
                    $history["duels"]["firstClubDuelsLesions"] = $firstClubDuelsLesions;
                    $history["duels"]["duelDraws"] = $duelDraws;
                    $history["duels"]["notFinishedDuels"] = $notFinishedDuels;

                }

                // echo '<pre>';
                // var_dump($duelsResults);
                // echo '</pre>';

            }

        }

        mysqli_close($this->db);

        return $history;
    }
}
