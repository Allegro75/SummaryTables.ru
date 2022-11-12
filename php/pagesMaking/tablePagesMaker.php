
<?

    // Файл, генерирующий страницы со сводными таблицами.

    // Переменные, нуждающиеся в определении перед генерацией таблицы. Кажется, больше нигде ничего определять не надо
    if (true) {

        // $pageName = "history24";
        $pageName = "history12";

        $lastAccountedMatchDate = "03.11.2022";
        $clubsList = [
            "Реал Мадрид" => ["points" => 261, "gender" => "male"],
            "Барселона" => ["points" => 197, "gender" => "female"],
            "Бавария" => ["points" => 196, "gender" => "female"],
            "Ливерпуль" => ["points" => 138, "gender" => "male"],
            "Ювентус" => ["points" => 136, "gender" => "male"],
            "Милан" => ["points" => 128, "gender" => "male"],
            "Манчестер Юнайтед" => ["points" => 117, "gender" => "neuter"],
            "Интер Милан" => ["points" => 100, "gender" => "male"],
            "Бенфика" => ["points" => 98, "gender" => "female"],
            "Челси" => ["points" => 95, "gender" => "neuter"],
            "Аякс" => ["points" => 87, "gender" => "male"],
            "Атлетико Мадрид" => ["points" => 85, "gender" => "neuter"],
        ];
        // $clubsList = [
        //     "Реал Мадрид" => ["points" => 261,],
        //     "Барселона" => ["points" => 197,],
        //     "Бавария" => ["points" => 196,],
        //     "Ливерпуль" => ["points" => 138,],
        //     "Ювентус" => ["points" => 136,],
        //     "Милан" => ["points" => 128,],
        //     "Манчестер Юнайтед" => ["points" => 117,],
        //     "Интер Милан" => ["points" => 100,],
        //     "Бенфика" => ["points" => 98,],
        //     "Челси" => ["points" => 95,],
        //     "Аякс" => ["points" => 87,],
        //     "Атлетико Мадрид" => ["points" => 85,],
        //     "Порто" => ["points" => 61,],
        //     "Валенсия" => ["points" => 55,],
        //     "Арсенал" => ["points" => 54,],
        //     "Боруссия Дортмунд" => ["points" => 52,],
        //     "Андерлехт" => ["points" => 49,],
        //     "Пари Сен-Жермен" => ["points" => 44,],
        //     "ПСВ Эйндховен" => ["points" => 43,],
        //     "Црвена звезда" => ["points" => 40,],
        //     "Рома" => ["points" => 39,],
        //     "Тоттенхэм Хотспур" => ["points" => 39,],
        //     "Манчестер Сити" => ["points" => 38,],
        //     "Динамо Киев" => ["points" => 38,],
        // ];

    }

    require_once 'classes/TablePagesProperties.php'; // Получение свойств генерируемой страницы
    $tablePagesProperties = TablePagesProperties::$props;
    $clubsNumberPhrase = $tablePagesProperties[$pageName]["clubsNumberPhrase"];
    $clubsNumber = $tablePagesProperties[$pageName]["clubsNumber"];
    $clubsNumberPhraseLastPart = $tablePagesProperties[$pageName]["clubsNumberPhraseLastPart"];
    $browserTitle = $tablePagesProperties[$pageName]["browserTitle"];
    $cssFilesList = $tablePagesProperties[$pageName]["cssFilesList"];

?>

<!DOCTYPE html>
<html lang="ru" class="football">

<head>

    <meta charset="utf-8">
    <meta name="author" content="Edwards, Allegro, Edwards75, Allegro75, Oleg Otkidach">
    <meta name="author" content="Олег Откидач">
    <meta name="description" content="Сводная таблица истории противостояний европейских футбольных клубов в рамках еврокубков. <?=$clubsNumberPhrase?>.">
    <meta name="keywords" content="Футбол. Еврокубки. Европа. 
    Личные встречи. Личные счета. vs. История игр. История противостояний.  
    Сводная таблица. Таблица-'шахматка'. Статистика. История. Результаты. 
    Клубы. Суперклубы. Команды. 
    Реал. Барселона. Ливерпуль. Манчестер Юнайтед. Бавария. Ювентус. Аякс. Милан. Интер. Арсенал.
    Лига чемпионов. Кубок чемпионов. Лига Европы. Кубок УЕФА. Кубок кубков. Суперкубок.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/football_ball.svg" type="image/x-icon">
    <title><?=$browserTitle?></title>
    <? foreach($cssFilesList as $curFileName): ?>
        <link rel="stylesheet" href="stylesheets/<?=$curFileName?>">
    <? endforeach; ?>

</head>

<body class="football__body">

    <div class="football__background">

        <? require_once 'layoutElements/header/shortHeader.php'; // Шапка, две оранжевые полосы с навигацией ?>

        <main>

            <? 
                require_once 'layoutElements/captions/captions.php'; // Заголовки (крупнейший из к-рых - 'ЛУЧШИЕ КЛУБЫ ЕВРОПЫ ЗА ВСЮ ИСТОРИЮ')
                printCaptions (["lastAccountedMatchDate" => $lastAccountedMatchDate, "clubsNumberPhraseLastPart" => $clubsNumberPhraseLastPart, "clubsNumber" => $clubsNumber,]);

                require_once 'tableInfo.php'; // Получение содержания таблицы
                $tableInfo = getTableInfo (["clubsList" => $clubsList]);
                // echo "<pre>";
                // var_dump($tableInfo);
                // echo "</pre>";

                require_once 'classes/WordForms.php'; // Получение правильных форм слов
            ?>

            <? if ($pageName === "history24"): ?>
            <div class="table-plus-right-buttons">
            <? endif; ?>

            <!-- Таблица: -->
            <table class="main-table">
                <tbody>

                <?
                    // Массив имён файлов с логотипами (нужен чтобы правильно добавлять к коду клуба ".png", ".svg" и т.п.)
                    $logoFiles = scandir("images");                    
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
                ?>

                    <tr class="logotypes">

                        <td colspan="3"></td>

                        <? $number = 1; ?>

                        <? foreach ($tableInfo['clubsList'] as &$curClubInfo): ?>

                            <?
                                // Имя файла с картинкой логотипа:
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
                                $curClubInfo["logoImageFile"] = $logoImageFile;
                                $curClubInfo["clubCssClassHtmlRecord"] = $clubCssClassHtmlRecord;
                            ?>                            

                            <td>
                                <span class="number"><?=$number?></span>
                                <img alt="<?=$curClubInfo["shortName"]?>" src="../images/<?=$logoImageFile?>" title="<?=$curClubInfo["shortName"]?>" class="football-logo-table<?=$clubCssClassHtmlRecord?>">
                            </td>
                            
                            <? $number++; ?>

                        <? endforeach; ?>
                        <? unset($curClubInfo); ?>

                        <td class="main-table_gap"></td>

                        <td class="main-table_criterion" title="Клубы ранжировались по следующей системе:
за победу в Лиге чемпионов с 2000-го года - 12 очков; за выход в финал - 9; выход в 1/2 финала - 6; выход в 1/4 финала - 3;
за победу в кубке/Лиге чемпионов до 2000-го года - 8 очков; за выход в финал - 6; выход в 1/2 финала - 4; выход в 1/4 финала - 2;
за победу в других еврокубках - 4 очка; за выход в финал - 3; выход в 1/2 финала - 2; выход в 1/4 финала - 1">
                            Очки
                        </td>

                    </tr>

                    <? $rowNumber = 1; ?>

                    <? foreach ($tableInfo['clubsList'] as $curClubInfo): ?>
                        
                        <tr class="<?=$curClubInfo['code']?>">

                            <td class="number"><?=$rowNumber?></td>

                            <td>
                                <img alt="<?=$curClubInfo["shortName"]?>" src="../images/<?=$curClubInfo["logoImageFile"]?>" title="<?=$curClubInfo["shortName"]?>" class="football-logo-table<?=$curClubInfo["clubCssClassHtmlRecord"]?>">
                            </td>

                            <td>
                                <div class="club-name"><?=$curClubInfo["basicFullName"]?></div>
                            </td>

                            <? foreach ($tableInfo['clubsList'] as $innerCycleClubInfo): ?>

                                <?
                                    $secClubFullName = $innerCycleClubInfo["basicFullName"];
                                ?>

                                <? if ($curClubInfo["basicFullName"] === $secClubFullName): // Для ячеек, где показываем эмблему клуба ?>

                                    <td>
                                        <img alt="<?=$curClubInfo["shortName"]?>" src="../images/<?=$curClubInfo["logoImageFile"]?>" title="<?=$curClubInfo["shortName"]?>" class="football-logo-table<?=$curClubInfo["clubCssClassHtmlRecord"]?>">
                                    </td>

                                <? else: ?>

                                    <?

                                        $curPairCode = "{$curClubInfo["code"]}{$innerCycleClubInfo["code"]}";
                                        $curPairClubTitlesStr = "{$curClubInfo["basicFullName"]} - {$secClubFullName}";
                                        $curPairHistory = $tableInfo['pairsMatchesHistory'][$curPairClubTitlesStr];
                                        $hasHistory = (empty($curPairHistory["duels"])) ? false : true;
                                        $curPairHasHistoryClass = ($hasHistory === true ) ? "has-history" : "no-history";
                                        $victoriesWord = WordForms::getWordLikePobeda(["word" => "победа", "number" => $curPairHistory["firstVictories"]]);
                                        $duelsVictoriesWord = WordForms::getWordLikePobeda(["word" => "победа", "number" => $curPairHistory["duels"]["firstClubDuelsVictories"]]);
                                        $drawsWord = WordForms::getWordLikeDraw(["word" => "ничья", "number" => $curPairHistory["draws"]]);
                                        $lesionsWord = WordForms::getWordLikeLesion(["word" => "поражение", "number" => $curPairHistory["firstLesions"]]);
                                        $duelsLesionsWord = WordForms::getWordLikeLesion(["word" => "поражение", "number" => $curPairHistory["duels"]["firstClubDuelsLesions"]]);

                                        $resultsHintContent = ($hasHistory === true) ? 
                                        "«{$curClubInfo["shortName"]}» - «{$innerCycleClubInfo["shortName"]}»
{$curPairHistory["firstVictories"]} {$victoriesWord}, {$curPairHistory["draws"]} {$drawsWord}, {$curPairHistory["firstLesions"]} {$lesionsWord}
Кликните, чтобы узнать подробности" : 
                                        "{$curClubInfo["shortName"]} - {$innerCycleClubInfo["shortName"]}
{$curPairHistory["firstVictories"]} {$victoriesWord}, {$curPairHistory["draws"]} {$drawsWord}, {$curPairHistory["firstLesions"]} {$lesionsWord}";

                                        $resultsCellContent = ($hasHistory === true) ? 
                                        "<p class=\"games-score\">+{$curPairHistory["firstVictories"]} ={$curPairHistory["draws"]} -{$curPairHistory["firstLesions"]}</p>
<p class=\"goals-difference\">{$curPairHistory["firstGoals"]} - {$curPairHistory["secondGoals"]}</p>" : 
                                        "<p class=\"games-score\">+ = -</p>
<p class=\"goals-difference\">-</p>";

                                        $secClubNameGender = $tableInfo['clubsList'][$secClubFullName]["gender"];
                                        // $secClubGenitiveName = ($secClubNameGender === "neuter") ? $innerCycleClubInfo["shortName"] : WordForms::getGenitiveWord(["word" => $innerCycleClubInfo["shortName"], "gender" => $secClubNameGender,]);
                                        $correctClubNameInDuels = WordForms::getGenitiveWord(["word" => $innerCycleClubInfo["shortName"], "gender" => $secClubNameGender,]);
                                        $secClubGenitiveName = $correctClubNameInDuels["clubNameCorrForm"] ?? $correctClubNameInDuels; // В случае, если в WordForms передавалось имя типа "Боруссия Д" здесь мы получим в ответ массив, элеиентом к-рого с ключом "clubNameCorrForm" будет слово "Боруссии". В большинстве же случаев - просто сразу получим нужную форму названия клуба.
                                        $cityPartClubName = $correctClubNameInDuels["cityPart"] ?? ""; // Для "Боруссия Д" здесь мы получим "Д". В остальных случаях - ничего.

                                        if ((mb_strpos($curClubInfo["shortName"], " ") !== false) && ($curClubInfo["shortName"] !== "Црвена звезда")) { // Для названий типа "Боруссия Д", "Динамо К". Работа над получением корректной формы этих названий в именительном падеже с учётом кавычек.

                                            $clubNameWordsArr = explode(" ", $curClubInfo["shortName"]);
                                            $justClubName = $clubNameWordsArr[0];
                                            $cityPart = $clubNameWordsArr[1];

                                        } else {
                                            $justClubName = $curClubInfo["shortName"];
                                            $cityPart = "";
                                        }                       

                                        $duelsHintFirstStr = "«{$justClubName}»{$cityPart} против «{$secClubGenitiveName}»{$cityPartClubName}\n";
                                        $duelsDrawsElement = "";
                                        if ( ! (empty($curPairHistory["duels"]["duelDraws"])) ) {
                                            $drawDuelsWord = WordForms::getWordLikeDuel(["word" => "дуэль", "number" => $curPairHistory["duels"]["duelDraws"]]);
                                            $groupWord = 'группе';
                                            $defineWord = 'выявила';
                                            if ($curPairHistory["duels"]["duelDraws"] > 1) {
                                                $groupWord = 'группах';
                                                $defineWord = 'выявили';
                                            }                
                                            $duelsDrawsElement = ", {$curPairHistory["duels"]["duelDraws"]} {$drawDuelsWord} в {$groupWord} не {$defineWord} победителя";
                                        }
                                        $notFinishedDuelsElement = "";
                                        if ($curPairHistory["duels"]["notFinishedDuels"] == 1) {
                                            $notFinishedDuelsElement = ", 1 дуэль не завершена";
                                        }                                        
                                        $duelsHintTheRest = ($hasHistory === true) ? 
"{$curPairHistory["duels"]["firstClubDuelsVictories"]} {$duelsVictoriesWord} в дуэлях, {$curPairHistory["duels"]["firstClubDuelsLesions"]} {$duelsLesionsWord}{$duelsDrawsElement}{$notFinishedDuelsElement}
Кликните, чтобы узнать подробности" : 
"В еврокубках не встречались";

                                        $duelsCellContent = ($hasHistory === true) ? "{$curPairHistory["duels"]["firstClubDuelsVictories"]} - {$curPairHistory["duels"]["firstClubDuelsLesions"]}" : "-";

                                        $firstClubId = $curClubInfo['id'];
                                        $secClubId = $innerCycleClubInfo['id'];

                                    ?>

                                    <td id="<?=$curPairCode?>" data-first-club-id="<?=$firstClubId?>" data-sec-club-id="<?=$secClubId?>" class="statistics <?=$curPairHasHistoryClass?>">
                                        <div class="results" title="<?=$resultsHintContent?>">
                                            <?=$resultsCellContent?>
                                        </div>
                                        <div class="duels" title="<?=$duelsHintFirstStr?><?=$duelsHintTheRest?>" hidden="">
                                            <?=$duelsCellContent?>
                                        </div>
                                    </td>

                                <? endif; ?>

                            <? endforeach; ?>
                            
                            <td class="main-table_gap"></td>

                            <?
                                $corrPointWordForm = WordForms::getWordLikePoint(["word" => "очко", "number" => $clubsList[$curClubInfo["basicFullName"]]["points"]]);
                            ?>

                            <td class="main-table_criterion" title="<?=$curClubInfo["shortName"]?>: <?=$clubsList[$curClubInfo["basicFullName"]]["points"]?> <?=$corrPointWordForm?>">
                                <a href="range.html">
                                    <span class="main-table_criterion"><?=$clubsList[$curClubInfo["basicFullName"]]["points"]?></span>
                                </a>
                            </td>                            
                            
                        </tr>

                        <? $rowNumber++; ?>

                    <? endforeach; ?>

                </tbody>
            </table>

            <? if ($pageName === "history24"): ?>

                <!--Кнопка СПРАВА для переключения в дуэльный вид: -->
                <div class="duels-switch  btn-right" id="history25">
                    <button class="duels-switch__btn  btn-right__btn"
                        title="Переключиться на отображение счёта в дуэльном виде (и обратно)">
                        <span class="results"><b>ДУЭЛИ</b></span>
                        <span class="duels" hidden>ОБРАТНО</span>
                    </button>
                    <p class="btn-right__duels-explanation">
                        <b>Дуэль</b> - непосредственное столкновение двух команд в ходе турнира. <br>
                        В дуэли побеждает тот, кто проходит дальше в кубковом турнире, либо выигрывает турнир (для
                        финалов),
                        <br>
                        либо для групповых этапов - проходит в стадию более высокую, чем соперник по дуэли.
                    </p>
                </div>

            </div>

            <? endif; ?>            

            <!--Кнопка СНИЗУ для переключения в ДУЭЛЬНЫЙ вид: -->
            <div class="duels-switch  btn-lower">
                <button class="duels-switch__btn  btn-lower__btn"
                    title="Переключиться на отображение счёта в дуэльном виде (и обратно)">
                    <span class="results">Переключиться на отображение счёта в <b>ДУЭЛЯХ</b></span>
                    <span class="duels" hidden>Переключиться с дуэлей на ОБЫЧНЫЕ результаты</span>
                </button>
                <p class="btn-lower__duels-explanation">
                    <b>Дуэль</b> - непосредственное столкновение двух команд в ходе турнира. <br>
                    В дуэли побеждает тот, кто проходит дальше в кубковом турнире, либо выигрывает турнир (для финалов),
                    <br>
                    либо для групповых этапов - проходит в стадию более высокую, чем соперник по дуэли.
                </p>
            </div>

            <div class="settings">

                <div class="settings__row coloring-row">

                    <div class="coloring-buttons__div make-coloring">
                        <button class="make-coloring__btn"
                            title="Раскрасить таблицу зелёным, жёлтым, красным в зависимости от результатов в парах">
                            <span class="make-coloring__text">
                                Раскрасить / Отменить раскрашивание
                            </span>
                        </button>
                    </div>

                    <div class="coloring-buttons__div coloring-onload">
                        <label for="coloring-onload__input">
                            <input type="checkbox" id="coloring-onload__input">
                            <span class="coloring-onload__text">
                                Не раскрашивать по умолчанию
                            </span>
                        </label>
                    </div>

                </div>

                <div class="settings__row random-buttons-row">

                    <div class="random-buttons__div show-random">
                        <button class="show-random__btn"
                            title="Показать всплывающее окно с историей игр случайной пары клубов">
                            <span class="show-random__text">
                                Показать случайную пару сейчас
                            </span>
                        </button>
                    </div>

                    <div class="random-buttons__div random-onload">
                        <label for="random-onload__input">
                            <input type="checkbox" id="random-onload__input">
                            <span class="random-onload__text">
                                Показывать случайную пару при загрузке страницы
                            </span>
                        </label>
                    </div>

                </div>

                <div class="settings__row duels-row">

                    <div class="duels-row__div">
                        <label for="duels-row__input">
                            <input type="checkbox" id="duels-row__input">
                            <span class="duels-row__text">
                                Начинать показ с дуэльного вида
                            </span>
                        </label>
                    </div>

                </div>

            </div>

            <hr>

        </main>

        <? require_once 'layoutElements/footer.php'; // Подвал, элемент footer ?>

    </div class="football__background">

    <!-- <script src="scripts/showSmallTableOnCellClick.js"></script> -->
    <script src="scripts/showAutomaticallyGeneratedSmallTable.js"></script>
    <script src="scripts/showHideDuels.js"></script>
    <script src="scripts/cellsColoring.js"></script>
    <script src="scripts/coloringOnLoad.js"></script>
    <!-- <script src="scripts/randPairOnLoad.js"></script> -->
    <script src="scripts/randPairOnLoadDynamicPage.js"></script>
    <!-- <script src="scripts/randomWindowOnClick.js"></script> -->
    <script src="scripts/randomWindowOnClickDynamically.js"></script>
    <script src="scripts/duelsOnLoad.js"></script>
    <!-- <script src="scripts/service/service_rebuildTable.js"></script> -->
    
</body>

</html>    