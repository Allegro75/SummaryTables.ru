
<?

    // Файл, генерирующий страницу "Ранжир".

    { // Переменные, нуждающиеся в определении перед генерацией страницы.

        // $lastAccountedMatchDate = "03.11.2022";
        $tourneyStartYear = 2022;
        $tourneyEndYear = 2023;

    }

?>

<!DOCTYPE html>
<html lang="ru" class="football">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Edwards, Allegro, Edwards75, Allegro75, Oleg Otkidach">
    <meta name="author" content="Олег Откидач">
    <meta name="description" content="Список 100 лучших клубов в истории
    в соответствии с их достижениями в еврокубках">
    <meta name="keywords" content="Футбол. Еврокубки. Европа. 
        Статистика. История. Результаты. 
        Клубы. Суперклубы. Команды. Список. 
        Реал. Барселона. Ливерпуль. Манчестер Юнайтед. Арсенал. Бавария. Ювентус. Аякс.
        Лига чемпионов. Кубок чемпионов. Лига Европы. Кубок УЕФА. Кубок кубков. Суперкубок.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/football_ball.svg" type="image/x-icon">
    <title>Ранжир. Лучшие клубы в истории. Сводная таблица</title>
    <link rel="stylesheet" href="stylesheets/football__body.css">
    <link rel="stylesheet" href="stylesheets/cap-wo-nav.css">
    <link rel="stylesheet" href="stylesheets/navigation.css">
    <link rel="stylesheet" href="stylesheets/captions.css">
    <link rel="stylesheet" href="stylesheets/table-range.css">
    <link rel="stylesheet" href="stylesheets/donate.css">
    <link rel="stylesheet" href="stylesheets/footer.css">
</head>

<body class="football__body">

    <div class="football__background">

        <? require_once 'layoutElements/header/shortHeader.php'; // Шапка, две оранжевые полосы с навигацией ?>

        <main>

            <!-- Заголовки -->
            <section class="captions">

                <h1 class="captions__h1 captions__h1_range">
                    ЛУЧШИЕ КЛУБЫ ЕВРОПЫ ЗА ВСЮ ИСТОРИЮ
                </h1>

                <p class="captions__explanation">
                    <span class="captions__explanation_circle">&#8226;</span>
                    <span class="captions__explanation_larger">100</span> лучших клубов
                    <span class="captions__explanation_circle">&#8226;</span>
                </p>

                <p class="captions__explanation">
                    <span class="captions__explanation_circle">&#8226;</span>
                    Клубы ранжировались по следующей системе:
                    <br>
                    за победу в Лиге чемпионов с 2000-го года - 12 очков; за выход в финал - 9; выход в 1/2 финала - 6; выход в 1/4 финала - 3;
                    <br>
                    за победу в кубке/Лиге чемпионов до 2000-го года - 8 очков; за выход в финал - 6; выход в 1/2 финала - 4; выход в 1/4 финала - 2;
                    <br>
                    за победу в других еврокубках - 4 очка; за выход в финал - 3; выход в 1/2 финала - 2; выход в 1/4 финала - 1
                    <span class="captions__explanation_circle">&#8226;</span>
                </p>

                <p class="captions__explanation">
                    <span class="captions__explanation_circle">&#8226;</span>
                    <!-- Таблица обновлена по итогам сезона 2022/2023 -->
                    Таблица обновлена по итогам групповых турниров сезона <?=$tourneyStartYear?>/<?=$tourneyEndYear?>
                    <!-- Таблица обновлена по итогам четвертьфиналов сезона 2022/2023 -->
                    <!-- Таблица обновлена по итогам полуфиналов сезона 2022/2023 -->
                    <!-- Таблица обновлена по итогам матчей от 14.04.2022 -->
                    <!-- В таблице учтены результаты до 18.05.2021 включительно (финал лиги Европы учтён) -->
                    <span class="captions__explanation_circle">&#8226;</span>
                </p>

            </section>

            <? // Данные для таблиц:       

                require_once 'rangeInfo.php'; // Получение содержания таблицы
                $rangeInfo = getRangeInfo();

                // echo "<pre>";
                // // var_dump(array_keys($rangeInfo));
                // var_dump($rangeInfo["range"]);
                // // var_dump($rangeInfo["clubsList"]);
                // // var_dump($rangeInfo["achieves"]);
                // echo "</pre>";

                $achievesArrIndexes = array_keys($rangeInfo["achieves"]);

                $achievesStages = [
                    "wins" => [
                        "rusStageWord" => "победа",
                        "popupStageWord" => "победы",
                        "methodToGetCorrForm" => "getWordLikeVictory",
                    ],
                    "finals" => [
                        "rusStageWord" => "финал",
                        "popupStageWord" => "выходы в финал",
                        "methodToGetCorrForm" => "getWordLikeFinal",
                    ],
                    "semiFinals" => [
                        "rusStageWord" => "полуфинал",
                        "popupStageWord" => "выходы в полуфинал",
                        "methodToGetCorrForm" => "getWordLikeFinal",
                    ],
                    "qurterFinals" => [
                        "rusStageWord" => "четвертьфинал",
                        "popupStageWord" => "выходы в четвертьфинал",
                        "methodToGetCorrForm" => "getWordLikeFinal",
                    ],
                ];    

                $tourTypesInfo = [
                    "cl" => [
                        "wins" => [
                            "correctTourneyForm" => "в кубке чемпионов",
                        ],
                        "other" => [
                            "correctTourneyForm" => "кубка чемпионов",
                        ],
                        "popup" => [
                            "correctTourneyForm" => "в кубке/лиге чемпионов",
                        ],
                    ],
                    "el" => [
                        "wins" => [
                            "correctTourneyForm" => "в еврокубках",
                        ],
                        "other" => [
                            "correctTourneyForm" => "еврокубков",
                        ],
                        "popup" => [
                            "correctTourneyForm" => "в еврокубках",
                        ],                        
                    ],
                ];    

                require_once 'classes/ClubsInfo.php';
                $clubsInfoClass = new ClubsInfo(["pathToRoot" => "../../"]);
                $currentSeasonClubsInfo = $clubsInfoClass->getСurrentSeasonClubsInfo(["tourneyEndYear" => $tourneyEndYear,]); // Получение данных о клубах, продолжающих участие в текущем сезоне розыгрыша еврокубков

                // echo "<pre>";
                // var_dump($currentSeasonClubsInfo);
                // echo "</pre>";

                { // Логотипы

                    // Массив имён файлов с логотипами (нужен чтобы правильно добавлять к коду клуба ".png", ".svg" и т.п.)
                    $logoFiles = scandir("images");                    
                    $specialImages = [
                        "Akt" => "Akt_light.png",
                        "AuW" => "AuW_light.png",
                        "DuP" => "DuP_light.png",
                        "DyK" => "DyK_dark.png",
                        // "Mar" => "Mar_light.png",
                        "Mlm" => "Mlm_light.png",
                        "Nan" => "Nan_light.png",
                        "New" => "New_light.png",
                        // "Not" => "Not_light.png",
                        "Not" => "Not_dark.png",
                        "Prt" => "Prt_light.png",
                        "SpL" => "SpL_light.png",
                        "StL" => "StL_light.png",
                        "Zen" => "Zen_light.png",
                    ];

                    // $logotypesInfo = ['clubsList' => [], 'actualCountryClubsList' => []];
                    // Имя файла с картинкой логотипа:                    

                    foreach ($rangeInfo["clubsList"] as $curClubName => $curClubInfo) {

                                $logoImageFile = "";
                                $clubCode = $curClubInfo['code'];
                                $clubCSSClass = $curClubInfo['CSSClass'];
                                $clubCssClassHtmlRecord = ($clubCSSClass === "") ? "" : " {$clubCSSClass}";
                                if (in_array($clubCode, array_keys($specialImages))) {
                                    $logoImageFile = $specialImages[$clubCode];
                                } else {        
                                    if (in_array("{$clubCode}.png", $logoFiles)) {
                                        $logoImageFile = "{$clubCode}.png";
                                    } elseif (in_array("{$clubCode}.svg", $logoFiles)) {
                                        $logoImageFile = "{$clubCode}.svg";
                                    } elseif (in_array("{$clubCode}.jpg", $logoFiles)) {
                                        $logoImageFile = "{$clubCode}.jpg";
                                    }
                                }
                                $clubId = $curClubInfo['id'];
                                // $logotypesInfo[$curClubName]["logoImageFile"] = $logoImageFile;
                                // $logotypesInfo[$curClubName]["clubCssClassHtmlRecord"] = $clubCssClassHtmlRecord;
                                $logotypesInfo[$clubId]["logoImageFile"] = $logoImageFile;
                                $logotypesInfo[$clubId]["clubCssClassHtmlRecord"] = $clubCssClassHtmlRecord;

                    }

                    // echo "<pre>";
                    // var_dump($logotypesInfo);
                    // echo "</pre>";

                }
                
                $tooLongNames = ["Вулверхэмптон","Данди Юнайтед","Кайзерслаутерн","Ференцварош","Панатинаикос","Црвена звезда",];

                require_once 'classes/WordForms.php'; // Файл для получения правильных форм слов

            ?>

            <!-- Таблицы (4 таблицы по 25 строк в каждой): -->
            <div class="tables">
                
                <? for($tableNumber = 1; $tableNumber <= 4; $tableNumber++): ?>

                    <table class="main-table range range_<?=$tableNumber?>">
                        <tbody>

                        <tr class="main-table__header">
                            <td colspan="3"></td>
                            <td class="main-table_gap"></td>
                            <td class="main-table_victory">
                                <img src="images/ChampCup_h20_990000.png" alt="Лига чемпионов" title="Победы в кубке чемпионов
Вознаграждаются 12 или 8 очками">
                            </td>
                            <td class="main-table_playoff playoff_final" title="Выходы в финал кубка чемпионов
Вознаграждаются 9 или 6 очками">Ф</td>
                            <td class="main-table_playoff playoff_semi" title="Выходы в полуфинал кубка чемпионов
Вознаграждаются 6 или 4 очками">1/2</td>
                            <td class="main-table_playoff playoff_quarter" title="Выходы в четвертьфинал кубка чемпионов
Вознаграждаются 3 или 2 очками">1/4</td>
                            <td class="main-table_gap"></td>
                            <td class="main-table_victory">
                                <img src="images/EuroLeagueCup_h20_990000.png" alt="Лига Европы" title="Победы в еврокубках (помимо кубка чемпионов)
Вознаграждаются 4 очками">
                            </td>
                            <td class="main-table_playoff playoff_final" title="Выходы в финал еврокубков (помимо кубка чемпионов)
Вознаграждаются 3 очками">Ф</td>
                            <td class="main-table_playoff playoff_semi" title="Выходы в полуфинал еврокубков (помимо кубка чемпионов)
Вознаграждаются 2 очками">1/2</td>
                            <td class="main-table_playoff playoff_quarter" title="Выходы в четвертьфинал еврокубков (помимо кубка чемпионов)
Вознаграждаются 1 очком">1/4</td>
                            <td class="main-table_gap"></td>
                            <td class="main-table_criterion" title="Очки считались по следующей системе:
за победу в Лиге чемпионов с 2000-го года - 12 очков; за выход в финал - 9; выход в 1/2 финала - 6; выход в 1/4 финала - 3;
за победу в кубке/Лиге чемпионов до 2000-го года - 8 очков; за выход в финал - 6; выход в 1/2 финала - 4; выход в 1/4 финала - 2;
за победу в других еврокубках - 4 очка; за выход в финал - 3; выход в 1/2 финала - 2; выход в 1/4 финала - 1">
                                Очки
                            </td>
                        </tr>
                        
                            <? for($clubNumber = 1; $clubNumber <= 25; $clubNumber++): ?>

                                <?

                                    $curClubIndex = ((($tableNumber * 25) -25) + ($clubNumber - 1));
                                    $curClubName = $rangeInfo["range"][$curClubIndex]["clubName"];
                                    $curClubPoints = $rangeInfo["range"][$curClubIndex]["mainRangeMarksSum"];
                                    $curClubInfo = $rangeInfo["clubsList"][$curClubName];
                                    // $curClubId = $curClubInfo["id"];
                                    $curClubId = $achievesArrIndexes[$curClubIndex];

                                    $curClubCode = $curClubInfo["code"];
                                    $curClubCountryCode = $curClubInfo["countryEngCode"];

                                    $isCurTourneyParticipant = in_array($curClubId, array_keys($currentSeasonClubsInfo["clubsInfo"]));
                                    $curTourneyParticipantHtmlRecord = $isCurTourneyParticipant ? " current" : "";
                                    $curTourneyParticipantCriterionHtmlRecord = $isCurTourneyParticipant ? " criterion_current-participant" : "";
                                    $criterionHintContent = $isCurTourneyParticipant ? "Участвует в текущем розыгрыше еврокубков" : "";
                                    $curSeasonCurClubTourneyCode = ($currentSeasonClubsInfo["clubsInfo"][$curClubId]["tourneyTitle"] === "Лига чемпионов") ? "champ_league/cl" : "euroleague/el";

                                    if ( ! (in_array($curClubInfo["shortName"], $tooLongNames)) ) {
                                        $nameRecord = $curClubInfo["shortName"];
                                    }
                                    elseif (in_array($curClubInfo["shortName"], $tooLongNames)) {
                                        $nameRecord = "<div class='club-name'><span class='club-name_minsize'>{$curClubInfo["shortName"]}</span></div>";
                                    }                                    

                                    $curClubPointsRusWordCorrectForm = WordForms::getWordLikePoint(["word" => "очко", "number" => $curClubPoints,])                                    

                                ?>

                                <tr class="club-row <?=$curClubCode?> <?=$curClubCountryCode?><?=$curTourneyParticipantHtmlRecord?>">

                                    <td class="number"><?=($curClubIndex + 1)?></td>

                                    <td>
                                        <img alt="<?=$curClubInfo["shortName"]?>" src="../images/<?=$logotypesInfo[$curClubInfo["id"]]["logoImageFile"]?>" title="<?=$curClubInfo["shortName"]?>" class="football-logo-table<?=$logotypesInfo[$curClubInfo["id"]]["clubCssClassHtmlRecord"]?>">                                 
                                    </td>

                                    <td>
                                        <div class="club-name">
                                            <?=$nameRecord?>
                                        </div>
                                    </td>
                                    
                                    <td class="main-table_gap"></td>

                                    <? foreach (array_keys($tourTypesInfo) as $curTourneyType): ?>

                                        <? foreach ($achievesStages as $curStage => $curStageInfo): ?>

                                            <?

                                                $victoriesClassPart = ($curStage === "wins") ? "victory" : "playoff";                                             

                                                $curStageAchievesNumber = $rangeInfo["achieves"][$curClubId]["achieves"][$curTourneyType][$curStage]["number"];
                                                $hasAchievesRecord = ($curStageAchievesNumber > 0) ? " has-achieves" : "";

                                                if ($curStage !== "wins") {
                                                    $achNumRecord = ($curStageAchievesNumber > 0) ? $curStageAchievesNumber : "";
                                                }
                                                elseif ($curStage === "wins") {
                                                    $achNumRecord = ($curStageAchievesNumber > 0) ? "<span class='main-table_victory'>{$curStageAchievesNumber}</span>" : "";
                                                }

                                                $curStageRusWordBacicForm = $curStageInfo["rusStageWord"];
                                                $methodToGetCorrForm = $curStageInfo["methodToGetCorrForm"];
                                                $curStageRusWordCorrectForm = WordForms::$methodToGetCorrForm(["word" => $curStageRusWordBacicForm, "number" => $curStageAchievesNumber,]);

                                                $correctTourneyForm = ($curStage === "wins") ? $tourTypesInfo[$curTourneyType]["wins"]["correctTourneyForm"] : $tourTypesInfo[$curTourneyType]["other"]["correctTourneyForm"];

                                                if ($curStageAchievesNumber <= 0) {
                                                    $hintContent = "";
                                                }
                                                elseif ($curStageAchievesNumber > 0) {
                                                    $hintContent = "{$curClubInfo["shortName"]}: {$curStageAchievesNumber} {$curStageRusWordCorrectForm} {$correctTourneyForm}
Кликните, чтобы узнать подробности";
                                                }                                                

                                            ?>                                            

                                            <td class="main-table_<?=$victoriesClassPart?><?=$hasAchievesRecord?>" title="<?=$hintContent?>">

                                                <?=$achNumRecord?>                                            

                                                <? if ($curStageAchievesNumber > 0): ?>

                                                    <?
                                                        $correctPopupAchForm = $achievesStages[$curStage]["popupStageWord"];
                                                    ?>

                                                    <div class="popup d-none">

                                                        <div class="popup__cross">
                                                            <img src="images/cross.png" alt="Закрыть" title="Закрыть">
                                                        </div>

                                                        <div>
                                                            <p class="popup__club-info">
                                                                <img alt="<?=$curClubInfo["shortName"]?>" src="../images/<?=$logotypesInfo[$curClubInfo["id"]]["logoImageFile"]?>" title="<?=$curClubInfo["shortName"]?>" class="football-logo-table popup__club-info_logo">
                                                                <?=$curClubInfo["shortName"]?>
                                                            </p>
                                                        </div>

                                                        <div>
                                                            <p class="achives-info_explanation-achieves"><?=$correctPopupAchForm?> в еврокубках</p>
                                                            <p class="achives-info_explanation-click">кликните для перехода к турниру</p>
                                                        </div>                                                    
                                                        
                                                        <div class="popup__achieves-info">
                                                            <p class="tourney-info">
                                                                <a href="archive/cup_win_cup/cwc_1967.html" target="blank" title="Посмотреть турнир кубка кубков 1966/1967">
                                                                    Кубок кубков 1967
                                                                </a>
                                                            </p>
                                                        </div>                                                    
                                                        
                                                        <div class="popup__achieves-info">
                                                            <p class="tourney-info">
                                                                <a href="archive/euroleague/el_1996.html" target="blank" title="Посмотреть турнир кубка УЕФА 1995/1996">
                                                                    Кубок УЕФА 1996
                                                                </a>
                                                            </p>
                                                        </div>
                                                        
                                                    </div>

                                                <? endif;?>
                                            
                                            </td>

                                        <? endforeach; ?>

                                        <td class="main-table_gap"></td>                               

                                    <? endforeach; ?>

                                    <td class="main-table_criterion<?=$curTourneyParticipantCriterionHtmlRecord?>" title="<?=$criterionHintContent?>">
                                        <? if($isCurTourneyParticipant === true): ?>
                                            <a href="archive/<?=$curSeasonCurClubTourneyCode?>_<?=$tourneyEndYear?>.html">
                                                <div class="for-href">
                                        <? endif;?>
                                                    <span class="main-table_criterion" title="<?=$curClubInfo["shortName"]?>: <?=$curClubPoints?> <?=$curClubPointsRusWordCorrectForm?>"><?=$curClubPoints?></span>
                                        <? if($isCurTourneyParticipant === true): ?>                                                    
                                                </div>
                                            </a>
                                        <? endif;?>
                                    </td>                                     

                                </tr>

                            <? endfor; ?>

                        </tbody>
                    </table>

                <? endfor; ?>

            </div class="tables">
                      
            <div class="table-explanation">
                <p class="table-explanation__explanation explanation_RUS">Российские клубы</p>
                <p class="table-explanation__explanation explanation_UKR">Украинские клубы</p>
                <p class="table-explanation__explanation explanation_current">
                    <!-- Клубы, участвующие в текущем
                    розыгрыше еврокубков (<?=$tourneyStartYear?>/<?=$tourneyEndYear?>) -->
                    Клубы, продолжающие участие в текущем
                    розыгрыше еврокубков (<?=$tourneyStartYear?>/<?=$tourneyEndYear?>)
                </p>
            </div>

            <div class="main__nations">

                <p class="nations__header">
                    В таблице представлены клубы стран:
                </p>

                <div class="nations__list">

                    <div class="nations__item ENG">
                        <div class="item__item nations__flag ENG">
                            <img src="images/flags/ENG.png" alt="Англия">
                        </div>
                        <div class="item__item nations__name ENG">Англия</div>
                        <div class="item__item nations__number ENG">13</div>
                    </div>

                    <div class="nations__item GER">
                        <div class="item__item nations__flag GER">
                            <img src="images/flags/GER.png" alt="Германия">
                        </div>
                        <div class="item__item nations__name GER">Германия</div>
                        <div class="item__item nations__number GER">12</div>
                    </div>

                    <div class="nations__item ESP">
                        <div class="item__item nations__flag ESP">
                            <img src="images/flags/ESP.png" alt="Испания">
                        </div>
                        <div class="item__item nations__name ESP">Испания</div>
                        <div class="item__item nations__number ESP">10</div>
                    </div>

                    <div class="nations__item ITA">
                        <div class="item__item nations__flag ITA">
                            <img src="images/flags/ITA.png" alt="Италия">
                        </div>
                        <div class="item__item nations__name ITA">Италия</div>
                        <div class="item__item nations__number ITA">10</div>
                    </div>

                    <div class="nations__item FRA">
                        <div class="item__item nations__flag FRA">
                            <img src="images/flags/FRA.png" alt="Франция">
                        </div>
                        <div class="item__item nations__name FRA">Франция</div>
                        <div class="item__item nations__number FRA">9</div>
                    </div>

                    <div class="nations__item HOL">
                        <div class="item__item nations__flag HOL">
                            <img src="images/flags/HOL.png" alt="Нидерланды">
                        </div>
                        <div class="item__item nations__name HOL">Нидерланды</div>
                        <div class="item__item nations__number HOL">5</div>
                    </div>

                    <div class="nations__item SCO">
                        <div class="item__item nations__flag SCO">
                            <img src="images/flags/SCO.png" alt="Шотландия">
                        </div>
                        <div class="item__item nations__name SCO">Шотландия</div>
                        <div class="item__item nations__number SCO">5</div>
                    </div>

                    <div class="nations__item BEL">
                        <div class="item__item nations__flag BEL">
                            <img src="images/flags/BEL.png" alt="Бельгия">
                        </div>
                        <div class="item__item nations__name BEL">Бельгия</div>
                        <div class="item__item nations__number BEL">4</div>
                    </div>

                    <div class="nations__item POR">
                        <div class="item__item nations__flag POR">
                            <img src="images/flags/POR.png" alt="Португалия">
                        </div>
                        <div class="item__item nations__name POR">Португалия</div>
                        <div class="item__item nations__number POR">3</div>
                    </div>

                    <div class="nations__item RUS">
                        <div class="item__item nations__flag RUS">
                            <img src="images/flags/RUS.png" alt="Россия">
                        </div>
                        <div class="item__item nations__name RUS">Россия</div>
                        <div class="item__item nations__number RUS">3</div>
                    </div>

                    <div class="nations__item HUN">
                        <div class="item__item nations__flag HUN">
                            <img src="images/flags/HUN.png" alt="Венгрия">
                        </div>
                        <div class="item__item nations__name HUN">Венгрия</div>
                        <div class="item__item nations__number HUN">3</div>
                    </div>

                    <div class="nations__item GDR">
                        <div class="item__item nations__flag GDR">
                            <img src="images/flags/GDR.png" alt="ГДР">
                        </div>
                        <div class="item__item nations__name GDR">ГДР</div>
                        <div class="item__item nations__number GDR">3</div>
                    </div>

                    <div class="nations__item SRB">
                        <div class="item__item nations__flag SRB">
                            <img src="images/flags/SRB.png" alt="Сербия">
                        </div>
                        <div class="item__item nations__name SRB">Сербия</div>
                        <div class="item__item nations__number SRB">2</div>
                    </div>

                    <div class="nations__item UKR">
                        <div class="item__item nations__flag UKR">
                            <img src="images/flags/UKR.png" alt="Украина">
                        </div>
                        <div class="item__item nations__name UKR">Украина</div>
                        <div class="item__item nations__number UKR">2</div>
                    </div>

                    <div class="nations__item SWE">
                        <div class="item__item nations__flag SWE">
                            <img src="images/flags/SWE.png" alt="Швеция">
                        </div>
                        <div class="item__item nations__name SWE">Швеция</div>
                        <div class="item__item nations__number SWE">2</div>
                    </div>

                    <div class="nations__item AUT">
                        <div class="item__item nations__flag AUT">
                            <img src="images/flags/AUT.png" alt="Австрия">
                        </div>
                        <div class="item__item nations__name AUT">Австрия</div>
                        <div class="item__item nations__number AUT">2</div>
                    </div>

                    <div class="nations__item CZE">
                        <div class="item__item nations__flag CZE">
                            <img src="images/flags/CZE.png" alt="Чехия">
                        </div>
                        <div class="item__item nations__name CZE">Чехия</div>
                        <div class="item__item nations__number CZE">2</div>
                    </div>

                    <div class="nations__item CRO">
                        <div class="item__item nations__flag CRO">
                            <img src="images/flags/CRO.png" alt="Хорватия">
                        </div>
                        <div class="item__item nations__name CRO">Хорватия</div>
                        <div class="item__item nations__number CRO">2</div>
                    </div>

                    <div class="nations__item SUI">
                        <div class="item__item nations__flag SUI">
                            <img src="images/flags/SUI.png" alt="Швейцария">
                        </div>
                        <div class="item__item nations__name SUI">Швейцария</div>
                        <div class="item__item nations__number SUI">2</div>
                    </div>                    

                    <div class="nations__item ROU">
                        <div class="item__item nations__flag ROU">
                            <img src="images/flags/ROU.png" alt="Румыния">
                        </div>
                        <div class="item__item nations__name ROU">Румыния</div>
                        <div class="item__item nations__number ROU">1</div>
                    </div>

                    <div class="nations__item GRE">
                        <div class="item__item nations__flag GRE">
                            <img src="images/flags/GRE.png" alt="Греция">
                        </div>
                        <div class="item__item nations__name GRE">Греция</div>
                        <div class="item__item nations__number GRE">1</div>
                    </div>

                    <div class="nations__item TUR">
                        <div class="item__item nations__flag TUR">
                            <img src="images/flags/TUR.png" alt="Турция">
                        </div>
                        <div class="item__item nations__name TUR">Турция</div>
                        <div class="item__item nations__number TUR">1</div>
                    </div>

                    <div class="nations__item BUL">
                        <div class="item__item nations__flag BUL">
                            <img src="images/flags/BUL.png" alt="Болгария">
                        </div>
                        <div class="item__item nations__name BUL">Болгария</div>
                        <div class="item__item nations__number BUL">1</div>
                    </div>

                    <div class="nations__item POL">
                        <div class="item__item nations__flag POL">
                            <img src="images/flags/POL.png" alt="Польша">
                        </div>
                        <div class="item__item nations__name POL">Польша</div>
                        <div class="item__item nations__number POL">1</div>
                    </div>

                    <div class="nations__item SVK">
                        <div class="item__item nations__flag SVK">
                            <img src="images/flags/SVK.png" alt="Словакия">
                        </div>
                        <div class="item__item nations__name SVK">Словакия</div>
                        <div class="item__item nations__number SVK">1</div>
                    </div>

                </div>
            </div>

        </main>

        <? require_once 'layoutElements/footer.php'; // Подвал, элемент footer ?>

    </div class="football__background">

    <script src="scripts/range/highlightRows.js"></script>
    <script src="scripts/range/clubsAchievesDetails.js"></script>
    
</body>

</html>