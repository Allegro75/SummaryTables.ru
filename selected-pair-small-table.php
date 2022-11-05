
<?

    require_once 'database/config/config.php';
    require_once 'database/config/connect.php';

    $conn = connect();

    $firstClubId = $_GET['club_1'];
    $secondClubId = $_GET['club_2'];
    // $haveIncorrectClubIds = false;
    // if (($firstClubId <= 0) || ($secondClubId <= 0) || ($firstClubId == $secondClubId)) {
    //     $haveIncorrectClubIds = true;
    // }
    
    // Определяем данные клубов:
    $sql =
        "SELECT * 
        FROM `eurocups_clubs` 
        WHERE id = {$firstClubId}
    ";
    $result = mysqli_query($conn, $sql);
    if ($item = mysqli_fetch_assoc($result)) {
        $firstClubFullName = $item['basicFullName'];
        $firstClubShortName = $item['shortName'];
        $firstClubAltNames = $item['altNames'];
        $firstClubCode = $item['code'];
        $firstClubLogoClass = $item['CSSClass'];
        $firstClubCountryEngCode = $item['countryEngCode'];
    }
    // var_dump($firstClubFullName);   
    
    $sql =
        "SELECT * 
        FROM `eurocups_clubs` 
        WHERE id = {$secondClubId}
    ";
    $result = mysqli_query($conn, $sql);
    if ($item = mysqli_fetch_assoc($result)) {
        $secondClubFullName = $item['basicFullName'];
        $secondClubShortName = $item['shortName'];
        $secondClubAltNames = explode(",", $item['altNames']);
        $secondClubCode = $item['code'];
        $secondClubLogoClass = $item['CSSClass'];
        $secondClubCountryEngCode = $item['countryEngCode'];
    }                

    // Массив имён файлов с логотипами (нужен чтобы правильно добавлять к коду клуба ".png", ".svg" и т.п.)
    // $logoFiles = scandir("../images");
    $logoFiles = scandir("images");
    // echo '<pre>';
    // echo 'logoFiles:';
    // var_dump($logoFiles);

    // Имя файла с картинкой логотипа:
    $specialImages = [
        "Akt" => "Akt_light.png",
        "AuW" => "AuW_light.png",
        "DuP" => "DuP_light.png",
        "Mar" => "Mar_light.png",
        "Mlm" => "Mlm_light.png",
        "Nan" => "Nan_light.png",
        "New" => "New_light.png",
        "Not" => "Not_light.png",
        "Prt" => "Prt_light.png",
        "SpL" => "SpL_light.png",
        "StL" => "StL_light.png",
        "Zen" => "Zen_light.png",
    ];
    $firstLogoImageFile = $secondLogoImageFile = $firstFlagClass = $secondFlagClass = "";
    if ($firstClubCode != "") {
        if (in_array($firstClubCode, array_keys($specialImages))) {
            $firstLogoImageFile = $specialImages[$firstClubCode];
        } else {        
            if (in_array("{$firstClubCode}.png", $logoFiles)) {
                $firstLogoImageFile = "{$firstClubCode}.png";
            } elseif (in_array("{$firstClubCode}.svg", $logoFiles)) {
                $firstLogoImageFile = "{$firstClubCode}.svg";
            } elseif (in_array("{$firstClubCode}.jpg", $logoFiles)) {
                $firstLogoImageFile = "{$firstClubCode}.jpg";
            }
        }
    } else {
        $firstLogoImageFile = "flags/{$firstClubCountryEngCode}.png";
        $firstFlagClass = " flag-image";
    }
    if ($secondClubCode != "") {
        if (in_array($secondClubCode, array_keys($specialImages))) {
            $secondLogoImageFile = $specialImages[$secondClubCode];
        } else {    
            if (in_array("{$secondClubCode}.png", $logoFiles)) {
                $secondLogoImageFile = "{$secondClubCode}.png";
            } elseif (in_array("{$secondClubCode}.svg", $logoFiles)) {
                $secondLogoImageFile = "{$secondClubCode}.svg";
            } elseif (in_array("{$secondClubCode}.jpg", $logoFiles)) {
                $secondLogoImageFile = "{$secondClubCode}.jpg";
            }
        }
    } else {
        $secondLogoImageFile = "flags/{$secondClubCountryEngCode}.png";
        $secondFlagClass = " flag-image";
    }

    // var_dump($firstClubFullName,$firstClubShortName,$firstClubCode,$secondClubFullName,$secondClubShortName,$secondClubCode);
    $firstClubLogoClassToInsert = ($firstClubLogoClass != "") ? " {$firstClubLogoClass}" : "";
    $secondClubLogoClassToInsert = ($secondClubLogoClass != "") ? " {$secondClubLogoClass}" : "";

    // Определяем статистику:
    $sql =
        "SELECT * 
        FROM `matches` 
        WHERE 
            (
                    (
                        firstClubId = '{$firstClubId}' 
                        AND secondClubId = '{$secondClubId}'
                    ) 
                OR 
                    (
                        firstClubId = '{$secondClubId}' 
                        AND secondClubId = '{$firstClubId}'
                    )
            )
        AND `score` != ''
    ";
    $result = mysqli_query($conn, $sql);
    $matchesArr = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $matchesArr[] = $row;
        }
    }
    $noHistory = false;
    if (count($matchesArr) === 0) {
        $noHistory = true;
    }
    // echo '<pre>';
    // var_dump($matchesArr);
    // echo '</pre>';

    // Про количество матчей:
    $matchesQuantity = count($matchesArr);
    $matchesWord = 'матчей';
    if (($matchesQuantity != 11) && (($matchesQuantity % 10) === 1)) {
        $matchesWord = 'матч';
    } else if (
        ((($matchesQuantity % 10) === 2) || (($matchesQuantity % 10) === 3) || (($matchesQuantity % 10) === 4)) &&
        ($matchesQuantity != 12) &&
        ($matchesQuantity != 13)  &&
        ($matchesQuantity != 14)
    ) {
        $matchesWord = 'матча';
    }
    
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

        $victoriesWord = 'побед';
        if ($firstVictories === 1) {
            $victoriesWord = 'победа';
        } else if (($firstVictories >= 2) && ($firstVictories <= 4)) {
            $victoriesWord = 'победы';
        }

        $drawsWord = 'ничьих';
        if ($draws === 1) {
            $drawsWord = 'ничья';
        } else if (($draws >= 2) && ($draws <= 4)) {
            $drawsWord = 'ничьи';
        }

        $lesionsWord = 'поражений';
        if ($firstLesions === 1) {
            $lesionsWord = 'поражение';
        } else if (($firstLesions >= 2) && ($firstLesions <= 4)) {
            $lesionsWord = 'поражения';
        }

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
        $duelsWord = 'дуэлей';
        if (($duelsNumber != 11) && (($duelsNumber % 10) === 1)) {
            $duelsWord = 'дуэль';
        } else if (
            ((($duelsNumber % 10) === 2) || (($duelsNumber % 10) === 3) || (($duelsNumber % 10) === 4)) &&
            ($duelsNumber != 12) &&
            ($duelsNumber != 13)  &&
            ($duelsNumber != 14)
        ) {
            $duelsWord = 'дуэли';
        }

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

                    if ($res = mysqli_query($conn, $sql)) {
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
                                `firstClubId` = {$secondClubId}
                                OR `secondClubId` = {$secondClubId}
                            )
                    ";
                    if ($res = mysqli_query($conn, $sql)) {
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
                        if ($res = mysqli_query($conn, $sql)) {
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
                                        `firstClubId` = {$secondClubId}
                                        OR `secondClubId` = {$secondClubId}
                                    )
                            ";
                            if ($res = mysqli_query($conn, $sql)) {
                                if ($row = mysqli_fetch_assoc($res)) {
                                    // $duelsResults[$duelInd]["result"] = ($row["count"] > 0) ? "secondClubVictory" : "draw";
                                    if($row["count"] > 0) {
                                        $duelsResults[$duelInd]["result"] = "secondClubVictory";
                                    } else {
                                        // if (($curDuelInd["tourFinYear"] == 2023) && (($curDuelInd["tourneyStage"] == "1/2 финала") || ($curDuelInd["tourneyStage"] == "1/4 финала") || ($curDuelInd["tourneyStage"] == "1/8 финала") || ($curDuelInd["tourneyStage"] == "1/16 финала") || ($curDuelInd["tourneyStage"] == "группа"))) { // для незавершенных дуэлей 2022/2023
                                        if (($curDuelInd["tourFinYear"] == 2023) && (($curDuelInd["tourneyStage"] == "1/2 финала") || ($curDuelInd["tourneyStage"] == "1/4 финала") || ($curDuelInd["tourneyStage"] == "1/8 финала") || ($curDuelInd["tourneyStage"] == "1/16 финала"))) { // для незавершенных дуэлей 2022/2023
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

                $duelsVictoriesWord = 'побед';
                if ($firstClubDuelsVictories === 1) {
                    $duelsVictoriesWord = 'победа';
                } else if (($firstClubDuelsVictories >= 2) && ($firstClubDuelsVictories <= 4)) {
                    $duelsVictoriesWord = 'победы';
                }

                $duelsLesionsWord = 'поражений';
                if ($firstClubDuelsLesions === 1) {
                    $duelsLesionsWord = 'поражение';
                } else if (($firstClubDuelsLesions >= 2) && ($firstClubDuelsLesions <= 4)) {
                    $duelsLesionsWord = 'поражения';
                }
            }

            // echo '<pre>';
            // var_dump($duelsResults);
            // echo '</pre>';

            $duelsDrawsElement = "";
            if ($duelDraws > 0) {

                $drawDuelsWord = 'дуэлей';
                if (($duelDraws != 11) && (($duelDraws % 10) === 1)) {
                    $drawDuelsWord = 'дуэль';
                } else if (($duelDraws != 12) && ($duelDraws != 13)  && ($duelDraws != 14) && ((($duelDraws % 10) === 2)) || (($duelDraws % 10) === 3) || (($duelDraws % 10) === 4)) {
                    $drawDuelsWord = 'дуэли';
                }

                $groupWord = 'группе';
                $defineWord = 'выявила';
                if ($duelDraws > 1) {
                    $groupWord = 'группах';
                    $defineWord = 'выявили';
                }

                $duelsDrawsElement = "<p>{$duelDraws} {$drawDuelsWord} в {$groupWord} не {$defineWord} победителя</p>";
            }

            $notFinishedDuelsElement = "";
            if ($notFinishedDuels == 1) {
                $notFinishedDuelsElement = "<p>1 дуэль не завершена</p>";
            }

        }

    }

    mysqli_close($conn);  
    
    if ($noHistory) {
        $duelsText = "<p>В еврокубках не встречались</p>";
    } else {
        $duelsText = "<p>{$duelsNumber} {$duelsWord}:</p>
        <p><span class='duels-score'>{$firstClubDuelsVictories}</span> {$duelsVictoriesWord} в дуэлях, <span class='duels-score'>{$firstClubDuelsLesions}</span> {$duelsLesionsWord}</p>
        {$duelsDrawsElement}{$notFinishedDuelsElement}";
    }
    
    $metaKeywordsContent = "";
    if ($firstClubShortName === $firstClubFullName) {
        $metaKeywordsContent = "{$metaKeywordsContent}{$firstClubShortName}.";
    } else {
        $metaKeywordsContent = "{$metaKeywordsContent}{$firstClubShortName}. {$firstClubFullName}.";
    }
    if ($secondClubShortName === $secondClubFullName) {
        $metaKeywordsContent = "{$metaKeywordsContent} {$secondClubShortName}.";
    } else {
        $metaKeywordsContent = "{$metaKeywordsContent} {$secondClubShortName}. {$secondClubFullName}.";
    }     

?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="utf-8">
    <meta name="author" content="Edwards, Allegro, Edwards75, Allegro75, Oleg Otkidach">
    <meta name="author" content="Олег Откидач">
    <meta name="description" content="<?=$firstClubFullName?> - <?=$secondClubFullName?>. История личных встреч в рамках еврокубков">
    <meta name="keywords" content="<?=$firstClubFullName?>. <?=$secondClubFullName?>.
	Личные встречи. Личный счет. vs. История игр. История противостояний.
	Футбол. Еврокубки.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/football_ball.svg" type="image/x-icon">
    <title><?=$firstClubShortName?> - <?=$secondClubShortName?></title>
    <link rel="stylesheet" href="../stylesheets/small-tables-duels.css">

</head>

<body>
    <div class="football__background">

            <?                
                echo "
                    <div class='additional-table'>
                        <img src='../images/{$firstLogoImageFile}' alt='{$firstClubShortName}' class='football-logo-table logo-left{$firstClubLogoClassToInsert}{$firstFlagClass}'>
                        <img src='../images/{$secondLogoImageFile}' alt='{$secondClubShortName}' class='football-logo-table logo-right{$secondClubLogoClassToInsert}{$secondFlagClass}'>
                        <h1>{$firstClubFullName} - {$secondClubFullName}</h1>
                        <p>{$matchesQuantity} {$matchesWord}:</p>
                        <p>{$firstVictories} {$victoriesWord}, {$draws} {$drawsWord}, {$firstLesions} {$lesionsWord}</p>
                        <p>Разница мячей: {$firstGoals} - {$secondGoals}</p>
                
                
                        <div class='duels-text'>
                            {$duelsText}
                        </div>
                
                        <table class='add-table'>
                            <tr>
                                <td>№</td>
                                <td>Поле</td>
                                <td>Счёт</td>
                                <td>Год</td>
                                <td>Турнир</td>
                                <td>Стадия</td>
                            </tr>";
                
                    // echo '<pre>';
                    // var_dump($duelsArr);
                    // echo '</pre>';

                    // Сортируем матчи внутри дуэлей по дате:
                    foreach ($duelsArr as &$duelData) {
                        usort($duelData, function($a, $b) {
                            return (strtotime($a["matchDate"]) > strtotime($b["matchDate"])) ? 1 : -1;
                        });
                    }
                    unset($duelData);

                    $output = "";
                    $matchNumber = 1;

                    $stagesToShowArr = [
                        "Финал" => "ФИНАЛ",
                        "1/2 финала" => "1/2",
                        "1/4 финала" => "1/4",
                        "группа2" => "группа2",
                        "1/8 финала" => "1/8",
                        "1/16 финала" => "1/16",
                        "группа" => "группа",
                        "1/32 финала" => "1/32",
                        "1/64 финала" => "1/64",
                        "Раунд плей-офф" => "отбор",
                        "Третий квалификационный раунд" => "отбор",
                        "Третий отборочный раунд" => "отбор",
                        "3-й квалификационный раунд" => "отбор",
                        "2-й квалификационный раунд" => "отбор",
                        "Второй квалификационный раунд" => "отбор",
                        "Второй отборочный раунд" => "отбор",
                        "1-й квалификационный раунд" => "отбор",
                        "Первый квалификационный раунд" => "отбор",
                        "Первый отборочный раунд" => "отбор",
                        "Первый раунд" => "отбор",
                        "Квалификационный раунд" => "отбор",
                        "Отборочный раунд" => "отбор",
                        'Предварительный раунд - Финал' => "отбор",
                        'Предварительный раунд - 1/2 финала' => "отбор",
                        "Предварительный раунд, финал" => "отбор",
                        "Предварительный раунд, 1/2 финала" => "отбор",
                        "Предварительный раунд" => "отбор",
                    ];

                    foreach ($duelsArr as $duelSerialInd => $duelData) {

                        $duelResultClass = "win";
                        $duelResRow = 
                        "<tr class='duel-result duel-win' title='Дуэль выше выиграна'>
                            <td colspan='5'>
                            </td>
                            <td>
                                &#9650;
                            </td>
                        </tr>";
                        if ($duelsResults[$duelSerialInd]["result"] === "secondClubVictory") {
                            $duelResultClass = "loose";
                            $duelResRow = "
                            <tr class='duel-result duel-loose' title='Дуэль выше проиграна'>
                                <td colspan='5'>
                                </td>
                                <td>
                                    &#9660;
                                </td>
                            </tr>";
                        } elseif ($duelsResults[$duelSerialInd]["result"] === "draw") {
                            $duelResultClass = "draw";
                            $duelResRow = "
                            <tr class='duel-result duel-draw'
                            title='Дуэль выше не выявила победителя'>
                                <td colspan='5'>
                                </td>
                                <td>
                                    <span class='yellow-circle'>
                                        &#9679;
                                    </span>
                                </td>
                            </tr>";
                        } elseif ($duelsResults[$duelSerialInd]["result"] === "notFinished") {
                            $duelResultClass = "";
                            $duelResRow = "";
                        }
                        // $duelInd = unserialize($duelSerialInd);

                        $finalClass = "";
                        if ($duelData[0]["tourneyStage"] === "Финал") {
                            $finalClass = " final";
                        }        

                        foreach ($duelData as $curMatch) {

                            $output = "{$output}<tr class='duel-{$duelResultClass}{$finalClass}'>";

                            $output = "{$output}<td class='number-of-match'>{$matchNumber}</td>";
                            $matchNumber++;

                            $homeCell = "<td title='дома'>д</td>";
                            if ($curMatch["home"] === "neutral") {
                                $homeCell = "<td title='нейтральное поле'>н</td>";
                            } elseif ( ($curMatch["home"] === $secondClubFullName) || ($curMatch["home"] === $secondClubShortName) || (in_array($curMatch["home"], $secondClubAltNames)) ) {
                                $homeCell = "<td title='в гостях'>г</td>";
                            }
                            $output = "{$output}{$homeCell}";

                            $firstClubGoals = $secondClubGoals = 0;
                            if ($curMatch["firstClubId"] == $firstClubId) {
                                $firstClubGoals = $curMatch["firstClubGoals"];
                                $secondClubGoals = $curMatch["secondClubGoals"];
                            } else {
                                $firstClubGoals = $curMatch["secondClubGoals"];
                                $secondClubGoals = $curMatch["firstClubGoals"];                
                            }

                            // Доп. инфо по матчу. (Нужно ещё доработать на случай жребия и двух событий одновременно (жребий и доп. матч. например))
                            $addText = "";
                            if ($curMatch["hadEfficientAddTime"] == 1) {
                                $addText = "<br><span class='add-time-text'>(доп. время)</span>";
                            }
                            if ($curMatch["hadPenalties"] == 1) {
                                $victOrLes = "победа";
                                if ($duelsResults[$duelSerialInd]["result"] === "secondClubVictory") {
                                    $victOrLes = "поражение";
                                }
                                $addText = "<br><span class='penalty-text'>({$victOrLes}<br>по пенальти)</span>";
                            }
                            if ($curMatch["comments"] === "доп. матч") {
                                $addText = "<br><span class='add-match-text'>(доп. матч)</span>";
                            }
                            if (($curMatch["comments"] === "тех. победа") && ($curMatch["firstClubId"] == $firstClubId)) {
                                $addText = "<br><span class='add-time-text'>(тех. победа)</span>";
                            } elseif (($curMatch["comments"] === "тех. победа") && ($curMatch["firstClubId"] == $secondClubId)) {
                                $addText = "<br><span class='add-time-text'>(тех. поражение)</span>";
                            } elseif (($curMatch["comments"] === "тех. поражение") && ($curMatch["firstClubId"] == $firstClubId)) {
                                $addText = "<br><span class='add-time-text'>(тех. поражение)</span>";
                            } elseif (($curMatch["comments"] === "тех. поражение") && ($curMatch["firstClubId"] == $secondClubId)) {
                                $addText = "<br><span class='add-time-text'>(тех. победа)</span>";
                            }

                            $output = "{$output}<td>{$firstClubGoals} : {$secondClubGoals}{$addText}</td>";

                            $year = $curMatch["year"];
                            $output = "{$output}<td>{$year}</td>";

                            $tourney = $curMatch["tourneyTitle"];
                            $output = "{$output}<td>{$tourney}</td>";

                            $stageToShow = $stagesToShowArr[$curMatch["tourneyStage"]];
                            $output = "{$output}<td>{$stageToShow}</td>";

                        }



                        $output = "{$output}</tr>";
                        $output = "{$output}{$duelResRow}";

                    }

                    echo $output;

                    echo 
                    "   </table>
                
                    </div>"    

            ?>

        <script src="../scripts/small-tables/add_hrefs.js"></script>

    </div>
</body>
</html>
