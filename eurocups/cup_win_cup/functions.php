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
        if ( (($arr[$i]['firstClubName'] === $club["basicFullName"]) || ($arr[$i]['secondClubName'] === $club["basicFullName"])) 
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
        if ($arr[$i]['timeStamp'] == $timeStamp) {
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
            $allTimeStamps[] = $pairMatches[$ind]['timeStamp'];
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
require_once('../../getFileList.php');
$imagesList = getFileList('../../images');
// echo "<pre>";
// print_r($imagesList);
function getImageAdress($club, $imagesList)
{
    $imageAdress = '';
    if ($code = $club['code']) {
        if (in_array("{$code}.png", $imagesList)) {
            $imageAdress = ["{$code}.png", '', ''];
        } else if (in_array("{$code}.svg", $imagesList)) {
            $imageAdress = ["{$code}.svg", '', ''];
        } else if (in_array("{$code}.jpg", $imagesList)) {
            $imageAdress = ["{$code}.jpg", '', ''];
        }
    } else {
        $imageAdress = ["flags/{$club['countryEngCode']}.png", 'img_flag', "{$club['country']}"];
    }
    return $imageAdress;
}

// ГЛАВНАЯ функция для ЗАПОЛНЕНИЯ СОДЕРЖАНИЯ стадии матчами:
function writeMatchesByStage($name, $matches, $orderedClubs, $clubs, $imagesList)
{
    $orderedStageMatches = orderMatchesInStage($name, $matches, $orderedClubs);

    // Дополняем упорядоченный массив клубов:
    $orderedClubs = addClubsToOrdered($orderedStageMatches, $orderedClubs, $clubs);

    echo
        "<div class='tourney__stage tour-stage'>
                        <div class='tour-stage_name'>
                            {$name}
                        </div>";

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
            } else if ($goals_2_1 > $goals_1_2) {
                $club1Classes = 'club-name club-name_winner';
                $club2Classes = 'club-name';
            } else if ($goals_1_2 > $goals_2_1) {
                $club1Classes = 'club-name';
                $club2Classes = 'club-name club-name_winner';
            } 
            // Если решали пенальти:
            else if ($orderedStageMatches[$i][1]['hadPenalties'] == 1) {
                if ($orderedStageMatches[$i][1]['penaltiesWinner'] === $orderedStageMatches[$i][1]['firstClubName']) {
                    $club1Classes = 'club-name';
                    $club2Classes = 'club-name club-name_winner';
                    $penalty2 = "<div class='penalty'>(победа по пенальти)</div>";
                } else {
                    $club1Classes = 'club-name club-name_winner';
                    $club2Classes = 'club-name';
                    $penalty2 = "<div class='penalty'>(поражение по пенальти)</div>";
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
                else {
                    $penalty2 = "<div class='penalty'>(доп. время)</div>";
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

        $out =
            "<div class='tour-stage__content stage-content'>

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
                            </div>                            

                        </div>";
        }
        echo $out;
    }
    echo "</div>";
    return $orderedClubs;
}
