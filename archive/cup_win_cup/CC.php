<!DOCTYPE html>
<!DOCTYPE html>
<html lang="ru" class="football">

<?php
// Получаем массив МАТЧЕЙ турнира:
require_once '../../config.php';
require_once '../../connect.php';
$conn = connect();
$sql = "SELECT * FROM `eurocups_matches` WHERE tourneyTitle = 'Кубок кубков' AND tourneyFinalYear = {$_GET['year']}";
$result = mysqli_query($conn, $sql);
$matches = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $matches[] = $row;
    }
}
// echo '<pre>';
// print_r($matches[47]);
// var_dump($matches[47]['hadToss'] == 1);
// echo '</pre>';

// Получаем массив КЛУБОВ-участников турнира:
$clubNames = [];
for ($i = 0; $i < count($matches); $i++) {
    $clubNames[] = $matches[$i]["firstClubName"];
    $clubNames[] = $matches[$i]["secondClubName"];
}
$clubNames = array_unique($clubNames);
$clubs = [];
foreach ($clubNames as $value) {
    $sql = "SELECT * FROM `eurocups_clubs` WHERE basicFullName = '{$value}' OR altNames = '{$value}' OR altNames LIKE '{$value},%' OR altNames LIKE '%, {$value}' OR altNames LIKE '%, {$value},%'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $clubs[] = $row;
}
// echo '<pre>';
// print_r(count($clubs));

$tourStartYear = $_GET['year'] - 1;
$tourFinalYear = $_GET['year'];

// Печатаем head:
echo 
"<head>
    <meta charset='utf-8'>
    <meta name='author' content='Edwards, Allegro, Edwards75, Allegro75, Oleg Otkidach'>
    <meta name='author' content='Олег Откидач'>
    <meta name='description' content='Кубок обладателей кубков {$tourStartYear}/{$tourFinalYear}'>
    <meta name='keywords' content='Кубок кубков. {$tourStartYear}. {$tourFinalYear}.
    Футбол. Еврокубки. Европа. 
    Статистика. История. Результаты.    
    Лига чемпионов. Кубок чемпионов. Лига Европы. Кубок УЕФА. Суперкубок.'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='shortcut icon' href='../../images/football_ball.svg' type='image/x-icon'>
    <title>Кубок кубков {$tourStartYear}/{$tourFinalYear}</title>
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
require_once('templates/header.php');    
?>

        <main>

            <!-- Заголовок -->
            <section class="captions">
                <h1 class="captions__h1">
                    КУБОК обладателей КУБКОВ
                        <?php
                        echo "{$tourStartYear}/{$tourFinalYear}";
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

                // Определяем коды участников финального матча:
                $club1Name = $finalMatches[0]["firstClubName"];
                $club2Name = $finalMatches[0]["secondClubName"];
                $club1 = getClubByName($club1Name, $clubs);
                $club2 = getClubByName($club2Name, $clubs);
                $code1 = getImageAdress($club1, $imagesList);
                $code2 = getImageAdress($club2, $imagesList);

                // Определяем счёт финального матча: 
                $firstGoals = $finalMatches[0]["firstClubGoals"];
                $secondGoals = $finalMatches[0]["secondClubGoals"];

                // Определяем место финального матча: 
                $finCity = $finalMatches[0]["fieldCity"];
                $finCountry = $finalMatches[0]["fieldCountry"];

                // Определяем дату финального матча: 
                $finDate = $finalMatches[0]["date"];
                $finYear = $finalMatches[0]["year"];

                // Разбираемся с доп. временем и ПЕНАЛЬТИ:
                $add = '';
                $penalty = '';
                $lastMatchIndex = count($finalMatches) - 1;
                if ($finalMatches[$lastMatchIndex]["hadEfficientAddTime"]) {
                    if ($finalMatches[$lastMatchIndex]['hadPenalties']) {
                        $penalty = "<div class='penalty'>(доп. время, победа по пенальти)</div>";   
                    }
                    else {
                        $penalty = "<div class='penalty'>(доп. время)</div>";
                    }
                } else if ($finalMatches[$lastMatchIndex]['hadPenalties']) {
                    $penalty = "<div class='penalty'>(победа по пенальти)</div>";
                }
                if ($finalMatches[$lastMatchIndex]["comments"] === 'доп. матч') {
                    $penalty2 = "<div class='penalty'>(доп. матч)</div>"; 
                }

                // Начинаем упорядочивать массив с клубами:
                $orderedClubs = [];
                $orderedClubs[0] = $club1;
                $orderedClubs[1] = $club2;

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
                                <div class='club-name club-name_winner'>
                                    {$club1Name}
                                </div>
                            </div>

                            <div class='score'>
                                {$firstGoals} : {$secondGoals}
                            </div>

                            <div class='club-info club-info_2'>
                                <div class='club-name'>
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

                // Пишем следующую стадию и дополняем массив клубов:
                $orderedClubs = writeMatchesByStage('1/2 финала', $matches, $orderedClubs, $clubs, $imagesList);

                // Пишем следующую стадию и дополняем массив клубов:
                $orderedClubs = writeMatchesByStage('1/4 финала', $matches, $orderedClubs, $clubs, $imagesList);

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, '1/8 финала') ) {
                    $orderedClubs = writeMatchesByStage('1/8 финала', $matches, $orderedClubs, $clubs, $imagesList);
                }

                // Пишем следующую стадию и дополняем массив клубов:
                if ( getStageMatches($matches, '1/16 финала') ) {
                    $orderedClubs = writeMatchesByStage('1/16 финала', $matches, $orderedClubs, $clubs, $imagesList);
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
require_once('templates/donate.php');
require_once('templates/footer.php');
?>

    </div>

</body>

</html>