<!DOCTYPE html>
<html lang="ru" class="football">

<?php
// 22.10.2022 решил писать Лигу Европы через файл champ_league/CL (изначально заточенный под ЛЧ).
$tourFinalYear = $_GET['year'];
$tourStartYear = $_GET['year'] - 1;
if ($tourFinalYear <= 1971) {
    $tourneyTitle = 'Кубок ярмарок';
} else if ($tourFinalYear <= 2009) {
    $tourneyTitle = 'Кубок УЕФА';
} else {
    $tourneyTitle = 'Лига Европы';
}


// Получаем массив МАТЧЕЙ турнира:
require_once '../../config.php';
require_once '../../connect.php';
$conn = connect();
$sql = "SELECT * FROM `eurocups_matches` WHERE tourneyTitle = '{$tourneyTitle}' AND tourneyFinalYear = {$_GET['year']}";
$result = mysqli_query($conn, $sql);
$matches = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $matches[] = $row;
    }
}
// echo '<pre>';
// print_r($matches);

// Получаем массив КЛУБОВ-участников турнира:
$clubNames = [];
for ($i = 0; $i < count($matches); $i++) {
    $clubNames[] = $matches[$i]["firstClubName"];
    $clubNames[] = $matches[$i]["secondClubName"];
}
$clubNames = array_unique($clubNames);
$clubs = [];
foreach ($clubNames as $value) {
    $sql = "SELECT * FROM `eurocups_clubs` WHERE basicFullName = '{$value}' OR altNames = '{$value}' OR altNames LIKE '{$value},%' OR altNames LIKE '%,{$value}' OR altNames LIKE '%,{$value},%'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $clubs[] = $row;
}
// echo '<pre>';
// print_r($clubs);

// Печатаем head:
echo 
"<head>
    <meta charset='utf-8'>
    <meta name='author' content='Edwards, Allegro, Edwards75, Allegro75, Oleg Otkidach'>
    <meta name='author' content='Олег Откидач'>
    <meta name='description' content='{$tourneyTitle} {$tourStartYear}/{$tourFinalYear}'>
    <meta name='keywords' content='{$tourneyTitle}. {$tourFinalYear}.{$tourStartYear}.
    Футбол. Еврокубки. Европа. 
    Статистика. История. Результаты.    
    Лига Европы. Кубок УЕФА. Кубок ярмарок. Лига чемпионов. Кубок чемпионов. Кубок кубков. Суперкубок.'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='shortcut icon' href='../../images/football_ball.svg' type='image/x-icon'>
    <title>{$tourneyTitle} {$tourStartYear}/{$tourFinalYear}</title>
    <link rel='stylesheet' href='../../stylesheets/football__body.css'>
    <link rel='stylesheet' href='../../stylesheets/cap-wo-nav.css'>
    <link rel='stylesheet' href='../../stylesheets/navigation.css'>
    <link rel='stylesheet' href='../../stylesheets/captions.css'>
    <link rel='stylesheet' href='../../stylesheets/tourneys.css'>
    <link rel='stylesheet' href='../../stylesheets/donate.css'>
    <link rel='stylesheet' href='../../stylesheets/footer.css'>
</head>

<body class='football__body'>
    <div class='football__background'>";

// Печатаем шапку:
require_once('../templates/header.php');    
?>

        <main>

            <!-- Заголовок -->
            <section class="captions">
                <h1 class="captions__h1">
                    <?php
                    echo "{$tourneyTitle} {$tourStartYear}/{$tourFinalYear}";
                    // echo "1958/{$tourFinalYear}";
                    ?>
                </h1>
            </section>

            <!-- Турнир -->
            <div class="tourney">

                <?php

                require_once('functions.php');

            // Разбираемся с ФИНАЛОМ:
                // Определяем финальный матч(и):                
                $finalMatches = getStageMatches($matches, 'Финал');
                // echo '<pre>';
                // print_r($finalMatches);

                $orderedClubs = [];

                // Если в финале ДВА матча:
                if (count($finalMatches) === 2) {

                    // Упорядочиваем финальные матчи:
                    $finalTimeStamps = [];
                    for ($ind = 0; $ind < count($finalMatches); $ind++) {
                        $finalTimeStamps[] = $finalMatches[$ind]['timeStamp'];
                    }
                    sort($finalTimeStamps);
                    $orderedPairMatches = [];
                    for ($index = 0; $index < count($finalTimeStamps); $index++) {
                        $orderedPairMatches[] = getMatchByTimeStamp($finalTimeStamps[$index], $finalMatches);
                    }
                    // echo '<pre>';
                    // print_r($orderedPairMatches);  

                    // Нужно начать заполнять массив $orderedClubs:
                    $firstFinalistName = $finalMatches[0]["firstClubName"];
                    $secFinalistName = $finalMatches[0]["secondClubName"];

                    $finalWinner = getDuelWinner($firstFinalistName, $secFinalistName, $finalMatches);
                    if ($finalWinner === $firstFinalistName) {
                        $finalLooser = $secFinalistName;
                    } else {
                        $finalLooser = $firstFinalistName;
                    }
                    // var_dump($finalWinner);
                    // print_r($finalLooser);

                        // Для формирования необязательного дива penalty:
                    $penalty2 = '';                   

                    // Если решали пенальти:
                    if ($orderedPairMatches[1]['hadPenalties'] == 1) {
                        if ($orderedPairMatches[1]['penaltiesWinner'] === $orderedPairMatches[1]['firstClubName']) {
                            $club1Classes = 'club-name';
                            $club2Classes = 'club-name club-name_winner';
                            $penalty2 = "<div class='penalty'>(победа по пенальти)</div>";
                            $finalWinner = $orderedPairMatches[1]['firstClubName'];
                            $finalLooser = $orderedPairMatches[1]["secondClubName"];
                        } else {
                            $club1Classes = 'club-name club-name_winner';
                            $club2Classes = 'club-name';
                            $penalty2 = "<div class='penalty'>(поражение по пенальти)</div>";
                            $finalWinner = $orderedPairMatches[1]["secondClubName"];
                            $finalLooser = $orderedPairMatches[1]['firstClubName'];
                        }
                    }                      

                    $orderedClubs[0] = getClubByName($finalWinner, $clubs);
                    $orderedClubs[1] = getClubByName($finalLooser, $clubs);

                    // А теперь ПИШЕМ финал:
                    $club1Name = $orderedPairMatches[0]["firstClubName"];
                    $club2Name = $orderedPairMatches[0]["secondClubName"];
                    $club1 = getClubByName($club1Name, $clubs);
                    $club2 = getClubByName($club2Name, $clubs);
                    $code1 = getImageAdress($club1, $imagesList);
                    $code2 = getImageAdress($club2, $imagesList);

                    if ($finalWinner === $club1Name) {
                        $club1Classes = 'club-name club-name_winner';
                        $club2Classes = 'club-name';
                    } else if ($finalWinner === $club2Name) {
                        $club1Classes = 'club-name';
                        $club2Classes = 'club-name club-name_winner';
                    } 

                    $goals_1_1 = $orderedPairMatches[0]["firstClubGoals"];
                    $goals_1_2 = $orderedPairMatches[0]["secondClubGoals"];
                    $goals_2_1 = $orderedPairMatches[1]["secondClubGoals"];
                    $goals_2_2 = $orderedPairMatches[1]["firstClubGoals"];

                    // Определяем МЕСТО и ВРЕМЯ матчей:
                    $field1 = $orderedPairMatches[0]['fieldCity'];
                    $field2 = $orderedPairMatches[1]['fieldCity'];
                    // $field3 = $orderedPairMatches[2]['fieldCity'];
                    $date1 = $orderedPairMatches[0]['date'];
                    if ($date1) {
                        $date1 = "{$date1}.";
                    }
                    $year1 = $orderedPairMatches[0]['year'];
                    $date2 = $orderedPairMatches[1]['date'];
                    if ($date2) {
                        $date2 = "{$date2}.";
                    }
                    $year2 = $orderedPairMatches[1]['year']; 
                    
                    // Про ДОПОЛНИТЕЛЬНОЕ время:
                    $addTime2 = '';                    
                    if ($orderedPairMatches[1]["hadEfficientAddTime"]) {
                        $addTime2 = "доп. время";
                    }

                    if ($addTime2 === "доп. время") {
                        $penalty2 = "<div class='penalty'>(доп. время)</div>"; 
                    } 

                    echo
                    "<div class='tourney__stage tour-stage stage_final final-2matches'>
                        <div class='tour-stage_name'>
                            ФИНАЛ
                        </div>";

                    $out =
                        "<div class='tour-stage__content stage-content'>

                                        <div class='stage-content__row content-row content-row_row-1 content-row_2-matches'>
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

                                        <div class='stage-content__row content-row content-row_row-2 content-row_2-matches'>
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

                        echo $out;
                    echo 
                    "</div>
                </div>";                                        
                }

                // Если же в финале ОДИН МАТЧ:
                else if (count($finalMatches) === 1) {
                    // Определяем счёт финального матча: 
                    $firstGoals = $finalMatches[0]["firstClubGoals"];
                    $secondGoals = $finalMatches[0]["secondClubGoals"]; 
                    
                    $winClass_1 = '';
                    $winClass_2 = '';

                    // Определяем ПОБЕДИТЕЛЯ финального матча:
                    if ($secondGoals > $firstGoals) {
                        $winClass_2 = ' club-name_winner';
                    }
                    else if ($secondGoals < $firstGoals) {
                        $winClass_1 = ' club-name_winner';
                    } 

                    // Разбираемся с доп. временем и ПЕНАЛЬТИ:
                    $add = '';
                    $penalty = '';
                    if ($finalMatches[0]["hadEfficientAddTime"]) {
                        if ($finalMatches[0]['hadPenalties']) {
                            if ($finalMatches[0]['penaltiesWinner'] == $finalMatches[0]['firstClubName']) {
                                $penalty = "<div class='penalty'>(доп. время, победа по пенальти)</div>";
                                $winClass_1 = ' club-name_winner';  
                            }
                            else if ($finalMatches[0]['penaltiesWinner'] == $finalMatches[0]['secondClubName']) {
                                $penalty = "<div class='penalty'>(доп. время, поражение по пенальти)</div>";
                                $winClass_2 = ' club-name_winner';  
                            }
                        }
                        else {
                            $penalty = "<div class='penalty'>(доп. время)</div>";
                        }
                    } else if ($finalMatches[0]['hadPenalties']) {
                        if ($finalMatches[0]['penaltiesWinner'] == $finalMatches[0]['firstClubName']) {
                            $penalty = "<div class='penalty'>(победа по пенальти)</div>";
                            $winClass_1 = ' club-name_winner';  
                        }
                        else if ($finalMatches[0]['penaltiesWinner'] == $finalMatches[0]['secondClubName']) {
                            $penalty = "<div class='penalty'>(поражение по пенальти)</div>";
                            $winClass_2 = ' club-name_winner';  
                        }
                    }                

                    if (count($finalMatches) == 2) {
                        if ($finalMatches[0]['timeStamp'] > $finalMatches[1]['timeStamp']) {
                            $finalMatches = array_reverse($finalMatches);
                        }
                    }

                    // Определяем коды участников финального матча:
                    $club1Name = $finalMatches[0]["firstClubName"];
                    $club2Name = $finalMatches[0]["secondClubName"];
                    $club1 = getClubByName($club1Name, $clubs);
                    $club2 = getClubByName($club2Name, $clubs);
                    $code1 = getImageAdress($club1, $imagesList);
                    $code2 = getImageAdress($club2, $imagesList);

                    // Определяем место финального матча: 
                    $finCity = $finalMatches[0]["fieldCity"];
                    $finCountry = $finalMatches[0]["fieldCountry"];

                    // Определяем дату финального матча: 
                    $finDate = $finalMatches[0]["date"];
                    $finYear = $finalMatches[0]["year"];

                    // Про ДОП. МАТЧ:
                    if ($finalMatches[1]["comments"] === 'доп. матч') {
                        $penalty2 = "<div class='penalty'>(доп. матч)</div>"; 
                    }

                    // Начинаем упорядочивать массив с клубами:
                    $orderedClubs = [];
                    if ($winClass_1 === ' club-name_winner') {
                        $orderedClubs[0] = $club1;
                        $orderedClubs[1] = $club2;
                    } else {
                        $orderedClubs[0] = $club2;
                        $orderedClubs[1] = $club1; 
                    }

                    // Печатаем ФИНАЛ:
                    echo
                        "<div class='tourney__stage tour-stage stage_final'>

                            <div class='tour-stage_name'>ФИНАЛ</div>

                            <div class='tour-stage__content stage-content'>

                                <div class='stage-content__row content-row content-row_row-1'>

                                    <div class='club-info club-info_1'>
                                        <div class='logo logo-left'>
                                            <img src='../../images/{$code1[0]}' alt='{$club1Name}' class='{$code1[1]}' title='{$code1[2]}'>
                                        </div>
                                        <div class='club-name{$winClass_1}'>
                                            {$club1Name}
                                        </div>
                                    </div>

                                    <div class='score'>
                                        {$firstGoals} : {$secondGoals}
                                    </div>

                                    <div class='club-info club-info_2'>
                                        <div class='club-name{$winClass_2}'>
                                            {$club2Name}
                                        </div> 
                                        <div class='logo logo-right'>
                                            <img src='../../images/{$code2[0]}' alt='{$club2Name}' class='{$code2[1]}' title='{$code2[2]}'>
                                        </div>  
                                    </div>  

                                </div>

                                <div class='stage-content__row content-row content-row_row-2'>
                                    {$penalty}
                                    <div class='field'>
                                        {$finCity}, {$finCountry}
                                    </div>    
                                    <div class='date'>
                                        {$finDate}.{$finYear}
                                    </div>                                            
                                </div>";

                        // Нижеследующее (про два матча в финале) пришло из кубка чемпионов:
                        // Если матчей в ФИНАЛЕ ДВА:
                        // if (count($finalMatches) === 2) {
                        // // Определяем счёт ВТОРОГО финального матча: 
                        // $firstGoals = $finalMatches[1]["firstClubGoals"];
                        // $secondGoals = $finalMatches[1]["secondClubGoals"];

                        // // Определяем место ВТОРОГО финального матча: 
                        // $finCity = $finalMatches[1]["fieldCity"];
                        // $finCountry = $finalMatches[1]["fieldCountry"];

                        // // Определяем дату ВТОРОГО финального матча: 
                        // $finDate = $finalMatches[1]["date"];
                        // $finYear = $finalMatches[1]["year"];
                        // echo 
                        // "<div class='stage-content__row content-row content-row_row-1'>

                        //     <div class='club-info club-info_1'>
                        //     </div>

                        //     <div class='score'>
                        //         {$firstGoals} : {$secondGoals}
                        //     </div>

                        //     <div class='club-info club-info_2'>  
                        //     </div>  

                        // </div>

                        // <div class='stage-content__row content-row content-row_row-2'>
                        //     {$penalty2}
                        //     <div class='field'>
                        //         {$finCity}, {$finCountry}
                        //     </div>    
                        //     <div class='date'>
                        //         {$finDate}.{$finYear}
                        //     </div>                                            
                        // </div>";                    
                        // }

                    echo
                        "</div>

                    </div>";

                }

                // echo '<pre>';
                // print_r($orderedClubs);

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, '1/2 финала') ) {
                    $orderedClubs = writeMatchesByStage('1/2 финала', $matches, $orderedClubs, $clubs, $imagesList);
                }

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, '1/4 финала') ) {
                    $orderedClubs = writeMatchesByStage('1/4 финала', $matches, $orderedClubs, $clubs, $imagesList);
                } 

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'группа2') ) {
                    $orderedClubs = writeGroupStage($orderedClubs, $matches, 'группа2', $clubs, $imagesList, $tourFinalYear);
                }
                // echo '<pre>';
                // print_r($orderedClubs);    
                
                // echo '<pre>';
                // print_r(getStageMatches($matches, '1/8 финала'));    
                // print_r(mktime(0, 0, 0, 12, 24, 1961)); 
                
                // if ($tourFinalYear >= 2004) {
                    // Пишем следующую стадию и дополняем массив клубов:
                    if ( getStageMatches($matches, '1/8 финала') ) {
                        $orderedClubs = writeMatchesByStage('1/8 финала', $matches, $orderedClubs, $clubs, $imagesList);
                    }
                    // Пишем следующую стадию и дополняем массив клубов:
                    // if ( getStageMatches($matches, 'группа') ) {
                    //     $orderedClubs = writeGroupStage($orderedClubs, $matches, 'группа', $clubs, $imagesList, $tourFinalYear);
                    // } 
                // }
                // else {
                //     // Пишем следующую стадию и дополняем массив клубов:
                //     if ( getStageMatches($matches, 'группа') ) {
                //         $orderedClubs = writeGroupStage($orderedClubs, $matches, 'группа', $clubs, $imagesList, $tourFinalYear);
                //     } 
                //     // Пишем следующую стадию и дополняем массив клубов:
                //     if ( getStageMatches($matches, '1/8 финала') ) {
                //         $orderedClubs = writeMatchesByStage('1/8 финала', $matches, $orderedClubs, $clubs, $imagesList);
                //     } 
                // }
                
                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, '1/16 финала') ) {
                    $orderedClubs = writeMatchesByStage('1/16 финала', $matches, $orderedClubs, $clubs, $imagesList);
                }

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'группа') ) {
                    $orderedClubs = writeGroupStage($orderedClubs, $matches, 'группа', $clubs, $imagesList, $tourFinalYear);
                }                 

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, '1/32 финала') ) {
                    $orderedClubs = writeMatchesByStage('1/32 финала', $matches, $orderedClubs, $clubs, $imagesList);
                }        
                
                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, '1/64 финала') ) {
                    $orderedClubs = writeMatchesByStage('1/64 финала', $matches, $orderedClubs, $clubs, $imagesList);
                }                 

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Раунд плей-офф') ) {
                    $orderedClubs = writeMatchesByStage('Раунд плей-офф', $matches, $orderedClubs, $clubs, $imagesList);
                }                

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Первый раунд') ) {
                    $orderedClubs = writeMatchesByStage('Первый раунд', $matches, $orderedClubs, $clubs, $imagesList);
                }

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Третий отборочный раунд') ) {
                    $orderedClubs = writeMatchesByStage('Третий отборочный раунд', $matches, $orderedClubs, $clubs, $imagesList);
                }        
                
                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Третий квалификационный раунд') ) {
                    $orderedClubs = writeMatchesByStage('Третий квалификационный раунд', $matches, $orderedClubs, $clubs, $imagesList);
                }                 

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Второй отборочный раунд') ) {
                    $orderedClubs = writeMatchesByStage('Второй отборочный раунд', $matches, $orderedClubs, $clubs, $imagesList);
                }  

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Второй квалификационный раунд') ) {
                    $orderedClubs = writeMatchesByStage('Второй квалификационный раунд', $matches, $orderedClubs, $clubs, $imagesList);
                }      
                
                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, '2-й квалификационный раунд') ) {
                    $orderedClubs = writeMatchesByStage('2-й квалификационный раунд', $matches, $orderedClubs, $clubs, $imagesList);
                }                 
                
                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Первый отборочный раунд') ) {
                    $orderedClubs = writeMatchesByStage('Первый отборочный раунд', $matches, $orderedClubs, $clubs, $imagesList);
                }         
                
                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Первый квалификационный раунд') ) {
                    $orderedClubs = writeMatchesByStage('Первый квалификационный раунд', $matches, $orderedClubs, $clubs, $imagesList);
                }    

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, '1-й квалификационный раунд') ) {
                    $orderedClubs = writeMatchesByStage('1-й квалификационный раунд', $matches, $orderedClubs, $clubs, $imagesList);
                }                  
                
                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Квалификационный раунд') ) {
                    $orderedClubs = writeMatchesByStage('Квалификационный раунд', $matches, $orderedClubs, $clubs, $imagesList);
                }                 
                
                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Отборочный раунд') ) {
                    $orderedClubs = writeMatchesByStage('Отборочный раунд', $matches, $orderedClubs, $clubs, $imagesList);
                } 

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Предварительный раунд, финал') ) {
                    $orderedClubs = writeMatchesByStage('Предварительный раунд, финал', $matches, $orderedClubs, $clubs, $imagesList);
                }                 

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Предварительный раунд, 1/2 финала') ) {
                    $orderedClubs = writeMatchesByStage('Предварительный раунд, 1/2 финала', $matches, $orderedClubs, $clubs, $imagesList);
                }                 

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Предварительный раунд') ) {
                    $orderedClubs = writeMatchesByStage('Предварительный раунд', $matches, $orderedClubs, $clubs, $imagesList);
                }                
                // echo '<pre>';
                // print_r($orderedClubs);

                ?>

        </main>

<?php
require_once('../templates/donate.php');
require_once('../templates/footer.php');
?>

    </div>

</body>

</html>