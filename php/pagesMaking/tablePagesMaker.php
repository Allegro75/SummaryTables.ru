
<?

    // Файл, генерирующий страницы со сводными таблицами.

    { // Переменные, нуждающиеся в определении перед генерацией таблицы.
        
        // Нужно ещё определить:
        // - в layoutElements/header/shortHeader.php - от какого сезона турниры показываем по ссылкам в "Текущем сезоне"
        // - если делаем таблицы с фаворитами текущих турниров, в classes/TablePagesProperties.php определить h1Content
        // - если делаем таблицы с фаворитами текущих турниров, в classes/TablePagesProperties.php определить число в bookmakersParagraph
        // - если делаем таблицы с фаворитами текущих турниров, в classes/TablePagesProperties.php определить стадию турнира в screamerParagraph
        // - если делаем таблицы с фаворитами текущих турниров, в classes/TablePagesProperties.php определить наличие finishedTourneyParagraph
        // - если делаем champ_league_current, в classes/TablePagesProperties.php определить наличие clubsNumber (возможно, без него можно вообще обойтись для champ_league_current)
        // - если делаем таблицы с фаворитами текущих турниров, здесь определить наличие $tourneyTitle и, возможно, $tourneyStage

        // $pageName = "history12";
        // $pageName = "history24";
        // $pageName = "history36";
        // $pageName = "winners";
        // $pageName = "champ_league_current";
        // $pageName = "euroleague_current";
        $pageName = "ukraine";

        $lastAccountedMatchDate = "03.11.2022";

        $bookmakersOddsDate = "27.11.2022";

        $tourneyStartYear = 2022;
        $tourneyEndYear = 2023;

        // // Для history12
        // $clubsList = [
        //     "Реал Мадрид" => ["points" => 261, "gender" => "male"],
        //     "Барселона" => ["points" => 197, "gender" => "female"],
        //     "Бавария" => ["points" => 196, "gender" => "female"],
        //     "Ливерпуль" => ["points" => 138, "gender" => "male"],
        //     "Ювентус" => ["points" => 136, "gender" => "male"],
        //     "Милан" => ["points" => 128, "gender" => "male"],
        //     "Манчестер Юнайтед" => ["points" => 117, "gender" => "neuter"],
        //     "Интер Милан" => ["points" => 100, "gender" => "male"],
        //     "Бенфика" => ["points" => 98, "gender" => "female"],
        //     "Челси" => ["points" => 95, "gender" => "neuter"],
        //     "Аякс" => ["points" => 87, "gender" => "male"],
        //     "Атлетико Мадрид" => ["points" => 85, "gender" => "neuter"],
        // ];

        // Для history24 и ukraine:
        $clubsList = [
            "Реал Мадрид" => ["points" => 261,],
            "Барселона" => ["points" => 197,],
            "Бавария" => ["points" => 196,],
            "Ливерпуль" => ["points" => 138,],
            "Ювентус" => ["points" => 136,],
            "Милан" => ["points" => 128,],
            "Манчестер Юнайтед" => ["points" => 117,],
            "Интер Милан" => ["points" => 100,],
            "Бенфика" => ["points" => 98,],
            "Челси" => ["points" => 95,],
            "Аякс" => ["points" => 87,],
            "Атлетико Мадрид" => ["points" => 85,],
            "Порто" => ["points" => 61,],
            "Валенсия" => ["points" => 55,],
            "Арсенал" => ["points" => 54,],
            "Боруссия Дортмунд" => ["points" => 52,],
            "Андерлехт" => ["points" => 49,],
            "Пари Сен-Жермен" => ["points" => 44,],
            "ПСВ Эйндховен" => ["points" => 43,],
            "Црвена звезда" => ["points" => 40,],
            "Рома" => ["points" => 39,],
            "Тоттенхэм Хотспур" => ["points" => 39,],
            "Манчестер Сити" => ["points" => 38,],
            "Динамо Киев" => ["points" => 38,],
        ];

        // // Для history36
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
        //     "Гамбург" => ["points" => 38,],
        //     "Селтик" => ["points" => 37,],
        //     "Глазго Рейнджерс" => ["points" => 35,],
        //     "Монако" => ["points" => 35,],
        //     "Лидс Юнайтед" => ["points" => 35,],
        //     "Олимпик Марсель" => ["points" => 33,],
        //     "Боруссия Мёнхенгладбах" => ["points" => 32,],
        //     "Фейеноорд" => ["points" => 31,],
        //     "Олимпик Лион" => ["points" => 29,],
        //     "Севилья" => ["points" => 29,],
        //     "Вильярреал" => ["points" => 27,],
        //     "Айнтрахт Франкфурт" => ["points" => 25,],
        // ];

        // // Для winners
        // $clubsList = [
        //     "Реал Мадрид" => ["wins" => 14, "finals" => 3],
        //     "Милан" => ["wins" => 7, "finals" => 4],
        //     "Бавария" => ["wins" => 6, "finals" => 5],
        //     "Ливерпуль" => ["wins" => 6, "finals" => 4],
        //     "Барселона" => ["wins" => 5, "finals" => 3],
        //     "Аякс" => ["wins" => 4, "finals" => 2],
        //     "Интер Милан" => ["wins" => 3, "finals" => 2],
        //     "Манчестер Юнайтед" => ["wins" => 3, "finals" => 2],
        //     "Ювентус" => ["wins" => 2, "finals" => 7],
        //     "Бенфика" => ["wins" => 2, "finals" => 5],
        //     "Челси" => ["wins" => 2, "finals" => 1],
        //     "Порто" => ["wins" => 2, "finals" => 0],   
        //     "Ноттингем Форест" => ["wins" => 2, "finals" => 0],
        //     "Боруссия Дортмунд" => ["wins" => 1, "finals" => 1],
        //     "Олимпик Марсель" => ["wins" => 1, "finals" => 1],
        //     "Стяуа" => ["wins" => 1, "finals" => 1],
        //     "Гамбург" => ["wins" => 1, "finals" => 1],
        //     "Селтик" => ["wins" => 1, "finals" => 1],
        //     "Црвена звезда" => ["wins" => 1, "finals" => 0],
        //     "ПСВ Эйндховен" => ["wins" => 1, "finals" => 0],
        //     "Астон Вилла" => ["wins" => 1, "finals" => 0],
        //     "Фейеноорд" => ["wins" => 1, "finals" => 0],
        // ];

        // // Для champ_league_current
        // $clubsList = [
        //     "Манчестер Сити" => ["odds" => 2.75,],
        //     "Бавария" => ["odds" => 7,],
        //     "Пари Сен-Жермен" => ["odds" => 10,],
        //     "Ливерпуль" => ["odds" => 10,],
        //     "Реал Мадрид" => ["odds" => 12,],
        //     "Наполи" => ["odds" => 15,],
        //     "Челси" => ["odds" => 17,],
        //     "Тоттенхэм Хотспур" => ["odds" => 20,],
        //     "Бенфика" => ["odds" => 25,],
        //     "Интер Милан" => ["odds" => 35,],
        //     "Милан" => ["odds" => 45,],
        //     "Боруссия Дортмунд" => ["odds" => 50,],
        //     "Порто" => ["odds" => 75,],
        //     "РБ Лейпциг" => ["odds" => 100,],            
        //     "Айнтрахт Франкфурт" => ["odds" => 150,],
        //     "Брюгге" => ["odds" => 250,],            
        // ];

        // // Для euroleague_current
        // $clubsList = [
        //     "Арсенал" => ["odds" => 5.5,],
        //     "Барселона" => ["odds" => 6.5,],
        //     "Манчестер Юнайтед" => ["odds" => 8.5,],
        //     "Ювентус" => ["odds" => 13,],
        //     "Аякс" => ["odds" => 17,],
        //     "Бетис" => ["odds" => 17,],
        //     "Реал Сосьедад" => ["odds" => 17,],
        //     "Рома" => ["odds" => 20,],       
        // ];

        // Для ukraine
        $actualCountryClubsList = [
            "Динамо Киев" => ["seasons" => 53,],
            "Шахтёр Донецк" => ["seasons" => 33,],
            "Днепр" => ["seasons" => 20,],
            "Черноморец Одесса" => ["seasons" => 10,],
            "Заря Луганск" => ["seasons" => 9,],
            "Металлист Харьков" => ["seasons" => 9,],
            "Ворскла" => ["seasons" => 7,],
            "Карпаты" => ["seasons" => 5,],       
            "ЦСКА Киев" => ["seasons" => 2,],
        ];

    }

    require_once 'classes/TablePagesProperties.php'; // Получение свойств генерируемой страницы
    $tablePagesProperties = TablePagesProperties::$props;
    $clubsNumberPhrase = $tablePagesProperties[$pageName]["clubsNumberPhrase"];
    $clubsNumber = $tablePagesProperties[$pageName]["clubsNumber"];
    $clubsNumberPhraseFirstPart = $tablePagesProperties[$pageName]["clubsNumberPhraseFirstPart"];
    $captionsClubsNumberPhraseFirstPart = $tablePagesProperties[$pageName]["captionsClubsNumberPhraseFirstPart"];
    $clubsNumberPhraseLastPart = $tablePagesProperties[$pageName]["clubsNumberPhraseLastPart"];
    $keywordsContentPart = $tablePagesProperties[$pageName]["keywordsContentPart"] ?? "";
    $browserTitle = $tablePagesProperties[$pageName]["browserTitle"];
    $cssFilesList = $tablePagesProperties[$pageName]["cssFilesList"];
    $h1Content = $tablePagesProperties[$pageName]["h1Content"];
    $clubsRangeExplanationHintText = $tablePagesProperties[$pageName]["clubsRangeExplanationHintText"] ?? "";
    $hasRightBtn = $tablePagesProperties[$pageName]["hasRightBtn"] ?? false;
    $bookmakersParagraph = $tablePagesProperties[$pageName]["bookmakersParagraph"] ?? "";
    $screamerParagraph = $tablePagesProperties[$pageName]["screamerParagraph"] ?? "";
    $finishedTourneyParagraph = $tablePagesProperties[$pageName]["finishedTourneyParagraph"] ?? "";
    $hasTourneyYearIndicationInHead = $tablePagesProperties[$pageName]["hasTourneyYearIndicationInHead"] ?? false;
    $ranging = $tablePagesProperties[$pageName]["ranging"];
    $jsFilesList = $tablePagesProperties[$pageName]["jsFilesList"];

    $headDescriptionClubsNumberPhraseLastPart = "";
    if ($hasTourneyYearIndicationInHead) {
        $headDescriptionClubsNumberPhraseLastPart = " {$tourneyStartYear}/{$tourneyEndYear}";
    }

    $headDescripitionContent = "";
    if ($ranging !== "national") {
        $headDescripitionContent = "Сводная таблица истории противостояний европейских футбольных клубов в рамках еврокубков. {$clubsNumberPhrase}{$headDescriptionClubsNumberPhraseLastPart}.";
    }
    elseif ($ranging === "national") {
        $headDescripitionContent = "{$clubsNumberPhraseFirstPart} клубы против европейских.
        Сводная таблица истории противостояний в рамках еврокубков.";
    }

?>

<!DOCTYPE html>
<html lang="ru" class="football">

<head>

    <meta charset="utf-8">
    <meta name="author" content="Edwards, Allegro, Edwards75, Allegro75, Oleg Otkidach">
    <meta name="author" content="Олег Откидач">
    <meta name="description" content="<?=$headDescripitionContent?>">
    <meta name="keywords" content="Футбол. Еврокубки. Европа. 
    Личные встречи. Личные счета. vs. История игр. История противостояний.  
    Сводная таблица. Таблица-'шахматка'. Статистика. История. Результаты.
    <?=$keywordsContentPart?>
    Клубы. Суперклубы. Команды.
    Реал. Барселона. Ливерпуль. Манчестер Юнайтед. Бавария. Ювентус. Аякс. Милан. Интер. Арсенал.
    Лига чемпионов. Кубок чемпионов. Лига Европы. Кубок УЕФА. Кубок кубков. Суперкубок.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/football_ball.svg" type="image/x-icon">
    <title><?=$browserTitle?></title>
    <? foreach($cssFilesList as $curFileName): ?>
        <link rel="stylesheet" href="http://summarytables.ru/stylesheets/<?=$curFileName?>">
    <? endforeach; ?>

</head>

<body class="football__body">

    <div class="football__background">

        <? require_once 'layoutElements/header/shortHeader.php'; // Шапка, две оранжевые полосы с навигацией ?>

        <main>

            <? // Заголовки
            
                require_once 'layoutElements/captions/captions.php'; // Заголовки (крупнейший из к-рых - 'ЛУЧШИЕ КЛУБЫ ЕВРОПЫ ЗА ВСЮ ИСТОРИЮ')
                printCaptions (["lastAccountedMatchDate" => $lastAccountedMatchDate, "captionsClubsNumberPhraseFirstPart" => $captionsClubsNumberPhraseFirstPart, "clubsNumberPhraseLastPart" => $clubsNumberPhraseLastPart, "clubsNumber" => $clubsNumber, "h1Content" => $h1Content, "clubsRangeExplanationHintText" => $clubsRangeExplanationHintText, "ranging" => $ranging, "bookmakersParagraph" => $bookmakersParagraph, "screamerParagraph" => $screamerParagraph, "finishedTourneyParagraph" => $finishedTourneyParagraph,]);

            ?>

            <? // Данные для таблицы:

                require_once 'tableInfo.php'; // Получение содержания таблицы
                $tableInfo = getTableInfo (["clubsList" => $clubsList, "actualCountryClubsList" => $actualCountryClubsList ?? [],]);
                // echo "<pre>";
                // var_dump($tableInfo);
                // echo "</pre>";

                require_once 'classes/WordForms.php'; // Файл для получения правильных форм слов

                $champLeagueClassHtmlRecordForTable = "";
                if ($ranging === "bookmakers") {

                    require_once 'classes/Matches.php';
                    $matchesClass = new Matches();

                    require_once 'classes/Tourneys.php';

                    // Получение массива пар незавершённой стадии турнира:
                    {
                        // $tourneyTitle = "Лига чемпионов";
                        $tourneyTitle = "Лига Европы";
                        // $tourneyStage = "1/8 финала";
                        $tourneyStage = "1/16 финала";
                        $actualStagePairs = $matchesClass->getActualStagePairs(["tourneyTitle" => $tourneyTitle, "tourneyFinalYear" => $tourneyEndYear, "stage" => $tourneyStage,]);
                        // echo "<pre>";
                        // var_dump($actualStagePairs);
                        // echo "</pre>";
                    }

                    if ($tourneyTitle === "Лига чемпионов") {
                        $champLeagueClassHtmlRecordForTable = " champs-league";
                    }

                }

            ?>

            <? if ($hasRightBtn): ?>
            <div class="table-plus-right-buttons">
            <? endif; ?>

            <!-- Таблица: -->
            <table class="main-table<?=$champLeagueClassHtmlRecordForTable?>">
                <tbody>

                <?
                    // Массив имён файлов с логотипами (нужен чтобы правильно добавлять к коду клуба ".png", ".svg" и т.п.)
                    $logoFiles = scandir("images");                    
                    $specialImages = [
                        "Akt" => "Akt_light.png",
                        "AuW" => "AuW_light.png",
                        "DuP" => "DuP_light.png",
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
                ?>

                    <tr class="logotypes">

                        <td colspan="3">
                            <? if (in_array($pageName, ["ukraine", "russia"])): ?>
                                <div class="change-range-text" title="Упорядочить иностранные клубы по алфавиту / по достижениям">
                                Упорядочить по алфавиту ▶
                                </div>                                
                            <? endif; ?>
                        </td>

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

                        <? if ($ranging === "mainRange"): ?>

                            <td class="main-table_criterion" title="Клубы ранжировались по следующей системе:
за победу в Лиге чемпионов с 2000-го года - 12 очков; за выход в финал - 9; выход в 1/2 финала - 6; выход в 1/4 финала - 3;
за победу в кубке/Лиге чемпионов до 2000-го года - 8 очков; за выход в финал - 6; выход в 1/2 финала - 4; выход в 1/4 финала - 2;
за победу в других еврокубках - 4 очка; за выход в финал - 3; выход в 1/2 финала - 2; выход в 1/4 финала - 1">
                                Очки
                            </td>

                        <? elseif ($ranging === "championsLeagueWinners"): ?>

                            <td class="main-table_criterion criterion_primary" title="Количество побед в лиге/кубке чемпионов">
                                Победы
                            </td>

                            <td class="main-table_criterion criterion_secondary" title="Количество участий в финалах кубка чемпионов">
                                Финалы
                            </td>                            

                        <? elseif ($ranging === "bookmakers"): ?>

                            <td class="main-table_criterion" title="Коэффициенты на победу от букмекеров от <?=$bookmakersOddsDate?>">
                                Шансы
                            </td>

                        <? endif; ?>

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
                                        "«{$curClubInfo["shortName"]}» - «{$innerCycleClubInfo["shortName"]}»
{$curPairHistory["firstVictories"]} {$victoriesWord}, {$curPairHistory["draws"]} {$drawsWord}, {$curPairHistory["firstLesions"]} {$lesionsWord}";

                                        $resultsCellContent = ($hasHistory === true) ? 
                                        "<p class=\"games-score\">+{$curPairHistory["firstVictories"]} ={$curPairHistory["draws"]} -{$curPairHistory["firstLesions"]}</p>
<p class=\"goals-difference\">{$curPairHistory["firstGoals"]} - {$curPairHistory["secondGoals"]}</p>" : 
                                        "<p class=\"games-score\">+ = -</p>
<p class=\"goals-difference\">-</p>";

                                        $secClubNameGender = $tableInfo['clubsList'][$secClubFullName]["gender"];
                                        $correctClubNameInDuels = WordForms::getGenitiveWord(["word" => $innerCycleClubInfo["shortName"], "gender" => $secClubNameGender,]);
                                        $secClubGenitiveName = $correctClubNameInDuels["clubNameCorrForm"] ?? $correctClubNameInDuels; // В случае, если в WordForms передавалось имя типа "Боруссия Д" здесь мы получим в ответ массив, элементом к-рого с ключом "clubNameCorrForm" будет слово "Боруссии". В большинстве же случаев - просто сразу получим нужную форму названия клуба.
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

                                        $duelsDefaultVisibilityHtmlRecord = " hidden=''";
                                        if ($pageName === "history36") {
                                            $duelsDefaultVisibilityHtmlRecord = "";
                                        }

                                        $screamerNodeContent = "";
                                        if ($ranging === "bookmakers") {
                                            if ($actualStagePairs[$firstClubId]["rival"]["id"] == $secClubId) { // Если найден соперник данного клуба по незавершенной стадии турнира
                                                $folder = Tourneys::$tourneysProps[$tourneyTitle]["archiveFolderName"];
                                                $prefix = Tourneys::$tourneysProps[$tourneyTitle]["archiveFilePrefix"];
                                                $stageCorectForm = ($tourneyStage === "ФИНАЛ") ? "финалу" : $tourneyStage;
                                                $screamerNodeContent = 
                                                    "<a href=\"archive/{$folder}/{$prefix}_{$tourneyEndYear}.html\">
                                                    <img src=\"images/screamer_brown.png\" alt=\"{$tourneyStage}\" class=\"current-pair\" title=\"«{$curClubInfo["shortName"]}» - «{$innerCycleClubInfo["shortName"]}». Соперники по {$stageCorectForm} текущего розыгрыша\">
                                                </a>";
                                            }
                                        }

                                    ?>

                                    <td id="<?=$curPairCode?>" data-first-club-id="<?=$firstClubId?>" data-sec-club-id="<?=$secClubId?>" class="statistics <?=$curPairHasHistoryClass?>">
                                        <? if ($pageName !== "history36"): // На странице history36 данные с результатами матчей не нужны (нужны только дуэли) ?>
                                            <div class="results" title="<?=$resultsHintContent?>">
                                                <?=$resultsCellContent?>
                                            </div>
                                        <? endif; ?>
                                        <div class="duels" title="<?=$duelsHintFirstStr?><?=$duelsHintTheRest?>"<?=$duelsDefaultVisibilityHtmlRecord?>>
                                            <?=$duelsCellContent?>
                                        </div>
                                        <?=$screamerNodeContent?>
                                    </td>

                                <? endif; ?>

                            <? endforeach; ?>
                            
                            <td class="main-table_gap"></td>

                            <? if ($ranging === "mainRange"): ?>

                                <?
                                    $corrPointWordForm = WordForms::getWordLikePoint(["word" => "очко", "number" => $clubsList[$curClubInfo["basicFullName"]]["points"]]);
                                ?>

                                <td class="main-table_criterion" title="<?=$curClubInfo["shortName"]?>: <?=$clubsList[$curClubInfo["basicFullName"]]["points"]?> <?=$corrPointWordForm?>">
                                    <a href="range.html">
                                        <span class="main-table_criterion"><?=$clubsList[$curClubInfo["basicFullName"]]["points"]?></span>
                                    </a>
                                </td>
                            
                            <? elseif ($ranging === "championsLeagueWinners"): ?>

                                <?
                                    $corrVictoryWordForm = WordForms::getWordLikeVictory(["word" => "победа", "number" => $clubsList[$curClubInfo["basicFullName"]]["wins"]]);
                                    $corrFinalWordForm = WordForms::getWordLikeFinal(["word" => "финал", "number" => $clubsList[$curClubInfo["basicFullName"]]["finals"]]);
                                ?>                                

                                <td class="main-table_criterion criterion_primary" title="<?=$curClubInfo["shortName"]?>: <?=$clubsList[$curClubInfo["basicFullName"]]["wins"]?> <?=$corrVictoryWordForm?> в кубке чемпионов">
                                    <span class="main-table_criterion criterion_primary">
                                        <?=$clubsList[$curClubInfo["basicFullName"]]["wins"]?>
                                    </span>
                                </td>

                                <td class="main-table_criterion criterion_secondary" title="<?=$curClubInfo["shortName"]?>: <?=$clubsList[$curClubInfo["basicFullName"]]["finals"]?> <?=$corrFinalWordForm?>">
                                    <span class="main-table_criterion criterion_secondary">
                                        <?=$clubsList[$curClubInfo["basicFullName"]]["finals"]?>
                                    </span>
                                </td>
                                                         
                            <? elseif ($ranging === "bookmakers"): ?>

                                <?
                                    $curClubOdds = $clubsList[$curClubInfo["basicFullName"]]["odds"];
                                ?>                                

                                <td class="main-table_criterion" title="<?=$curClubInfo["shortName"]?>: <?=$curClubOdds?>. Шансы от <?=$bookmakersOddsDate?>">
                                    <span class="main-table_criterion">
                                        <?=$curClubOdds?>
                                    </span>
                                </td>

                            <? endif; ?>

                        </tr>

                        <? $rowNumber++; ?>

                    <? endforeach; ?>

                </tbody>
            </table>

            <? if ($hasRightBtn): ?>

                <?
                    $btnIdHtmlRecord = ($pageName === "history24") ? " id=\"history25\"" : "";
                ?>

                    <!--Кнопка СПРАВА для переключения в дуэльный вид: -->
                    <div class="duels-switch  btn-right"<?=$btnIdHtmlRecord?>>
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

            <? if ($pageName !== "history36"): ?>
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
            <? endif; ?>

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

                <? if ($pageName !== "history36"): ?>
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
                <? endif; ?>

            </div>

            <hr>

        </main>

        <? require_once 'layoutElements/footer.php'; // Подвал, элемент footer ?>

    </div class="football__background">

    <? foreach($jsFilesList as $curFileName): ?>
        <script src="http://summarytables.ru/scripts/<?=$curFileName?>"></script>
    <? endforeach; ?>
    
</body>

</html>