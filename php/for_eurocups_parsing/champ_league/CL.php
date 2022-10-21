<!DOCTYPE html>
<!DOCTYPE html>
<html lang="ru" class="football">

<?php
// Получаем массив МАТЧЕЙ турнира:
require_once '../../../database/config/config.php';
require_once '../../../database/config/connect.php';
$conn = connect();
$sql = "SELECT * FROM `matches` WHERE tourneyTitle = 'Лига чемпионов' AND tourneyFinalYear = {$_GET['year']}";
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

$tourStartYear = $_GET['year'] - 1;
$tourFinalYear = $_GET['year'];

// Печатаем head:
echo 
"\n\n<head>
    <meta charset='utf-8'>
    <meta name='author' content='Edwards, Allegro, Edwards75, Allegro75, Oleg Otkidach'>
    <meta name='author' content='Олег Откидач'>
    <meta name='description' content='Лига чемпионов {$tourStartYear}/{$tourFinalYear}'>
    <meta name='keywords' content='Лига чемпионов. {$tourFinalYear}.{$tourStartYear}. 
    Футбол. Еврокубки. Европа. 
    Статистика. История. Результаты.    
    Лига чемпионов. Кубок чемпионов. Кубок кубков. Лига Европы. Кубок УЕФА. Суперкубок.'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='shortcut icon' href='../../images/football_ball.svg' type='image/x-icon'>
    <title>Лига чемпионов {$tourStartYear}/{$tourFinalYear}</title>
    <link rel='stylesheet' href='../../stylesheets/football__body.css'>
    <link rel='stylesheet' href='../../stylesheets/cap-wo-nav.css'>
    <link rel='stylesheet' href='../../stylesheets/navigation.css'>
    <link rel='stylesheet' href='../../stylesheets/nav-in-tourney.css'>
    <link rel='stylesheet' href='../../stylesheets/captions.css'>
    <link rel='stylesheet' href='../../stylesheets/tourneys.css'>
    <link rel='stylesheet' href='../../stylesheets/donate.css'>
    <link rel='stylesheet' href='../../stylesheets/footer.css'>
</head>

<body class='football__body'>
    <div class='football__background'>\n";

// Печатаем шапку:
require_once('../cup_win_cup/templates/header.php');    
?>

        <main>

            <!-- Заголовок -->
            <section class="captions">
                <h1 class="captions__h1">
                    Лига ЧЕМПИОНОВ
                        <?php
                        echo "{$tourStartYear}/{$tourFinalYear}";
                        ?>
                </h1>
            </section>

            <!-- Турнир -->
            <div class="tourney">

                <?php

                require_once('functions.php');
                $imagesList = scandir('../../images');
                $orderedClubs = [];

                if ( getStageMatches($matches, 'Финал') ) { // Разбираемся с ФИНАЛОМ:
                    
                    // Определяем финальный матч(и):                
                    $finalMatches = getStageMatches($matches, 'Финал');
                    // echo '<pre>';
                    // print_r($finalMatches);

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
                    // $orderedClubs = [];
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


                        //Если матчей в ФИНАЛЕ ДВА:
                        if (count($finalMatches) === 2) {
                        // Определяем счёт ВТОРОГО финального матча: 
                        $firstGoals = $finalMatches[1]["firstClubGoals"];
                        $secondGoals = $finalMatches[1]["secondClubGoals"];

                        // Определяем место ВТОРОГО финального матча: 
                        $finCity = $finalMatches[1]["fieldCity"];
                        $finCountry = $finalMatches[1]["fieldCountry"];

                        // Определяем дату ВТОРОГО финального матча: 
                        $finDate = $finalMatches[1]["date"];
                        $finYear = $finalMatches[1]["year"];
                        echo 
                        "<div class='stage-content__row content-row content-row_row-1'>

                            <div class='club-info club-info_1'>
                            </div>

                            <div class='score'>
                                {$firstGoals} : {$secondGoals}
                            </div>

                            <div class='club-info club-info_2'>  
                            </div>  

                        </div>

                        <div class='stage-content__row content-row content-row_row-2'>
                            {$penalty2}
                            <div class='field'>
                                {$finCity}, {$finCountry}
                            </div>    
                            <div class='date'>
                                {$finDate}.{$finYear}
                            </div>                                            
                        </div>";                    
                        }

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
                
                if ($tourFinalYear >= 2004) {
                    // Пишем следующую стадию и дополняем массив клубов:
                    if ( getStageMatches($matches, '1/8 финала') ) {
                        $orderedClubs = writeMatchesByStage('1/8 финала', $matches, $orderedClubs, $clubs, $imagesList);
                    }
                    // Пишем следующую стадию и дополняем массив клубов:
                    if (true) { // Пишем текущий турнир ЛЧ 2022/2023. Т.к. турнир не закончен, формируем массив $orderedClubs 'искуственно'               
                        $orderedClubs = 
                        [
                            getClubByName('Наполи', $clubs),
                            getClubByName('Брюгге', $clubs),
                            getClubByName('Бавария', $clubs),
                            getClubByName('Тоттенхэм Хотспур', $clubs),
                            getClubByName('Челси', $clubs),
                            getClubByName('Реал Мадрид', $clubs),
                            getClubByName('Манчестер Сити', $clubs),
                            getClubByName('Пари Сен-Жермен', $clubs),
                            getClubByName('Ливерпуль', $clubs),
                            getClubByName('Порто', $clubs),
                            getClubByName('Интер Милан', $clubs),
                            getClubByName('Олимпик Марсель', $clubs),
                            getClubByName('Зальцбург', $clubs),
                            getClubByName('РБ Лейпциг', $clubs),
                            getClubByName('Боруссия Дортмунд', $clubs),
                            getClubByName('Бенфика', $clubs),
                        ];
                    }
                    if ( getStageMatches($matches, 'группа') ) {
                        // echo '<pre>';
                        // var_dump(getStageMatches($matches, 'группа'));
                        // echo '</pre>';
                        $orderedClubs = writeGroupStage($orderedClubs, $matches, 'группа', $clubs, $imagesList, $tourFinalYear);
                    } 
                }
                else {
                    // Пишем следующую стадию и дополняем массив клубов:
                    if ( getStageMatches($matches, 'группа') ) {
                        $orderedClubs = writeGroupStage($orderedClubs, $matches, 'группа', $clubs, $imagesList, $tourFinalYear);
                    } 
                    // Пишем следующую стадию и дополняем массив клубов:
                    if ( getStageMatches($matches, '1/8 финала') ) {
                        $orderedClubs = writeMatchesByStage('1/8 финала', $matches, $orderedClubs, $clubs, $imagesList);
                    } 
                }
                
                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, '1/16 финала') ) {
                    $orderedClubs = writeMatchesByStage('1/16 финала', $matches, $orderedClubs, $clubs, $imagesList);
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
                if ( getStageMatches($matches, '3-й квалификационный раунд') ) {
                    $orderedClubs = writeMatchesByStage('3-й квалификационный раунд', $matches, $orderedClubs, $clubs, $imagesList);
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
                if ( getStageMatches($matches, 'Отборочный раунд') ) {
                    $orderedClubs = writeMatchesByStage('Отборочный раунд', $matches, $orderedClubs, $clubs, $imagesList);
                } 

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Предварительный раунд, финал') ) {
                    $orderedClubs = writeMatchesByStage('Предварительный раунд, финал', $matches, $orderedClubs, $clubs, $imagesList);
                }                 

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Предварительный раунд - Финал') ) {
                    $orderedClubs = writeMatchesByStage('Предварительный раунд - Финал', $matches, $orderedClubs, $clubs, $imagesList);
                }                 

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Предварительный раунд, 1/2 финала') ) {
                    $orderedClubs = writeMatchesByStage('Предварительный раунд, 1/2 финала', $matches, $orderedClubs, $clubs, $imagesList);
                }

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, 'Предварительный раунд - 1/2 финала') ) {
                    $orderedClubs = writeMatchesByStage('Предварительный раунд - 1/2 финала', $matches, $orderedClubs, $clubs, $imagesList);
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
require_once('../cup_win_cup/templates/donate.php');
require_once('../cup_win_cup/templates/footer.php');
?>

    </div>

    <script src="../../scripts/archive/arrowNav.js"></script>
    <script src="../../scripts/archive/changeLogoBrightness.js"></script>
    <script src="../../scripts/archive/toTopButton.js"></script>
    <!-- <script src="../../scripts/archive/service.js"></script> -->    

</body>

</html>