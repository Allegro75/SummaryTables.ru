            
<?            

function printCaptions ($opts = []) {

    $lastAccountedMatchDate = $opts['lastAccountedMatchDate'];
    $clubsNumberPhraseLastPart = $opts['clubsNumberPhraseLastPart'];
    $clubsNumber = $opts['clubsNumber'];
    $twelweClubsExplanationClassHtmlRecord = "";
    if ($clubsNumber == 12) {
        $twelweClubsExplanationClassHtmlRecord = " captions__explanation_12clubs";
    }    
    $h1Content = $opts['h1Content'];
    $clubsRangeExplanationHintText = $opts['clubsRangeExplanationHintText'];
    $bookmakersParagraph = $opts['bookmakersParagraph'];
    $screamerParagraph = $opts['screamerParagraph'];
    $finishedTourneyParagraph = $opts['finishedTourneyParagraph'];
    $clubsRangeExplanationHintHtmlRecord = empty($clubsRangeExplanationHintText) ? "" : " title=\"{$clubsRangeExplanationHintText}\"";
    $ranging = $opts['ranging'];
    $hrefFromClubsNumber = ["", ""];
    if ($ranging === "mainRange") {
        $hrefFromClubsNumber = ["<a href=\"range.html\">", "</a>"];
    }

    $clubsNumberParagraph = $lastDateParagrapContenthLastPart = "";
    $lastDateParagrapContenthFirstPart = "Учтены";
    if ($ranging !== "bookmakers") {
        
        // Формируем параграф типа "36 лучших клубов" для всех страниц, кроме страниц с фаворитами
        $clubsNumberParagraph = 
            "<p class=\"captions__explanation{$twelweClubsExplanationClassHtmlRecord}\"{$clubsRangeExplanationHintHtmlRecord}>
                {$hrefFromClubsNumber[0]}
                    <span class=\"captions__explanation_circle\">&#8226;</span>
                    <span class=\"captions__explanation_larger\">{$clubsNumber}</span> {$clubsNumberPhraseLastPart}
                    <span class=\"captions__explanation_circle\">&#8226;</span>
                {$hrefFromClubsNumber[1]}
            </p>
        ";

        $lastDateParagrapContenthLastPart = " (учтены все матчи групповых этапов сезона 2022/2023)";
        $lastDateParagrapContenthFirstPart = "В таблице учтены";

    }
    

    $for36clubsCaptionsPart = ""; // Часть заголовков, используемая только на странице с 36 клубами
    if ($clubsNumber == 36) {
        $for36clubsCaptionsPart = 
        "<p class=\"captions__explanation\">
            <span class=\"captions__explanation_circle\">&#8226;</span>
            Счёт в таблице представлен в <em>дуэльном</em> виде.
            <br> Дуэль - непосредственное столкновение двух команд в ходе турнира.
            <br> В дуэли побеждает тот, кто проходит дальше в кубковом турнире; либо выигрывает турнир (для
            финалов); либо для групповых этапов - проходит в стадию более высокую, чем соперник по дуэли.
            <span class=\"captions__explanation_circle\">&#8226;</span>
        </p>

        <p class=\"captions__explanation\">
            <span class=\"captions__explanation_circle\">&#8226;</span>
            По <em>клику</em> на ячейку таблицы открывается подробная история данной пары, включающая итоги и
            список результатов в традиционном виде.
            <span class=\"captions__explanation_circle\">&#8226;</span>
        </p>";
    }

    echo 
            "<!-- Заголовки -->
            <section class=\"captions\">

                <h2 class=\"captions__h2\">
                    ИСТОРИЯ ПРОТИВОСТОЯНИЙ ФУТБОЛЬНЫХ КЛУБОВ В ЕВРОКУБКАХ. СВОДНАЯ ТАБЛИЦА
                </h2>

                <p class=\"captions__explanation\">
                    <span class=\"captions__explanation_circle\">&#8226;</span>
                    Учитывались матчи только в рамках официальных европейских клубных турниров:
                    кубка чемпионов, лиги чемпионов, кубка кубков, кубка ярмарок, кубка УЕФА, лиги Европы, суперкубка
                    <span class=\"captions__explanation_circle\">&#8226;</span>
                </p>

                <p class=\"captions__table-explanation\">
                    <span class=\"captions__explanation_circle\">&#8226;</span>
                    По клику на ячейку таблицы открывается подробная история данной пары
                    <span class=\"captions__explanation_circle\">&#8226;</span>
                </p>

                <h1 class=\"captions__h1\">
                    {$h1Content}
                </h1>

                {$bookmakersParagraph}

                {$clubsNumberParagraph}

                <p class=\"captions__explanation\">
                    <span class=\"captions__explanation_circle\">&#8226;</span>                
                        <!-- Таблица обновлена по итогам сезона 2021/2022 -->
                        {$lastDateParagrapContenthFirstPart} матчи до {$lastAccountedMatchDate} включительно{$lastDateParagrapContenthLastPart}
                    <span class=\"captions__explanation_circle\">&#8226;</span>
                </p>

                {$screamerParagraph}
                {$finishedTourneyParagraph}
                
                {$for36clubsCaptionsPart}

            </section>";

}        