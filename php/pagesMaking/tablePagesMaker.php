
<?

    // Файл, генерирующий страницы со сводными таблицами.

    { // Переменные, нуждающиеся в ручном определении перед генерацией таблицы. Часть 1 (из двух).

        // $pageName = "history12";
        // $pageName = "history24";
        // $pageName = "history36";
        // $pageName = "winners";
        // $pageName = "champ_league_current";
        // $pageName = "euroleague_current";
        // $pageName = "decade";
        $pageName = "5years";

    }

    { // Нац. страницы, нуждающиеся в обновлении только при изменениях в ранжировании первых 24 клубов Европы (а при отсутствии таких изменений - не нуждающиеся в связи с окончанием участия клубов страны в розыгрышах в текущем сезоне)
        // $pageName = "russia";
        // $pageName = "ukraine";
        // $pageName = "byelorussia";
        // $pageName = "kazakhstan";
    }

    require_once 'classes/TablePagesProperties.php'; // Получение свойств генерируемой страницы
    $tablePagesProperties = TablePagesProperties::$props;
    $clubsNumberPhrase = $tablePagesProperties[$pageName]["clubsNumberPhrase"];
    $clubsNumber = $tablePagesProperties[$pageName]["clubsNumber"];
    $clubsNumberPhraseFirstPart = $tablePagesProperties[$pageName]["clubsNumberPhraseFirstPart"];
    $captionsClubsNumberPhraseFirstPart = $tablePagesProperties[$pageName]["captionsClubsNumberPhraseFirstPart"];
    $clubsNumberPhraseLastPart = $tablePagesProperties[$pageName]["clubsNumberPhraseLastPart"];
    $descriptionPeriodWord = $tablePagesProperties[$pageName]["descriptionPeriodWord"] ?? "";
    $keywordsContentPart = $tablePagesProperties[$pageName]["keywordsContentPart"] ?? "";
    $browserTitle = $tablePagesProperties[$pageName]["browserTitle"];
    $cssFilesList = $tablePagesProperties[$pageName]["cssFilesList"];
    $h1Content = $tablePagesProperties[$pageName]["h1Content"];
    $clubsRangeExplanationHintText = $tablePagesProperties[$pageName]["clubsRangeExplanationHintText"] ?? "";
    $hasRightBtn = $tablePagesProperties[$pageName]["hasRightBtn"] ?? false;
    $bookmakersParagraph = $tablePagesProperties[$pageName]["bookmakersParagraph"] ?? "";
    $periodicRangeParagraph = $tablePagesProperties[$pageName]["periodicRangeParagraph"] ?? "";
    $screamerParagraph = $tablePagesProperties[$pageName]["screamerParagraph"] ?? "";
    $finishedTourneyParagraph = $tablePagesProperties[$pageName]["finishedTourneyParagraph"] ?? "";
    $hasTourneyYearIndicationInHead = $tablePagesProperties[$pageName]["hasTourneyYearIndicationInHead"] ?? false;
    $ranging = $tablePagesProperties[$pageName]["ranging"];
    $yearsNumber = $tablePagesProperties[$pageName]["yearsNumber"] ?? null;
    $jsFilesList = $tablePagesProperties[$pageName]["jsFilesList"];

    { // Переменные, нуждающиеся в ручном определении перед генерацией таблицы. Часть 2 (из двух).
        
        { // Для начала нужно ещё определить:
            
            { // Для нац. таблиц:
                // - При изменениях в ранжировании первых 24 клубов Европы - обновлять страницу вне зависимости от окончания сезона для данной страны
                // - При окончании сезона для данной страны (вылете всех её клубов из текущего розыгрыша) в captions меняем содержание на "Таблица обновлена по итогам сезона ...". Этот пункт сомнителен, т.к. выясняется, что - см. п.1 - список иностранных клубов может в любой момент измениться.
            }            

            { // При смене предстоящей стадии плей-офф нужно определять:
                // - в classes/TablePagesProperties.php определить стадию турнира в screamerParagraph
                // - здесь определить $tourneyStage
            }

            { // Три раза в сезон (перед началом турнира, началом плей-офф и перед 1/4 финала) нужно определять:
                // - если делаем таблицы с фаворитами текущих турниров, в classes/TablePagesProperties.php определить h1Content. Нужно выбрать из трёх вариантов: "УЧАСТНИКИ ПЛЕЙ-ОФФ", "ЧЕТВЕРТЬФИНАЛИСТЫ", "ФАВОРИТЫ". Для "euroleague_current" только из двух: "ЧЕТВЕРТЬФИНАЛИСТЫ" и "ФАВОРИТЫ".
            }

            { // Раз в год (по окончании текущего турнира / перед началом следующего) нужно определять:
                $tourneyStartYear = 2022;
                $tourneyEndYear = 2023;
                // - в layoutElements/header/shortHeader.php - от какого сезона турниры показываем по ссылкам в "Текущем сезоне"
                // - в captions отслеживать содержание параграфа типа "В таблице учтены матчи до...". Раз в год меняем содержание на "Таблица обновлена по итогам сезона ...". Также можно вписывать здесь указание на последнюю завершивуяся стадию турнира (например, "учтены все матчи групповых этапов"), но это и вовсе не обязательно.
                // - если делаем таблицы с фаворитами текущих турниров, в classes/TablePagesProperties.php определить наличие finishedTourneyParagraph
                // - если делаем таблицу с периодическим ранжиром, в classes/TablePagesProperties.php определить года в "keywordsContentPart" и "h1Content"
                // - для winners обновить $clubsList здесь
            }

        }

        // Нужно ещё поработать над определением переменной $seasonIsFinished, от к-рой зависит появление заголовка типа "Таблица обновлена по итогам сезона"
        // А, может быть, она и вовсе не нужна (если уж, как выясняется, нац. таблицы могут обновляться независимо от участия нац. команд в еврокубках)

        $lastAccountedMatchDate = "11.05.2023";

        // При изменении букмекерской котировки, на к-рую мы ориентируемся, для таблиц с фаворитами текущих турниров:
        // - в classes/TablePagesProperties.php определить число в bookmakersParagraph (на число, совпадающее с новой $bookmakersOddsDate)
        // обновить $clubsList здесь
        if ($ranging === "bookmakers") {

            if ($pageName === "champ_league_current") {
                $bookmakersOddsDate = "22.04.2023";
            } elseif ($pageName === "euroleague_current") {
                $bookmakersOddsDate = "22.04.2023";
            }

            if ($pageName === "champ_league_current") {
                $tourneyTitle = "Лига чемпионов";
                // $tourneyStage = "1/8 финала";
                // $tourneyStage = "1/4 финала";
                $tourneyStage = "1/2 финала";
            }
            elseif ($pageName === "euroleague_current") {
                $tourneyTitle = "Лига Европы";
                // $tourneyStage = "1/16 финала";
                // $tourneyStage = "1/8 финала";
                // $tourneyStage = "1/4 финала";
                $tourneyStage = "1/2 финала";
            }

        }

        { // Базовые списки клубов:
 
            if ($pageName === "winners") {
                $clubsList = [
                    "Реал Мадрид" => ["wins" => 14, "finals" => 3],
                    "Милан" => ["wins" => 7, "finals" => 4],
                    "Бавария" => ["wins" => 6, "finals" => 5],
                    "Ливерпуль" => ["wins" => 6, "finals" => 4],
                    "Барселона" => ["wins" => 5, "finals" => 3],
                    "Аякс" => ["wins" => 4, "finals" => 2],
                    "Интер Милан" => ["wins" => 3, "finals" => 2],
                    "Манчестер Юнайтед" => ["wins" => 3, "finals" => 2],
                    "Ювентус" => ["wins" => 2, "finals" => 7],
                    "Бенфика" => ["wins" => 2, "finals" => 5],
                    "Челси" => ["wins" => 2, "finals" => 1],
                    "Порто" => ["wins" => 2, "finals" => 0],   
                    "Ноттингем Форест" => ["wins" => 2, "finals" => 0],
                    "Боруссия Дортмунд" => ["wins" => 1, "finals" => 1],
                    "Олимпик Марсель" => ["wins" => 1, "finals" => 1],
                    "Стяуа" => ["wins" => 1, "finals" => 1],
                    "Гамбург" => ["wins" => 1, "finals" => 1],
                    "Селтик" => ["wins" => 1, "finals" => 1],
                    "Црвена звезда" => ["wins" => 1, "finals" => 0],
                    "ПСВ Эйндховен" => ["wins" => 1, "finals" => 0],
                    "Астон Вилла" => ["wins" => 1, "finals" => 0],
                    "Фейеноорд" => ["wins" => 1, "finals" => 0],
                ];
            }

            // Здесь важен порядок клубов
            elseif ($pageName === "champ_league_current") {
                $clubsList = [
                    "Манчестер Сити" => ["odds" => 1.75,],
                    "Реал Мадрид" => ["odds" => 4.5,],
                    "Интер Милан" => ["odds" => 7.5,],
                    "Милан" => ["odds" => 9,],                    
                    "Бавария" => ["odds" => 4.5,],
                    "Наполи" => ["odds" => 4.5,],
                    // "Пари Сен-Жермен" => ["odds" => 10,],
                    // "Ливерпуль" => ["odds" => 10,],                                        
                    "Челси" => ["odds" => 15,],
                    // "Тоттенхэм Хотспур" => ["odds" => 20,],
                    "Бенфика" => ["odds" => 15,],
                    // "Боруссия Дортмунд" => ["odds" => 50,],
                    // "Порто" => ["odds" => 75,],
                    // "РБ Лейпциг" => ["odds" => 100,],            
                    // "Айнтрахт Франкфурт" => ["odds" => 150,],
                    // "Брюгге" => ["odds" => 250,],            
                ];
            }

            // Здесь важен порядок клубов
            elseif ($pageName === "euroleague_current") {
                $clubsList = [                    
                    "Ювентус" => ["odds" => 2.9,],
                    "Рома" => ["odds" => 3.7,],
                    "Байер Леверкузен" => ["odds" => 4,],       
                    "Севилья" => ["odds" => 4.5,],                    
                    "Манчестер Юнайтед" => ["odds" => 2.4,],
                    "Спортинг Лиссабон" => ["odds" => 13,],     
                    "Фейеноорд" => ["odds" => 17,],     
                    "Унион Сент Жилуаз" => ["odds" => 35,],     
                ];
            }

            elseif ($pageName === "ukraine") {
                $actualCountryClubsList = [
                    "Динамо Киев" => ["seasons" => 52,],
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

            if ($ranging === "periodic") {

                $periodEndYear = $tourneyEndYear;
                // $periodEndYear = $tourneyStartYear;
        
                $yearsNumberToSubtract = $yearsNumber - 1;
                $periodStartYear = $periodEndYear - $yearsNumberToSubtract;
        
                require_once 'rangeInfo.php';
                $rangeInfo = getPeriodicRangeInfo(["range" => "periodic", "subrange" => ["periodStartYear" => $periodStartYear,], "clubsNumber" => $clubsNumber,]);
                $clubsList = $rangeInfo["range"];
                // echo "<pre>";
                // // var_dump($clubsList);
                // var_dump($rangeInfo);
                // echo "</pre>";
        
            }
            // elseif ($ranging === "mainRange") {
            elseif (($ranging === "mainRange") || ($ranging === "national")) {
        
                require_once 'rangeInfo.php';
                $rangeInfo = getPeriodicRangeInfo(["range" => "basic", "clubsNumber" => $clubsNumber,]);
                $clubsList = $rangeInfo["range"];
        
            }          

        }

    }


    $headDescriptionClubsNumberPhraseLastPart = "";
    if ($hasTourneyYearIndicationInHead) {
        $headDescriptionClubsNumberPhraseLastPart = " {$tourneyStartYear}/{$tourneyEndYear}";
    }
    if ($ranging === "periodic") {
        $headDescriptionClubsNumberPhraseLastPart = " {$descriptionPeriodWord} ({$periodStartYear} - {$periodEndYear})";
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
        <? if (($pageName === "champ_league_current") && ($curFileName === "table16.css") && (in_array($tourneyStage, ["1/4 финала", "1/2 финала", "Финал"]))): ?>
            <link rel="stylesheet" href="http://summarytables.ru/stylesheets/table8.css">
        <? else: ?>
            <link rel="stylesheet" href="http://summarytables.ru/stylesheets/<?=$curFileName?>">
        <? endif; ?>
    <? endforeach; ?>

</head>

<body class="football__body">

    <div class="football__background">

        <? require_once 'layoutElements/header/shortHeader.php'; // Шапка, две оранжевые полосы с навигацией ?>

        <main>

            <? // Заголовки
            
                require_once 'layoutElements/captions/captions.php'; // Заголовки (крупнейший из к-рых - 'ЛУЧШИЕ КЛУБЫ ЕВРОПЫ ЗА ВСЮ ИСТОРИЮ')

                // $seasonIsFinished = ($ranging === "national") ? true : false;
                $seasonIsFinished = false;

                printCaptions (["lastAccountedMatchDate" => $lastAccountedMatchDate, "captionsClubsNumberPhraseFirstPart" => $captionsClubsNumberPhraseFirstPart, "clubsNumberPhraseLastPart" => $clubsNumberPhraseLastPart, "clubsNumber" => $clubsNumber, "h1Content" => $h1Content, "clubsRangeExplanationHintText" => $clubsRangeExplanationHintText, "ranging" => $ranging, "bookmakersParagraph" => $bookmakersParagraph, "periodicRangeParagraph" => $periodicRangeParagraph, "screamerParagraph" => $screamerParagraph, "finishedTourneyParagraph" => $finishedTourneyParagraph, "seasonIsFinished" => $seasonIsFinished, "tourneyStartYear" => $tourneyStartYear, "tourneyEndYear" => $tourneyEndYear,]);

            ?>

            <? // Данные для таблицы:

                // if ($ranging === "national") {
                if (($ranging === "national") && ($pageName !== "ukraine")) {

                    $countryCodes = [
                        "russia" => "RUS",
                        // "ukraine" => "UKR",
                        "byelorussia" => "BLR",
                        "kazakhstan" => "KAZ",
                    ];

                    require_once 'classes/ActualCountryClubsList.php'; 
                    // Получение списка клубов данной страны (для национальных страниц (за исключением Украины пока))
                    $actualCountryClubsListClass = new ActualCountryClubsList(["pathToRoot" => "../../"]);
                    $actualCountryClubsList = $actualCountryClubsListClass->getActualCountryClubsList (["countryCode" => $countryCodes[$pageName],]);
                    // echo "<pre>";
                    // var_dump($actualCountryClubsList);
                    // echo "</pre>";

                }            

                require_once 'tableInfo.php'; // Получение содержания таблицы
                $tableInfo = getTableInfo (["clubsList" => $clubsList, "actualCountryClubsList" => $actualCountryClubsList ?? [],]);
                // echo "<pre>";
                // // var_dump($tableInfo);
                // // var_dump($tableInfo['actualCountryClubsList']);
                // // var_dump($tableInfo['clubsList']);
                // var_dump($tableInfo['pairsMatchesHistory']);
                // echo "</pre>";

                if ($ranging === "national") { // Выяснение списка национальных клубов, имеющих историю встреч с грандами. И списка грандов имеющих историю встреч с национальными клубами.

                    $filteredActualCountryClubsList = $fiteredBasicRangeClubsList = [];

                    foreach ($actualCountryClubsList as $curClubName => $curClubInfo) {

                        foreach ($tableInfo['pairsMatchesHistory'] as $curPairNamesStr => $curPairHistory) {

                            $curPairClubsNamesArr = explode(" - ", $curPairNamesStr);
                            $curNationalClubName = $curPairClubsNamesArr[0];

                            if ($curClubName === $curNationalClubName) {

                                if (($curPairHistory["firstVictories"] > 0) || ($curPairHistory["draws"] > 0) || ($curPairHistory["firstLesions"] > 0)) { // Если есть история встреч

                                    if ( ! (isset($filteredActualCountryClubsList[$curClubName])) ) {
                                        $filteredActualCountryClubsList[$curClubName] = $tableInfo['actualCountryClubsList'][$curClubName];
                                    }

                                    $curEuropeanClubName = $curPairClubsNamesArr[1];
                                    // $curEuroClubIndInBasicRange = array_search($curEuropeanClubName, array_keys($tableInfo['clubsList']));
                                    if ( ! (isset($fiteredBasicRangeClubsList[$curEuropeanClubName])) ) {
                                        $fiteredBasicRangeClubsList[$curEuropeanClubName] = $tableInfo['clubsList'][$curEuropeanClubName];
                                    }

                                }

                            }

                        }

                    }

                    // $tableInfo['clubsList'] = $fiteredBasicRangeClubsList;
                    // $tableInfo['actualCountryClubsList'] = $filteredActualCountryClubsList;

                }
                // echo "<pre>";
                // // var_dump($tableInfo['actualCountryClubsList']);
                // var_dump($tableInfo['clubsList']);
                // echo "</pre>";                

                require_once 'classes/WordForms.php'; // Файл для получения правильных форм слов

                $addClassesForMainTableHtml = "";

                if ($ranging === "bookmakers") {

                    require_once 'classes/Matches.php';
                    $matchesClass = new Matches();

                    require_once 'classes/Tourneys.php';

                    // Получение массива пар незавершённой стадии турнира:
                    {
                        $actualStagePairs = $matchesClass->getActualStagePairs(["tourneyTitle" => $tourneyTitle, "tourneyFinalYear" => $tourneyEndYear, "stage" => $tourneyStage,]);
                        // echo "<pre>";
                        // var_dump($actualStagePairs);
                        // echo "</pre>";
                    }

                    if ($tourneyTitle === "Лига чемпионов") {
                        $addClassesForMainTableHtml = " champs-league";
                    }

                }

                elseif ($pageName === "russia") {
                    $addClassesForMainTableHtml = " RUS";
                }

            ?>

            <? if ($hasRightBtn): ?>
            <div class="table-plus-right-buttons">
            <? endif; ?>

            <!-- Таблица: -->
            <table class="main-table<?=$addClassesForMainTableHtml?>">
                <tbody>

                <? // Данные о логотипах

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
                        // "SpL" => "SpL_light.png", // Не понравилась светлая версия в euroleague_current (на 6-й позиции в таблице)
                        "StL" => "StL_light.png",
                        // "Zen" => "Zen_light.png", // Не понравилась светлая версия в russia (на 3-й позиции в таблице)
                    ];

                    $clubsLists = ($ranging === "national") ? ['clubsList' => $tableInfo['clubsList'], 'actualCountryClubsList' => $tableInfo['actualCountryClubsList']] : ['clubsList' => $tableInfo['clubsList']];
                    $logotypesInfo = ['clubsList' => [], 'actualCountryClubsList' => []];
                    // Имя файла с картинкой логотипа:                    
                    foreach ($clubsLists as $curClubsListName => $curClubsList) {
                            foreach ($curClubsList as $curClubName => $curClubInfo) {
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
                                $logotypesInfo[$curClubsListName][$curClubName]["logoImageFile"] = $logoImageFile;
                                $logotypesInfo[$curClubsListName][$curClubName]["clubCssClassHtmlRecord"] = $clubCssClassHtmlRecord;
                            }
                    }
                    // echo "<pre>";
                    // var_dump($logotypesInfo);
                    // // var_dump($logotypesInfo['actualCountryClubsList']);
                    // echo "</pre>";
                  
                ?>

                    <tr class="logotypes">

                        <td colspan="3">
                            <? if (in_array($pageName, ["ukraine", "russia"])): ?>
                                <div class="change-range-text" title="Упорядочить иностранные клубы по алфавиту / по достижениям">
                                Упорядочить по алфавиту ▶
                                </div>                                
                            <? endif; ?>
                        </td>

                        <?
                            $number = 1;
                            if (in_array($pageName, ["byelorussia", "kazakhstan"])) {
                                $prevStepClubHasHistory = true;
                            }
                        ?>

                        <? foreach ($tableInfo['clubsList'] as $curClubNameInLogoRow => $curClubInfo): ?>

                            <? if ((in_array($pageName, ["byelorussia", "kazakhstan"])) && ( ! (in_array($curClubNameInLogoRow, array_keys($fiteredBasicRangeClubsList))) )): ?>
                                
                                <? if ($prevStepClubHasHistory === true): ?>
                                    <td>...</td>
                                    <? $prevStepClubHasHistory = false; ?>
                                <? endif; ?>

                            <? else: ?>

                                <?
                                    $curClubFullName = $curClubInfo["basicFullName"];
                                    $curClubAltNames = explode(",", $curClubInfo["altNames"]);
                                    $logotypesInfoCurClubInfo = $logotypesInfo['clubsList'][$curClubFullName] ?? [];
                                    if (empty($logotypesInfoCurClubInfo)) {
                                        foreach ($curClubAltNames as $curAltName) {
                                            if (isset($logotypesInfo['clubsList'][$curAltName])) {
                                                $logotypesInfoCurClubInfo = $logotypesInfo['clubsList'][$curAltName];
                                                break;
                                            }
                                        }
                                    }
                                ?>

                                <td>
                                    <span class="number"><?=$number?></span>
                                    <img alt="<?=$curClubInfo["shortName"]?>" src="../images/<?=$logotypesInfoCurClubInfo["logoImageFile"]?>" title="<?=$curClubInfo["shortName"]?>" class="football-logo-table<?=$logotypesInfoCurClubInfo["clubCssClassHtmlRecord"]?>">
                                </td>

                                <? $prevStepClubHasHistory = true; ?>

                            <? endif; ?>

                            <? $number++; ?>

                        <? endforeach; ?>

                        <td class="main-table_gap"></td>

                        <? if ($ranging === "mainRange"): ?>

                            <td class="main-table_criterion" title="Клубы ранжировались по следующей системе:
за победу в Лиге чемпионов с 2000-го года - 12 очков; за выход в финал - 9; выход в 1/2 финала - 6; выход в 1/4 финала - 3;
за победу в кубке/Лиге чемпионов до 2000-го года - 8 очков; за выход в финал - 6; выход в 1/2 финала - 4; выход в 1/4 финала - 2;
за победу в других еврокубках - 4 очка; за выход в финал - 3; выход в 1/2 финала - 2; выход в 1/4 финала - 1">
                                Очки
                            </td>

                        <? elseif ($ranging === "periodic"): ?>

                            <td class="main-table_criterion" title="Клубы ранжировались по следующей системе:
за победу в Лиге чемпионов - 6 очков; за выход в финал - 5; выход в 1/2 финала - 4; выход в 1/4 финала - 3; выход в 1/8 финала - 2; 
за победу в Лиге Европы - 1 очко">
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

                        <? elseif ($ranging === "national"): ?>

                            <td class="main-table_criterion" title="Количество сезонов с участием в еврокубках">
                                Сезоны
                            </td>

                        <? endif; ?>

                    </tr>

                    <? $rowNumber = 1; ?>

                    <? 
                        $verticalClubsList = $tableInfo['clubsList'];
                        if ($ranging === "national") {
                            // $verticalClubsList = (in_array($pageName, ["byelorussia", "kazakhstan"])) ? $filteredActualCountryClubsList : $tableInfo['actualCountryClubsList'];
                            $verticalClubsList = ($ranging === "national") ? $filteredActualCountryClubsList : $tableInfo['actualCountryClubsList'];
                        }
                        // echo "<pre>";
                        // echo "verticalClubsList:";
                        // var_dump($verticalClubsList);
                        // echo "</pre>";
                    ?>

                    <? foreach ($verticalClubsList as $curClubName => $curClubInfo): ?>

                        <?

                            if (in_array($pageName, ["byelorussia", "kazakhstan"])) {
                                $prevStepClubHasHistory = true;
                            }

                            $dropoutClubsClass = "";                            
                            if ($ranging === "bookmakers") {
                                $clubDroppedOut = false;
                                if (in_array($tourneyStage, ["1/2 финала", "ФИНАЛ"])) { // Определяем, не выбыл ли клуб из турнира
                                    if (!(in_array($curClubInfo["id"], array_keys($actualStagePairs)))) {
                                        $dropoutClubsClass = " dropout";
                                        $clubDroppedOut = true;
                                    }
                                }
                            }
                            
                        ?>                        
                        
                        <tr class="<?=$curClubInfo['code']?><?=$dropoutClubsClass?>">

                            <td class="number"><?=$rowNumber?></td>

                                <?

                                    $actualClubsListName = ($ranging === "national") ? 'actualCountryClubsList' : 'clubsList';

                                    $curClubFullName = $curClubInfo["basicFullName"];
                                    $curClubAltNames = explode(",", $curClubInfo["altNames"]);
                                    $logotypesInfoCurClubInfo = $logotypesInfo[$actualClubsListName][$curClubName] ?? [];
                                    if (empty($logotypesInfoCurClubInfo)) {
                                        foreach ($curClubAltNames as $curAltName) {
                                            if (isset($logotypesInfo[$actualClubsListName][$curAltName])) {
                                                $logotypesInfoCurClubInfo = $logotypesInfo[$actualClubsListName][$curAltName];
                                                break;
                                            }
                                        }
                                    }

                                ?>                            

                            <td>
                                <img alt="<?=$curClubInfo["shortName"]?>" src="../images/<?=$logotypesInfoCurClubInfo["logoImageFile"]?>" title="<?=$curClubInfo["shortName"]?>" class="football-logo-table<?=$logotypesInfoCurClubInfo["clubCssClassHtmlRecord"]?>">
                            </td>

                            <td>
                                <?
                                    $clubNamesWLongParts = [
                                        "Черноморец Новороссийск",
                                        "Днепр Днепропетровск",
                                    ];
                                ?>
                                <? if (($pageName === "russia") && (in_array($curClubInfo["basicFullName"], $clubNamesWLongParts))): ?>
                                    <?
                                        $clubNameArr = explode(" ", $curClubInfo["basicFullName"]);
                                    ?>
                                    <div class="club-name">
                                        <?=$clubNameArr[0]?>
                                        <span class="long-club-title"><?=$clubNameArr[1]?></span>
                                    </div>
                                <? else: ?>
                                    <div class="club-name"><?=$curClubInfo["basicFullName"]?></div>
                                <? endif; ?>
                            </td>

                            <? foreach ($tableInfo['clubsList'] as $curClubNameInTableBodyCycle => $innerCycleClubInfo): ?>

                                <?
                                    $secClubFullName = $innerCycleClubInfo["basicFullName"];
                                ?>

                                <? if ($curClubInfo["basicFullName"] === $secClubFullName): // Для ячеек, где показываем эмблему клуба ?>

                                    <td>
                                        <img alt="<?=$curClubInfo["shortName"]?>" src="../images/<?=$logotypesInfoCurClubInfo["logoImageFile"]?>" title="<?=$curClubInfo["shortName"]?>" class="football-logo-table<?=$logotypesInfoCurClubInfo["clubCssClassHtmlRecord"]?>">
                                    </td>

                                <? else: ?>


                                    <? if ((in_array($pageName, ["byelorussia", "kazakhstan"])) && ( ! (in_array($curClubNameInTableBodyCycle, array_keys($fiteredBasicRangeClubsList))) )): ?>
                                
                                        <? if ($prevStepClubHasHistory === true): ?>
                                            <td></td>
                                            <? $prevStepClubHasHistory = false; ?>
                                        <? endif; ?>

                                    <? else: ?>

                                    <?

                                        $prevStepClubHasHistory = true;

                                        $curPairCode = "{$curClubInfo["code"]}{$innerCycleClubInfo["code"]}";

                                        $curPairClubTitlesStr = "{$curClubName} - {$secClubFullName}";                                        
                                        $curPairHistory = $tableInfo['pairsMatchesHistory'][$curPairClubTitlesStr];
                                        $secClubNameGender = $tableInfo['clubsList'][$secClubFullName]["gender"];
                                        if (empty($curPairHistory)) {
                                            $secClubAltNames = explode(",", $innerCycleClubInfo["altNames"]);
                                            foreach ($secClubAltNames as $curAltName) {
                                                $curPairClubTitlesStr = "{$curClubName} - {$curAltName}";
                                                if (isset($tableInfo['pairsMatchesHistory'][$curPairClubTitlesStr])) {
                                                    $curPairHistory = $tableInfo['pairsMatchesHistory'][$curPairClubTitlesStr];
                                                    $secClubNameGender = $tableInfo['clubsList'][$curAltName]["gender"];
                                                    break;
                                                }
                                            }
                                        }

                                        $hasHistory = (empty($curPairHistory["duels"])) ? false : true;
                                        $curPairHasHistoryClass = ($hasHistory === true ) ? "has-history" : "no-history";
                                        $victoriesWord = WordForms::getWordLikePobeda(["word" => "победа", "number" => $curPairHistory["firstVictories"]]);
                                        $duelsVictoriesWord = WordForms::getWordLikePobeda(["word" => "победа", "number" => $curPairHistory["duels"]["firstClubDuelsVictories"]]);
                                        $drawsWord = WordForms::getWordLikeDraw(["word" => "ничья", "number" => $curPairHistory["draws"]]);
                                        $lesionsWord = WordForms::getWordLikeLesion(["word" => "поражение", "number" => $curPairHistory["firstLesions"]]);
                                        $duelsLesionsWord = WordForms::getWordLikeLesion(["word" => "поражение", "number" => $curPairHistory["duels"]["firstClubDuelsLesions"]]);

                                        // $secClubNameGender = $tableInfo['clubsList'][$secClubFullName]["gender"];
                                        $correctClubNameInDuels = WordForms::getGenitiveWord(["word" => $innerCycleClubInfo["shortName"], "gender" => $secClubNameGender,]);
                                        $secClubGenitiveName = $correctClubNameInDuels["clubNameCorrForm"] ?? $correctClubNameInDuels; // В случае, если в WordForms передавалось имя типа "Боруссия Д" здесь мы получим в ответ массив, элементом к-рого с ключом "clubNameCorrForm" будет слово "Боруссии". В большинстве же случаев - просто сразу получим нужную форму названия клуба.
                                        $cityPartClubName = $correctClubNameInDuels["cityPart"] ?? ""; // Для "Боруссия Д" здесь мы получим "Д". В остальных случаях - ничего.

                                        $resultsCellContent = ($hasHistory === true) ? 
                                            "<p class=\"games-score\">+{$curPairHistory["firstVictories"]} ={$curPairHistory["draws"]} -{$curPairHistory["firstLesions"]}</p>
                                            <p class=\"goals-difference\">{$curPairHistory["firstGoals"]} - {$curPairHistory["secondGoals"]}</p>" 
                                            : 
                                            "<p class=\"games-score\">+ = -</p>
                                            <p class=\"goals-difference\">-</p>
                                        ";                                        

                                        $specialCasesClubsNames = [
                                            "Црвена звезда",
                                            "Реал Сосьедад",
                                            "Астон Вилла",
                                            "Унион Сент Жилуаз",
                                        ];
                                        if ((mb_strpos($curClubInfo["shortName"], " ") !== false) && (!(in_array($curClubInfo["shortName"], $specialCasesClubsNames)))) { // Для названий типа "Боруссия Д", "Динамо К". Работа над получением корректной формы этих названий в именительном падеже с учётом кавычек. Для первой команды в паре.

                                            $clubNameWordsArr = explode(" ", $curClubInfo["shortName"]);
                                            $justClubName = $clubNameWordsArr[0];
                                            $cityPart = $clubNameWordsArr[1];                                        

                                        } else {
                                            $justClubName = $curClubInfo["shortName"];
                                            $cityPart = "";
                                        }
                                        if ((mb_strpos($curClubInfo["shortName"], " ") !== false) && (!(in_array($innerCycleClubInfo["shortName"], $specialCasesClubsNames)))) { // Для названий типа "Боруссия Д", "Динамо К". Работа над получением корректной формы этих названий в именительном падеже с учётом кавычек. Для второй команды в паре.

                                            $rivalNameWordsArr = explode(" ", $innerCycleClubInfo["shortName"]);
                                            $rivalJustClubName = $rivalNameWordsArr[0];
                                            $rivalCityPart = $rivalNameWordsArr[1];                                            

                                        } else {
                                            $rivalJustClubName = $innerCycleClubInfo["shortName"];
                                            $rivalCityPart = "";
                                        }
                                        
//                                         $resultsHintContent = ($hasHistory === true) ? 
//                                             "«{$curClubInfo["shortName"]}» - «{$innerCycleClubInfo["shortName"]}»
// {$curPairHistory["firstVictories"]} {$victoriesWord}, {$curPairHistory["draws"]} {$drawsWord}, {$curPairHistory["firstLesions"]} {$lesionsWord}
// Кликните, чтобы узнать подробности" 
//                                             : 
//                                             "«{$curClubInfo["shortName"]}» - «{$innerCycleClubInfo["shortName"]}»
// {$curPairHistory["firstVictories"]} {$victoriesWord}, {$curPairHistory["draws"]} {$drawsWord}, {$curPairHistory["firstLesions"]} {$lesionsWord}";
                                        $resultsHintContent = ($hasHistory === true) ? 
                                            "«{$justClubName}»{$cityPart} - «{$rivalJustClubName}»{$rivalCityPart}
{$curPairHistory["firstVictories"]} {$victoriesWord}, {$curPairHistory["draws"]} {$drawsWord}, {$curPairHistory["firstLesions"]} {$lesionsWord}
Кликните, чтобы узнать подробности" 
                                            : 
                                            "«{$curClubInfo["shortName"]}» - «{$innerCycleClubInfo["shortName"]}»
{$curPairHistory["firstVictories"]} {$victoriesWord}, {$curPairHistory["draws"]} {$drawsWord}, {$curPairHistory["firstLesions"]} {$lesionsWord}";                                        

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
                                
                                <? endif; ?>

                            <? endforeach; ?>
                            
                            <td class="main-table_gap"></td>

                            <!-- Последняя колонка с критерием ранжирования, например, "Очки": -->
                            <? if (in_array($ranging, ["mainRange", "periodic"])): ?>

                                <?

                                    $curClubFullName = $curClubInfo["basicFullName"];
                                    $curClubAltNames = explode(",", $curClubInfo["altNames"]);
                                    $сurClubPointsInfo = $clubsList[$curClubFullName]["points"] ?? [];
                                    if (empty($сurClubPointsInfo)) {
                                        foreach ($curClubAltNames as $curAltName) {
                                            if (isset($clubsList[$curAltName]["points"])) {
                                                $сurClubPointsInfo = $clubsList[$curAltName]["points"];
                                                break;
                                            }
                                        }
                                    }
                                                        
                                    $corrPointWordForm = WordForms::getWordLikePoint(["word" => "очко", "number" => $сurClubPointsInfo]);

                                ?>

                                <td class="main-table_criterion" title="<?=$curClubInfo["shortName"]?>: <?=$сurClubPointsInfo?> <?=$corrPointWordForm?>">
                                    <? if ($ranging === "mainRange"): ?>
                                        <a href="range.html">
                                    <? endif; ?>
                                            <span class="main-table_criterion"><?=$сurClubPointsInfo?></span>
                                    <? if ($ranging === "mainRange"): ?>
                                        </a>
                                    <? endif; ?>                                        
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

                                <? if ($clubDroppedOut === false): ?>
                                    <td class="main-table_criterion" title="<?=$curClubInfo["shortName"]?>: <?=$curClubOdds?>. Шансы от <?=$bookmakersOddsDate?>">
                                        <span class="main-table_criterion">
                                            <?=$curClubOdds?>
                                        </span>
                                    </td>
                                <? elseif ($clubDroppedOut === true): ?>
                                    <td class="main-table_criterion">
                                    </td>
                                <? endif; ?>

                            <? elseif ($ranging === "national"): ?>

                                <?
                                    $curClubSeasons = $actualCountryClubsList[$curClubName]["seasons"];
                                    $corrSeasonWordForm = WordForms::getWordLikeFinal(["word" => "сезон", "number" => $curClubSeasons]);                                    
                                ?>                                

                                <td class="main-table_criterion" title="<?=$curClubInfo["shortName"]?>: <?=$curClubSeasons?> <?=$corrSeasonWordForm?> с участием в еврокубках">
                                    <span class="main-table_criterion">
                                        <?=$curClubSeasons?>
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
            
            <? if ($pageName === "russia"): // Республиканские таблицы ?>

                <hr>

                <section class="soviet-republics">

                    <h3>
                        РЕСПУБЛИКИ СССР
                    </h3>

                    <p class="table-explanation">
                        Матчи до 1991 года
                    </p>

                    <?
                        $sovietRepublicsInfo = [
                            "ukraine" => [
                                "h2" => "УКРАИНА",
                                "reptableAddClassHtml" => " UKR",
                                "code" => "UKR",
                            ],
                            "georgia" => [
                                "h2" => "ГРУЗИЯ",
                                "reptableAddClassHtml" => " georgia",
                                "code" => "GEO",
                            ],
                            "lithuania" => [
                                "h2" => "ЛИТВА",
                                "reptableAddClassHtml" => " lithuania",
                                "code" => "LTU",
                            ],
                            "armenia" => [
                                "h2" => "АРМЕНИЯ",
                                "reptableAddClassHtml" => " armenia",
                                "code" => "ARM",
                            ],
                        ];
                    ?>

                    <? foreach ($sovietRepublicsInfo as $curRepublic): ?>

                        <?
                            // Получение данных для республиканских таблиц на странице СССР

                            {

                                // require_once 'classes/ActualCountryClubsList.php'; 
                                // Получение списка клубов данной страны (для национальных страниц)
                                $actualCountryClubsListClass = new ActualCountryClubsList(["pathToRoot" => "../../"]);
                                $actualRepublicClubsList = $actualCountryClubsListClass->getActualCountryClubsList (["countryCode" => $curRepublic["code"], "lastYear" => 1992,]);
                                echo "<pre>";
                                var_dump($actualRepublicClubsList);
                                echo "</pre>";
          
                            }

                            // require_once 'tableInfo.php'; // Получение содержания таблицы
                            // $tableInfo = getTableInfo (["clubsList" => $clubsList, "actualCountryClubsList" => $actualCountryClubsList ?? [],]);
                            // echo "<pre>";
                            // // var_dump($tableInfo);
                            // // var_dump($tableInfo['actualCountryClubsList']);
                            // // var_dump($tableInfo['clubsList']);
                            // var_dump($tableInfo['pairsMatchesHistory']);
                            // echo "</pre>";
                        ?>                        

                        <h2>
                            <?= $curRepublic["h2"] ?>
                        </h2>

                        <table class="main-table republican-table<?=$curRepublic["reptableAddClassHtml"]?>">
                            <tbody>

                                <tr class="logotypes">

                                    <td colspan="3"></td>
                                
                                </tr>

                            </tbody>
                        </table>

                        <hr>

                    <? endforeach; ?>

                </section class="soviet-republics">

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