            
<?            

function printCaptions ($opts = []) {

    $lastAccountedMatchDate = $opts['lastAccountedMatchDate'];
    $clubsNumberPhraseLastPart = $opts['clubsNumberPhraseLastPart'];
    $clubsNumber = $opts['clubsNumber'];

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
                    ЛУЧШИЕ КЛУБЫ ЕВРОПЫ ЗА ВСЮ ИСТОРИЮ
                </h1>

                <p class=\"captions__explanation captions__explanation_12clubs\" title=\"Клубы ранжировались по следующей системе:
за победу в Лиге чемпионов с 2000-го года - 12 очков; за выход в финал - 9; выход в 1/2 финала - 6; выход в 1/4 финала - 3;
за победу в кубке/Лиге чемпионов до 2000-го года - 8 очков; за выход в финал - 6; выход в 1/2 финала - 4; выход в 1/4 финала - 2;
за победу в других еврокубках - 4 очка; за выход в финал - 3; выход в 1/2 финала - 2; выход в 1/4 финала - 1\">
                    <a href=\"range.html\">
                        <span class=\"captions__explanation_circle\">&#8226;</span>
                        <span class=\"captions__explanation_larger\">{$clubsNumber}</span> {$clubsNumberPhraseLastPart}
                        <span class=\"captions__explanation_circle\">&#8226;</span>
                    </a>
                </p>

                <p class=\"captions__explanation\">
                    <span class=\"captions__explanation_circle\">&#8226;</span>                
                        <!-- Таблица обновлена по итогам сезона 2021/2022 -->
                        Учтены матчи до {$lastAccountedMatchDate} включительно
                    <span class=\"captions__explanation_circle\">&#8226;</span>
                </p>  
            </section>";

}        