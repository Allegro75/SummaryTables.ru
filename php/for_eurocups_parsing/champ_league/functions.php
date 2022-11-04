<?php

// Определяем функцию для фильтрации МАТЧЕЙ по СТАДИИ турнира:
function getStageMatches($arr, $stage)
{
    $newArr = [];
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i]['tourneyStage'] === $stage) {
            $newArr[] = $arr[$i];
        }
    }
    return $newArr;
}

// Определяем функцию для получения полного описания КЛУБА по его НАЗВАНИЮ:
function getClubByName($name, $clubs)
{
    for ($i = 0; $i < count($clubs); $i++) {
        if ( ($clubs[$i]["basicFullName"] === $name) || ( strpos($clubs[$i]['altNames'], $name) !== false ) ) {
            return $clubs[$i];
        }
    }
}

// Служебная функция для получения МАТЧЕЙ нек-рого КЛУБА из нек-рого массива МАТЧЕЙ arr.
// Используется внутри orderMatchesInStage.
function getMatchesByClubName($arr, $club)
{
    $newArr = [];
    for ($i = 0; $i < count($arr); $i++) {
        if ( (($arr[$i]['firstClubName'] == $club["basicFullName"]) || ($arr[$i]['secondClubName'] === $club["basicFullName"])) 
        || 
        ( (strpos($club['altNames'], $arr[$i]['firstClubName']) !== false) || (strpos($club['altNames'], $arr[$i]['secondClubName']) !== false) ) ) {
            $newArr[] = $arr[$i];
        }
    }
    return $newArr;
}

// Служебная функция для получения МАТЧА по временой метке (TIMESTAMP'у).
// Используется внутри orderMatchesInStage.
function getMatchByTimeStamp($timeStamp, $arr)
{
    for ($i = 0; $i < count($arr); $i++) {
        // if ($arr[$i]['timeStamp'] == $timeStamp) {
        if (strtotime($arr[$i]['matchDate']) == $timeStamp) {
            return $arr[$i];
        }
    }
}

// Важная функция для упорядочивания МАТЧЕЙ некоторой СТАДИИ.
// На выходе имеем массив дуэлей, каждая из к-рых является массивом из обычно двух матчей.
// Список дуэлей упорядочен по клубам, успешные на предыдущей стадии - выше.
function orderMatchesInStage($stage, $matches, $orderedClubs)
{
    $stageMatches = getStageMatches($matches, $stage);
    $orderedMatches = [];
    for ($i = 0; $i < count($orderedClubs); $i++) {
        $pairMatches = getMatchesByClubName($stageMatches, $orderedClubs[$i]);
        $allTimeStamps = [];
        for ($ind = 0; $ind < count($pairMatches); $ind++) {
            // $allTimeStamps[] = $pairMatches[$ind]['timeStamp'];
            $allTimeStamps[] = strtotime($pairMatches[$ind]['matchDate']); // Похоже, раньше в таблице с матчами у меня было поле 'timeStamp'. Сейчас его нет.
        }
        sort($allTimeStamps);
        $orderedPairMatches = [];
        for ($index = 0; $index < count($allTimeStamps); $index++) {
            $orderedPairMatches[] = getMatchByTimeStamp($allTimeStamps[$index], $pairMatches);
        }
        if ($orderedPairMatches) {
            $orderedMatches[] = $orderedPairMatches;
        }
    }
    return $orderedMatches;
}

// Функция для ДОПОЛНЕНИЯ упорядоченного массива клубов
// (на входе - упорядоченный массив матчей arr):
function addClubsToOrdered($arr, $orderedClubs, $clubs)
{
    $newClubName = '';
    for ($i = 0; $i < count($arr); $i++) {
        for ($ind = 0; $ind < count($orderedClubs); $ind++) {
            if ( ($arr[$i][0]['firstClubName'] === $orderedClubs[$ind]["basicFullName"]) || ( strpos($orderedClubs[$ind]['altNames'], $arr[$i][0]['firstClubName']) !== false ) ) {
                $newClubName = $arr[$i][0]['secondClubName'];
                break;
            } else {
                $newClubName = $arr[$i][0]['firstClubName'];
            }
        }
        $newClub = getClubByName($newClubName, $clubs);
        $orderedClubs[] = $newClub;
    }
    return $orderedClubs;
}

// Функция для определения адреса ЛОГОТИПА:
// require_once('../../getFileList.php');
// $imagesList = getFileList('../../images');
// $imagesList = scandir('../../images');
// echo "<pre>";
// print_r($imagesList);
function getImageAdress($club, $imagesList)
{
    $imageAdress = '';
    if ($code = $club['code']) {
        if (in_array("{$code}.png", $imagesList)) {
            $imageAdress = ["{$code}.png", "{$club['CSSClass']}", "{$club['shortName']}"];
        } else if (in_array("{$code}.svg", $imagesList)) {
            $imageAdress = ["{$code}.svg", "{$club['CSSClass']}", "{$club['shortName']}"];
        } else if (in_array("{$code}.jpg", $imagesList)) {
            $imageAdress = ["{$code}.jpg", "{$club['CSSClass']}", "{$club['shortName']}"];
        }
    } else {
        $imageAdress = ["flags/{$club['countryEngCode']}.png", 'img_flag', "{$club['country']}"];
    }
    return $imageAdress;
}

// ГЛАВНАЯ функция для ЗАПОЛНЕНИЯ СОДЕРЖАНИЯ стадии матчами:
function writeMatchesByStage($name, $matches, $orderedClubs, $clubs, $imagesList)
{

    // echo "<pre>";
    // print_r($orderedClubs);
    // echo "</pre>";
    $orderedStageMatches = orderMatchesInStage($name, $matches, $orderedClubs);
    // echo "<pre>";
    // var_dump($orderedStageMatches);
    // echo "</pre>";    

    // Дополняем упорядоченный массив клубов:
    $orderedClubs = addClubsToOrdered($orderedStageMatches, $orderedClubs, $clubs);
    // echo "<pre>";
    // print_r($orderedClubs);

    echo
        "<div class='tourney__stage tour-stage'>
            <div class='tour-stage_name'>
                {$name}
            </div>";
    $out =
        "   <div class='tour-stage__content stage-content'>";

    for ($i = 0; $i < count($orderedStageMatches); $i++) {

        $club1Name = $orderedStageMatches[$i][0]['firstClubName'];
        $club2Name = $orderedStageMatches[$i][0]['secondClubName'];
        $club1 = getClubByName($club1Name, $orderedClubs);
        $club2 = getClubByName($club2Name, $orderedClubs);
        $code1 = getImageAdress($club1, $imagesList);
        $code2 = getImageAdress($club2, $imagesList);
        $goals_1_1 = $orderedStageMatches[$i][0]["firstClubGoals"];
        $goals_1_2 = $orderedStageMatches[$i][0]["secondClubGoals"];
        $goals_2_1 = $orderedStageMatches[$i][1]["secondClubGoals"];
        $goals_2_2 = $orderedStageMatches[$i][1]["firstClubGoals"];
        // В случае наличия ТРЕТЬЕГО матча:
        if ($orderedStageMatches[$i][2]) {
            if ($orderedStageMatches[$i][2]['firstClubName'] === $club1Name) {
                $goals_3_1 = $orderedStageMatches[$i][2]["firstClubGoals"];
                $goals_3_2 = $orderedStageMatches[$i][2]["secondClubGoals"];
            } else {
                $goals_3_1 = $orderedStageMatches[$i][2]["secondClubGoals"];
                $goals_3_2 = $orderedStageMatches[$i][2]["firstClubGoals"];
            }
        }

        // Для формирования необязательного дива penalty:
        $penalty2 = '';
        $penalty3 = '';

        // Про ДОПОЛНИТЕЛЬНОЕ время:
        $addTime2 = '';
        $addTime3 = '';
        if ($orderedStageMatches[$i][1]["hadEfficientAddTime"]) {
            $addTime2 = "доп. время";
            $baseTimeScore = strrev($orderedStageMatches[$i][1]["baseTimeScore"]);
        }
        if ($orderedStageMatches[$i][2]["hadEfficientAddTime"]) {
            $addTime3 = "доп. время";
        }
        $toss2 = '';
        $toss3 = '';

        $addMatch3 = '';
        // Про ДОП. МАТЧИ:
        if ($orderedStageMatches[$i][2]["comments"] === 'доп. матч') {
            $addMatch3 = "доп. матч";
        } 

        // Определяем победителя ДУЭЛИ:
        $goals_1_sum = $goals_1_1 + $goals_2_1;
        $goals_2_sum = $goals_1_2 + $goals_2_2;
        // var_dump($goals_1_sum, $goals_2_sum);

        // если число голов неравное:
        if ($goals_1_sum > $goals_2_sum) {
            $club1Classes = 'club-name club-name_winner';
            $club2Classes = 'club-name';
        } else if ($goals_2_sum > $goals_1_sum) {
            $club1Classes = 'club-name';
            $club2Classes = 'club-name club-name_winner';

        // если число голов РАВНОЕ:
        } else if ($goals_2_sum === $goals_1_sum) {
            // В случае наличия ТРЕТЬЕГО матча:
            if ($orderedStageMatches[$i][2]) {
                if ($goals_3_1 > $goals_3_2) {
                    $club1Classes = 'club-name club-name_winner';
                    $club2Classes = 'club-name';
                } else if ($goals_3_2 > $goals_3_1) {
                    $club1Classes = 'club-name';
                    $club2Classes = 'club-name club-name_winner';
                } 
                // Предполагаем, что здесь всегда решал жребий:
                else {
                    if ($orderedStageMatches[$i][2]['tossWinner'] === $orderedStageMatches[$i][0]['firstClubName']) {
                        $club1Classes = 'club-name club-name_winner';
                        $club2Classes = 'club-name';
                        $toss3 = "победа по жребию";
                    } else {
                        $club1Classes = 'club-name';
                        $club2Classes = 'club-name club-name_winner';
                        $toss3 = "поражение по жребию";
                    }
                }
            }
            // В случае (ОСНОВНОМ) если матчей было ДВА:
                // И если решал жребий:
            else if ($orderedStageMatches[$i][1]['hadToss'] == 1) {
                if ($orderedStageMatches[$i][1]['tossWinner'] === $orderedStageMatches[$i][1]['firstClubName']) {
                    $club1Classes = 'club-name';
                    $club2Classes = 'club-name club-name_winner';
                    $toss2 = "победа по жребию";
                } else {
                    $club1Classes = 'club-name club-name_winner';
                    $club2Classes = 'club-name';
                    $toss2 = "поражение по жребию";
                }
                // Если решали голы на ЧУЖОМ поле:
            } else if (($orderedStageMatches[$i][1]['tourneyFinalYear'] < 2022) && ($goals_2_1 > $goals_1_2)) { // про голы на чужоим поле
                $club1Classes = 'club-name club-name_winner';
                $club2Classes = 'club-name';
            } else if (($orderedStageMatches[$i][1]['tourneyFinalYear'] < 2022) && ($goals_1_2 > $goals_2_1)) { // про голы на чужоим поле
                $club1Classes = 'club-name';
                $club2Classes = 'club-name club-name_winner';
            } 
            // Если решали пенальти:
            else if ($orderedStageMatches[$i][1]['hadPenalties'] == 1) {
                // var_dump('yes');
                if ($orderedStageMatches[$i][1]['penaltiesWinner'] === $orderedStageMatches[$i][1]['firstClubName']) {
                    // var_dump('club1');
                    $club1Classes = 'club-name';
                    $club2Classes = 'club-name club-name_winner';
                    $penalty2 = "<div class='penalty'>(победа по пенальти)</div>";
                    $penalty2_basePart = "победа по пенальти";
                } else {
                    // var_dump('club2');
                    $club1Classes = 'club-name club-name_winner';
                    $club2Classes = 'club-name';
                    $penalty2 = "<div class='penalty'>(поражение по пенальти)</div>";
                    $penalty2_basePart = "поражение по пенальти";
                }
            }
        }

        // Формируем див penalty для матчей до-пенальтийной эпохи 
        // (т.е. эпохи с доп. матчами и жребием):
        // Для третьего матча:
        if ($addMatch3 === "доп. матч") {
            if ($addTime3 === "доп. время") {
                if ($toss3 !== '') {
                    $penalty3 = "<div class='penalty'>(доп. матч, доп. время, {$toss3})</div>";
                }
                else {
                    $penalty3 = "<div class='penalty'>(доп. матч, доп. время)</div>";
                }
            }
            else if ($addTime3 === "") {
                if ($toss3 !== '') {
                    $penalty3 = "<div class='penalty'>(доп. матч, {$toss3})</div>";
                }
                else {
                    $penalty3 = "<div class='penalty'>(доп. матч)</div>";
                }
            }
            if ($addTime2 === "доп. время") {
                $penalty2 = "<div class='penalty'>(доп. время)</div>"; 
            }
        } // Если доп. матча не было (т.е. матчей было два):
        else {
            if ($addTime2 === "доп. время") {
                if ($toss2 !== '') {
                    $penalty2 = "<div class='penalty'>(доп. время, {$toss2})</div>";
                }
                elseif ($orderedStageMatches[$i][1]['hadPenalties'] == 1) {
                    $penalty2 = "<div class='penalty'>(доп. время, основное - {$baseTimeScore}, {$penalty2_basePart})</div>";
                }
                else {
                    $penalty2 = "<div class='penalty'>(доп. время, основное - {$baseTimeScore})</div>";
                }
            }
            else {
                if ($toss2 !== '') {
                    $penalty2 = "<div class='penalty'>({$toss2})</div>";
                }
            }
        }

        // Про ТЕХНИЧЕСКИЕ результаты:
        $penalty = '';
        if ($orderedStageMatches[$i][0]["techWin"] == 1) {
            $penalty = "<div class='penalty'>({$orderedStageMatches[$i][0]["comments"]})</div>";
        }
        if ($orderedStageMatches[$i][1]["techWin"] == 1) {
            $penalty2 = "<div class='penalty'>({$orderedStageMatches[$i][1]["comments"]})</div>";
        }

        // Про ДОП. ВРЕМЯ в первом (и, видимо, единственном) матче:
        if ($orderedStageMatches[$i][0]["hadEfficientAddTime"] == 1) {
            $penalty = "<div class='penalty' style='margin-right: 5px;'>(доп. время)</div>";
        }

        // Определяем МЕСТО и ВРЕМЯ матчей:
        $field1 = $orderedStageMatches[$i][0]['fieldCity'];
        $field2 = $orderedStageMatches[$i][1]['fieldCity'];
        $field3 = $orderedStageMatches[$i][2]['fieldCity'];
        $date1 = $orderedStageMatches[$i][0]['date'];
        if ($date1) {
            $date1 = "{$date1}.";
        }
        $year1 = $orderedStageMatches[$i][0]['year'];
        $date2 = $orderedStageMatches[$i][1]['date'];
        if ($date2) {
            $date2 = "{$date2}.";
        }
        $year2 = $orderedStageMatches[$i][1]['year'];
        $date3 = $orderedStageMatches[$i][2]['date'];
        if ($date3) {
            $date3 = "{$date3}.";
        }
        $year3 = $orderedStageMatches[$i][2]['year'];
        if ($orderedStageMatches[$i][0]['home'] === 'neutral') {
            $field1 = "{$orderedStageMatches[$i][0]['fieldCity']}, {$orderedStageMatches[$i][0]['fieldCountry']}";
        }
        if ($orderedStageMatches[$i][1]['home'] === 'neutral') {
            $field2 = "{$orderedStageMatches[$i][1]['fieldCity']}, {$orderedStageMatches[$i][1]['fieldCountry']}";
        }
        if ($orderedStageMatches[$i][2]['home'] === 'neutral') {
            $field3 = "{$orderedStageMatches[$i][2]['fieldCity']}, {$orderedStageMatches[$i][2]['fieldCountry']}";
        }

        if ($year1 == 0) {$year1 = '';}
        if ($year2 == 0) {$year2 = '';}
        if ($year3 == 0) {$year3 = '';}

        // Если матч был ОДИН (в основном это тех. победы. Но есть ещё полуфиналы ЛЧ-1994.
        // И есть ещё отбор к ЛЧ-2019. И короновирусные турниры-2020):
        if (count($orderedStageMatches[$i]) == 1) {
            $out .= 
                "
                    <div class='stage-content__row content-row content-row_row-1'>

                        <div class='row_matches__grid matches-row matches-row_1-match'>

                            <div class='matches-row__1st-club'>
                                <div class='logo logo-left'>
                                    <img src='../../images/{$code1[0]}' alt='{$club1Name}' class='{$code1[1]}' title='{$code1[2]}'>
                                </div>
                                <div class='{$club1Classes}'>
                                    {$club1Name}
                                </div>
                            </div>

                            <div class='score score_1'>
                                {$goals_1_1} : {$goals_1_2}
                            </div>

                            <div class='matches-row__2nd-club'>
                                <div class='{$club2Classes}'>
                                    {$club2Name}
                                </div>
                                <div class='logo logo-right'>
                                    <img src='../../images/{$code2[0]}' alt='{$club2Name}' class='{$code2[1]}' title='{$code2[2]}'>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class='stage-content__row content-row content-row_row-2'>
                        <div class='field-row__1st-match field-row_1-match'>
                            {$penalty}
                            <div class='field field_1' style='margin-right:5px; margin-left:5px;'>
                                {$field1}
                            </div>
                            <div class='date date_1' style='margin-left:5px;'>
                                {$date1}{$year1}
                            </div>                     
                        </div>
                    </div>"; 
        }
        // Если же матчей было как минимум ДВА (нормальный случай):
        else if ($orderedStageMatches[$i][1]) {
            $out = $out.
                "
                                <div class='stage-content__row content-row content-row_row-1'>
                                    <div class='row_matches__grid matches-row'>
                                        <div class='matches-row__1st-club'>
                                            <div class='logo logo-left'>
                                                <img src='../../images/{$code1[0]}' alt='{$club1Name}' class='{$code1[1]}' title='{$code1[2]}'>
                                            </div>
                                            <div class='{$club1Classes}'>
                                                {$club1Name}
                                            </div>
                                            <div class='score score_1'>
                                                {$goals_1_1} : {$goals_1_2}
                                            </div>
                                        </div>        
                                        <div class='matches-row__2nd-club'>
                                            <div class='score score_2'>
                                                {$goals_2_1} : {$goals_2_2}
                                            </div>
                                            <div class='{$club2Classes}'>
                                                {$club2Name}
                                            </div> 
                                            <div class='logo logo-right'>
                                                <img src='../../images/{$code2[0]}' alt='{$club2Name}' class='{$code2[1]}' title='{$code2[2]}'>
                                            </div> 
                                        </div>         
                                    </div>                                         
                                </div>

                                <div class='stage-content__row content-row content-row_row-2'>
                                    <div class='row_field__grid field-row'>
                                        <div class='field-row__1st-match'>
                                            <div class='date date_1'>
                                                {$date1}{$year1}
                                            </div>                    
                                            <div class='field field_1'>
                                                {$field1}
                                            </div>
                                            {$penalty} 
                                        </div>
                                        <div class='field-row__2nd-match'>   
                                            {$penalty2}
                                            <div class='field field_2'>
                                                {$field2}
                                            </div>
                                            <div class='date date_2'>
                                                {$date2}{$year2}
                                            </div> 
                                        </div> 
                                    </div>
                                </div>";
        }
        // В случае наличия ТРЕТЬЕГО матча:
        if ($orderedStageMatches[$i][2]) {
                        $out = $out.
                            "<div class='stage-content__row content-row content-row_row-3'>
                                    <div class='matches-row__1st-club'>
                                        <div class='score score_1'>
                                            {$goals_3_1} : {$goals_3_2}
                                        </div>
                                    </div>                                        
                            </div>

                            <div class='stage-content__row content-row content-row_row-4'>

                                    <div class='field-row__3rd-match'>

                                        {$penalty3} 
                                        <div class='date date_1'>
                                            {$date3}{$year3}
                                        </div>                    
                                        <div class='field field_3'>
                                            {$field3}
                                        </div>
                                       
                                    </div>

                                </div>
                            </div>";
        }

    }
    echo $out;
    echo 
    "   </div>
    </div>";

    return $orderedClubs;

}

// Функция для определения всех (обычно двух) матчей нек-рой пары клубов между собой
// в рамках какого-либо списка матчей:
function getPairMatches ($clubName1, $clubName2, $matchList) {
    $matchesArr = [];
    for ($i = 0; $i < count($matchList); $i++) {
        if ( ( ($matchList[$i]["firstClubName"] === $clubName1) && ($matchList[$i]["secondClubName"] === $clubName2) ) ||
        ( ($matchList[$i]["firstClubName"] === $clubName2) && ($matchList[$i]["secondClubName"] === $clubName1) ) ) {
            $matchesArr[] = $matchList[$i];
        }
    }
    return $matchesArr;
}

// Функция для подсчёта очков (и разницы мячей), набранных нек-рым клубом на нек-ром массиве матчей:
function getPoints($name, $matchList, $year) {
    $victories = 0;
    $draws = 0;
    $lesions = 0;
    $scoredGoals = 0;
    $concededGoals = 0;
    $guestGoals = 0;    
    for ($i = 0; $i < count($matchList); $i++) {
        if ($matchList[$i]["firstClubName"] === $name) {
            $victories += $matchList[$i]["fCVictory"];
            $draws += $matchList[$i]["fCDraw"];
            $lesions += $matchList[$i]["fCLesion"];
            $scoredGoals += $matchList[$i]["firstClubGoals"];
            $concededGoals += $matchList[$i]["secondClubGoals"];
        }
        else if ($matchList[$i]["secondClubName"] === $name) {
            $victories += $matchList[$i]["fCLesion"];
            $draws += $matchList[$i]["fCDraw"];
            $lesions += $matchList[$i]["fCVictory"];
            $scoredGoals += $matchList[$i]["secondClubGoals"];
            $concededGoals += $matchList[$i]["firstClubGoals"];
            $guestGoals += $matchList[$i]["secondClubGoals"];
        }
    }
    if ($year >= 1996) {
        $pointSystemCoef = 3;
    }
    else {
        $pointSystemCoef = 2;
    }
    $points = ($victories * $pointSystemCoef) + $draws;
    $goalsDiff = $scoredGoals - $concededGoals;
    return [$name, $victories, $draws, $lesions, $scoredGoals, $concededGoals, $points, $goalsDiff, $guestGoals];
}

// Выносим служебную функцию для преобразования упорядоченного массива из трёх клубов
// в такой же, но содержащий инфу об игре во всей группе:
function getThreeClubsForMergeArr ($threeClubsArr, $fourClubsArr) {
    $resArr = [];
    for ($threeCIndex = 0; $threeCIndex < count($threeClubsArr); $threeCIndex++) {
        for ($pArrInd = 0; $pArrInd < count($fourClubsArr); $pArrInd++) {
            if ($threeClubsArr[$threeCIndex][0] === $fourClubsArr[$pArrInd][0]) {
                $resArr[] = $fourClubsArr[$pArrInd];
                break;
            }
        }
    }
    return $resArr;
}

// Функция для РАСПРЕДЕЛЕНИЯ мест и получения прочей инфы о группе:
function getOrderAndInfo($clubNamesArr, $matchesList, $clubs, $year) {

    // Сначала собираем массив клубов с инфой об их успехах на данном массиве матчей:
    $pointsArr = [];
    for ($i = 0; $i < count($clubNamesArr); $i++) {
        $pointsArr[] = getPoints( $clubNamesArr[$i], getMatchesByClubName($matchesList, getClubByName($clubNamesArr[$i], $clubs)), $year );
    }
    // Сортируем этот массив по набранным очкам:
    usort($pointsArr, 'comparePoints');

    // Определяем массив, к-рый будем в конце концов возвращать из функции:
    $resultArr = [];
    // Далее запускаем попарный перебор на предмет выяснения РАВЕНСТВА очков:
    for ($i = 0; $i < count($pointsArr) - 1; $i++) {

        // Если очков у первой и второй команды поровну:
        if ($pointsArr[$i][6] == $pointsArr[$i + 1][6]) {

            // И при этом их больше, чем у третьей команды:
            if ($pointsArr[$i + 1][6] > $pointsArr[$i + 2][6]) {

                var_dump("yes");

                // то ищем победителя дуэли в личных встречах:
                $winner = getDuelWinner( $pointsArr[$i][0], $pointsArr[$i + 1][0], getMatchesByClubName( getMatchesByClubName( $matchesList, getClubByName($pointsArr[$i][0], $clubs) ), getClubByName( $pointsArr[$i + 1][0], $clubs ) ) );
                if ($winner === $pointsArr[$i][0]) {
                    $resultArr[$i] = $pointsArr[$i];
                    $resultArr[$i + 1] = $pointsArr[$i + 1];
                    // $i++;
                }
                else if ($winner === $pointsArr[$i + 1][0]) {
                    $resultArr[$i] = $pointsArr[$i + 1];
                    $resultArr[$i + 1] = $pointsArr[$i];
                    $pointsArr[$i + 1] = $pointsArr[$i];
                    // $i++;
                    // Если такого победителя дуэли нет:
                } else if (!$winner) {
                    // то обращаемся к общей разности мячей:
                    if ($pointsArr[$i][7] > $pointsArr[$i + 1][7]) {
                        $resultArr[$i] = $pointsArr[$i];
                        $resultArr[$i + 1] = $pointsArr[$i + 1];
                        // $i++;
                    } else if ($pointsArr[$i][7] < $pointsArr[$i + 1][7]) {
                        $resultArr[$i] = $pointsArr[$i + 1];
                        $resultArr[$i + 1] = $pointsArr[$i];
                        $pointsArr[$i + 1] = $pointsArr[$i];
                        // Если и разность мячей не помогла:
                    } else if ($pointsArr[$i][7] === $pointsArr[$i + 1][7]) {
                        // то обращаемся к общему числу голов:
                        if ($pointsArr[$i][4] > $pointsArr[$i + 1][4])  {
                            $resultArr[$i] = $pointsArr[$i];
                            $resultArr[$i + 1] = $pointsArr[$i + 1];
                            // $i++;
                        } else if ($pointsArr[$i][4] < $pointsArr[$i + 1][4]) {
                            $resultArr[$i] = $pointsArr[$i + 1];
                            $resultArr[$i + 1] = $pointsArr[$i];
                            $pointsArr[$i + 1] = $pointsArr[$i];
                            // Если общее число голов не помогло:
                        } else if ($pointsArr[$i][4] === $pointsArr[$i + 1][4]) {
                            // то обращаемся к гостевым голам:
                            if ($pointsArr[$i][8] > $pointsArr[$i + 1][8]) {
                                $resultArr[$i] = $pointsArr[$i];
                                $resultArr[$i + 1] = $pointsArr[$i + 1];
                                // $i++;
                            } else if ($pointsArr[$i][8] < $pointsArr[$i + 1][8]) {
                                $resultArr[$i] = $pointsArr[$i + 1];
                                $resultArr[$i + 1] = $pointsArr[$i];
                                $pointsArr[$i + 1] = $pointsArr[$i];
                            }
                        } 
                    }
                }

            }

            // Если же у нас тройной делёж:
            // else if ($pointsArr[$i + 1][6] == $pointsArr[$i + 2][6]) {
            else if (($pointsArr[$i + 1][6] == $pointsArr[$i + 2][6]) && ($pointsArr[$i + 1][6] > $pointsArr[$i + 3][6])) {

                $sharClubNames = [ $pointsArr[$i][0], $pointsArr[$i + 1][0], $pointsArr[$i + 2][0] ];
                // echo "<pre>";
                // print_r($sharClubNames);
                $sharMatchList = array_merge( getPairMatches($sharClubNames[0], $sharClubNames[1], $matchesList), getPairMatches($sharClubNames[0], $sharClubNames[2], $matchesList), getPairMatches($sharClubNames[1], $sharClubNames[2], $matchesList) );
                // echo "<pre>";
                // print_r($sharMatchList);
                // Собираем массив с инфой об успехах на тройном турнире:
                $threeClPointsArr = [];
                for ($ind = 0; $ind < count($sharClubNames); $ind++) {
                    $threeClPointsArr[] = getPoints( $sharClubNames[$ind], getMatchesByClubName($sharMatchList, getClubByName($sharClubNames[$ind], $clubs)), $year );
                }
                // Сортируем этот тройственный массив по набранным очкам:
                usort($threeClPointsArr, 'comparePoints');
                // Проверяем этот массив на предмет равенства очков.
                // Начнём с проверки на тройной делёж:
                if ($threeClPointsArr[0][6] == $threeClPointsArr[2][6]) {
                    // то сортируем по разности мячей:
                    usort($threeClPointsArr, 'compareByGoalsDiff');
                    // и пока на этом успокоимся.
                }

                $threeClForMergArr = getThreeClubsForMergeArr ($threeClPointsArr, $pointsArr);
                if ($i === 0) {
                    $threeClForMergArr[] = $pointsArr[3];
                    $resultArr = $threeClForMergArr;
                    return $resultArr;
                } 
                else if ($i === 1) {
                    $resultArr[1] = $threeClForMergArr[0];
                    $resultArr[2] = $threeClForMergArr[1];
                    $resultArr[3] = $threeClForMergArr[2];
                    return $resultArr;
                }

            }

            // Если же делёж четверной (это добавлено только 23.10.2022, когда проблема встретилась впервые, причём на не завершённом групповом турнире):
            // else if ($pointsArr[$i + 1][6] == $pointsArr[$i + 2][6]) {
            else if (($pointsArr[$i + 1][6] == $pointsArr[$i + 2][6]) && ($pointsArr[$i + 1][6] == $pointsArr[$i + 3][6])) {
                  
                usort($pointsArr, 'compareByGoalsDiff');
                return $pointsArr;

            }

        }

        // А вот если дележа нет:
        else {
            $resultArr[$i] = $pointsArr[$i];
            $resultArr[$i + 1] = $pointsArr[$i + 1]; 
        }

    }
    return $resultArr;

}

// Функция для определения победителя классической современной дуэли (без учёта пенальти,
// мы будем использовать это для распределения мест в группах):
function getDuelWinner($name1, $name2, $matchList) {
    if ($matchList[0]["firstClubName"] === $name1) {
        $firstClubGoals = $matchList[0]["firstClubGoals"] + $matchList[1]["secondClubGoals"];
        $secClubGoals = $matchList[0]["secondClubGoals"] + $matchList[1]["firstClubGoals"];
    } else if ($matchList[0]["firstClubName"] === $name2) {
        $firstClubGoals = $matchList[1]["firstClubGoals"] + $matchList[0]["secondClubGoals"];
        $secClubGoals = $matchList[1]["secondClubGoals"] + $matchList[0]["firstClubGoals"];
    }
    if ($firstClubGoals > $secClubGoals) {
        return $name1;
    }
    else if ($firstClubGoals < $secClubGoals) {
        return $name2;
    }
    else if ($firstClubGoals === $secClubGoals) {
        if ($matchList[0]["firstClubName"] === $name1) {
            $fCGuestGoals = $matchList[1]["secondClubGoals"];
            $sCGuestGoals = $matchList[0]["secondClubGoals"];
        } else if ($matchList[0]["firstClubName"] === $name2) {
            $fCGuestGoals = $matchList[0]["secondClubGoals"];
            $sCGuestGoals = $matchList[1]["secondClubGoals"];
        }
        if ($fCGuestGoals > $sCGuestGoals) {
            return $name1;
        } else if ($fCGuestGoals < $sCGuestGoals) {
            return $name2;
        }
        else return false;
    }
}

// Служебная функция для сортировки по разнице мячей:
function compareByGoalsDiff ($pointA, $pointB) {
    return -($pointA[7] - $pointB[7]);
}

// Функция для получения ДАННЫХ и СОРТИРОВКИ команд в ГРУППЕ:
    // Служебная функция для использования при сортировке:
function comparePoints ($pointA, $pointB) {
    return -($pointA[6] - $pointB[6]);
}

// Функция для получения матча по двум клубам:
function getMatchByClubs ($name1, $name2, $matchList) {
    for ($i = 0; $i < count($matchList); $i++) {
        if (($matchList[$i]["firstClubName"] === $name1) && ($matchList[$i]["secondClubName"] === $name2))
        return $matchList[$i];
    }
}

// Для заполнения содержания ГРУППОВОй стадии:
function writeGroupStage($orderedClubs, $matches, $stage, $clubs, $imagesList, $tourneyYear) {

    // echo '<pre>';
    // var_dump($orderedClubs);
    // echo '</pre>';

    if ($stage == 'группа') {
        $stageTitle = 'ГРУППОВОЙ этап';
    } else if ($stage == 'группа2') {
        $stageTitle = 'Второй групповой этап';
    }

    echo
    "<div class='tourney__stage tour-stage'>
                    <div class='tour-stage_name'>
                        {$stageTitle}
                    </div>";
   
                    echo 
                    "<div class='tour-stage__content stage-content'>"; 
                    
    // Cначала выбираем все матчи групповой стадии во всех группах:
    $groupMatches = getStageMatches($matches, $stage);
    // echo '<pre>';
    // var_dump($groupMatches);
    // echo '</pre>';

    // Перебираем все, кроме последнего элементы нашего массива orderedClubs (состоящего из команд, вышедших из групп) -
    // - участников плей-офф - находим клубы с новыми (отсутствующими в orderedClubs) соперниками по группе
    // (и таким образом, внутри каждой из "удачных" итераций перебора мы описываем полностью одну группу):
    if ($tourneyYear >= 1995) {
        $target = count($orderedClubs) - 1;
    }
    // Если годы 1992-1994, то перебираем два первых элемента нашего короткого (состоящего из команд, вышедших из групп) массива orderedClubs -
    // - финалистов розыгрыша - исходя из того, что каждая команда в нём станет "маткой" группы
    // (и таким образом, внутри каждой (из двух) итераций перебора мы описываем полностью одну группу):    
    else {
        $target = 2;
    }

    for ($i = 0, $num = 1; $i < $target; $i++) {

        // Определяем массив матчей данной группы (группы с данной маткой).
            // Для этого сначала ищем имена соперников матки на этой стадии.
                // Для этого сначала ищем матчи матки на этой стадии:
        $leaderMatches = getMatchesByClubName($groupMatches, $orderedClubs[$i]);
            // Теперь определяем имена соперников матки на этой стадии (плюс имя самой матки):
        $rawLeaderRivalNames = [];
        for ($ind = 0; $ind < count($leaderMatches); $ind++) {
            $rawLeaderRivalNames[] = $leaderMatches[$ind]["firstClubName"];
            $rawLeaderRivalNames[] = $leaderMatches[$ind]["secondClubName"];
        }
        // print_r($rawLeaderRivalNames);
        // echo '<br>';
        $leaderRivalNames = [];  
        for ($ind = 0; $ind < count($rawLeaderRivalNames); $ind++) {
            if ( ! (in_array($rawLeaderRivalNames[$ind], $leaderRivalNames)) ) {
                $leaderRivalNames[] = $rawLeaderRivalNames[$ind];
            }
        }
        // echo '<pre>';
        // print_r($leaderRivalNames);
        // echo '<br>';
        // print_r($orderedClubs);
        // echo '<br>';

        // Теперь нам надо определить, есть ли среди соперников данной потенциальной "матки" новые клубы
        // (ещё не упомянутые в orderedClubs), и только если они есть - продолжить выполнение данной итерации
        // (а если нет - перейти к следующей):
        for ($lRVNI = 0, $newClubs = 0; $lRVNI < count($leaderRivalNames); $lRVNI++) {
            for ($oCI = 0; $oCI < count($orderedClubs); $oCI++) {
                if ($leaderRivalNames[$lRVNI] === $orderedClubs[$oCI]['basicFullName'] ||
                (strpos($orderedClubs[$oCI]['altNames'], $leaderRivalNames[$lRVNI]) !== false) ) {
                    break;
                }
                if ( $oCI === (count($orderedClubs) - 1) ) {
                    $newClubs++;
                    // echo '<pre>';          
                    // print_r($leaderRivalNames[$lRVNI]);
                    // echo '<br>';                    
                    break;
                }
            }
            if ($newClubs > 0) {
                break;
            }
        }
        if ($newClubs == 0) {
            continue;
        }
        // echo '<pre>';
        // print_r($newClubs);
        // echo '<br>';

        // Наконец определяем массив матчей данной группы:
        $thisGroupMatches = getMatchesByClubName($groupMatches, getClubByName($leaderRivalNames[0], $clubs));
        // echo '<pre>';
        // print_r($thisGroupMatches);        
        $thisGroupMatches = array_merge( $thisGroupMatches, getPairMatches($leaderRivalNames[1], $leaderRivalNames[2], $groupMatches) );
        $thisGroupMatches = array_merge( $thisGroupMatches, getPairMatches($leaderRivalNames[1], $leaderRivalNames[3], $groupMatches) );
        $thisGroupMatches = array_merge( $thisGroupMatches, getPairMatches($leaderRivalNames[2], $leaderRivalNames[3], $groupMatches) );
        // echo '<pre>';
        // print_r($thisGroupMatches);
        // print_r(getPairMatches($leaderRivalNames[2], $leaderRivalNames[3], $groupMatches));
        // echo '<br>';

        // Задаём массив с инфой о событиях в группе:
        $groupInfo = getOrderAndInfo($leaderRivalNames, $thisGroupMatches, $clubs, $tourneyYear);
        // echo '<pre>';
        // print_r ( $groupInfo );
        // echo '<br>';
        
        // Адреса логотипов:
        $logo1 = getImageAdress(getClubByName($groupInfo[0][0], $clubs), $imagesList);
        $logo2 = getImageAdress(getClubByName($groupInfo[1][0], $clubs), $imagesList);
        $logo3 = getImageAdress(getClubByName($groupInfo[2][0], $clubs), $imagesList);
        $logo4 = getImageAdress(getClubByName($groupInfo[3][0], $clubs), $imagesList);

        // Пишем html для таблицы с группой:
        if (true) {
            echo
            "<div class='stage-content__group content-group group{$num}'>
                <table class='group-table'>
                    <thead>
                        <tr>
                            <td colspan='3' title='группа {$num}'><i>{$num}</i></td>

                            <td>
                                <img class='football-logo-table {$logo1[1]}' src='../../images/{$logo1[0]}' alt='{$groupInfo[0][0]}' title='{$logo1[2]}'>
                            </td> 

                            <td>
                                <img class='football-logo-table {$logo2[1]}' src='../../images/{$logo2[0]}' alt='{$groupInfo[1][0]}' title='{$logo2[2]}'>
                            </td>

                            <td>
                                <img class='football-logo-table {$logo3[1]}' src='../../images/{$logo3[0]}' alt='{$groupInfo[2][0]}' title='{$logo3[2]}'>
                            </td>  

                            <td>
                                <img class='football-logo-table {$logo4[1]}' src='../../images/{$logo4[0]}' alt='{$groupInfo[3][0]}' title='{$logo4[2]}'>
                            </td>
                            
                            <td class='gap'></td>
                            
                            <td title='Выигрыши'>В</td>
                            
                            <td title='Ничьи'>Н</td>

                            <td title='Поражения'>П</td> 

                            <td title='Разница мячей' class='balls-cell'>М</td>

                            <td title='Очки'>О</td>                                                                                                               
                        </tr>
                    </thead>

                    <tbody>";

                    // Перебираем строки таблицы, начиная со строки первого клуба:
                    for ($ri = 0, $number = 1; $ri < count($groupInfo); $ri++, $number++) {

                        $winClass = '';
                        if ($number === 1)
                            {$winClass = 'club-name_winner';}
                        if ($tourneyYear >= 1994 && $number === 2) {
                            {$winClass = 'club-name_winner';}
                        }

                        $logo = getImageAdress(getClubByName($groupInfo[$ri][0], $clubs), $imagesList);

                        echo "
                        <tr>
                            <td class={$winClass}>{$number}</td>

                            <td class='logo-cell_aside'>
                                <img class='football-logo-table {$logo[1]}' src='../../images/{$logo[0]}' alt='{$groupInfo[$ri][0]}' title='{$logo[2]}'>
                            </td>

                            <td class='club-name-cell'>
                                <div class='club-name {$winClass}'>{$groupInfo[$ri][0]}</div>
                            </td>";

                            // Перебираем колонки таблицы, начиная с колонки первого клуба:
                            for ($index = 0; $index < count($groupInfo); $index++) {

                                $match = getMatchByClubs($groupInfo[$ri][0], $groupInfo[$index][0], $thisGroupMatches);
                                $score = "{$match['firstClubGoals']} : {$match['secondClubGoals']}";
                                if ($match) { // Проверяем, состоялся ли матч
                                    $hintRecord = " title = '{$match['firstClubName']} - {$match['secondClubName']}, {$score}'";
                                    $curClubCity = $match['fieldCity'];
                                    $matchDate = "{$match['date']}.{$match['year']}";
                                } else { // и если нет, то
                                    // $hintRecord = ''; // ставим пустую всплывающую подсказку
                                    $hintRecord = " title = '{$groupInfo[$ri][0]} - {$groupInfo[$index][0]}'";
                                    // Определяем город проведения будущего матча:
                                    $curClub = getClubByName($groupInfo[$ri][0], $clubs);
                                    $curClubCity = $curClub['city'];
                                    // "Рыба" даты проведения будущего матча:
                                    $matchDate = '02.11.2022';
                                    // $matchDate = $exampleFutureMatchdate;
                                }

                                $ifNeutral = '';
                                if ($match['home'] === 'neutral') {
                                    $ifNeutral = ", {$match['fieldCountry']}";
                                }                                

                                if ($index === $ri) {
                                    echo
                                    "<td>
                                        <img class='football-logo-table {$logo[1]}' src='../../images/{$logo[0]}' alt='{$groupInfo[$ri][0]}' title='{$logo[2]}'>
                                    </td>";
                                }
                                else {
                                    echo
                                    "<td class='match-cell'{$hintRecord}>
                                        <div class='group_score'>{$score}</div>
                                        <div class='group_field-data'>
                                            <div class='group_field'>{$curClubCity}{$ifNeutral}</div>
                                            <div class='group_data'>{$matchDate}</div>
                                        </div>
                                    </td>";
                                }
                            }
                                echo
                                "<td class='gap'></td>

                                <td>{$groupInfo[$ri][1]}</td>

                                <td>{$groupInfo[$ri][2]}</td>
                                
                                <td>{$groupInfo[$ri][3]}</td>

                                <td class='balls-cell'>{$groupInfo[$ri][4]} - {$groupInfo[$ri][5]}</td> 

                                <td>{$groupInfo[$ri][6]}</td>";
                            echo                     
                        "</tr>";
                    }
                        
            echo                       
                    "</tbody>
                </table>
            </div>";
        }

        // Дополняем наш массив упорядоченных клубов: 
            // В зависимости от года розыгрыша - от наличия полуфиналов в розыгрыше -
            // перебираем группы, начиная либо со второй, либо с третьей команды:
        if (($tourneyYear <= 1993) || ($tourneyYear == 1998) || ($tourneyYear == 1999)) {
            $ind = 1;
        } else if ($tourneyYear >= 1994) {
            $ind = 2;
            // $ind = 0; // UPD. Можно перебирать и полностью, начиная с нулевого индекса.
        }
            // echo '<pre>';
            // print_r ( $ind );        
        for (; $ind < count($groupInfo); $ind++) {
            $currentClub =  getClubByName($groupInfo[$ind][0], $clubs);
            if ( ! (in_array($currentClub, $orderedClubs)) ) {
                $orderedClubs[] = getClubByName($groupInfo[$ind][0], $clubs);
            }
            // echo '<pre>';
            // print_r ( $groupInfo[$ind][0] );
        }

        $num++;

    }

    echo 
        "</div>
    </div>";
    // echo '<pre>';
    // print_r ( array_merge($orderedClubs, $newOrderedClubs) );
    // echo '<br>';
    
    return $orderedClubs;

}
