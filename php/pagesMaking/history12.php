
<?
    $lastAccountedMatchDate = "27.10.2022";
?>

<!DOCTYPE html>
<html lang="ru" class="football">

<head>

    <meta charset="utf-8">
    <meta name="author" content="Edwards, Allegro, Edwards75, Allegro75, Oleg Otkidach">
    <meta name="author" content="Олег Откидач">
    <meta name="description" content="Сводная таблица истории противостояний европейских футбольных клубов в рамках еврокубков. 12 лучших клубов.">
    <meta name="keywords" content="Футбол. Еврокубки. Европа. 
    Личные встречи. Личные счета. vs. История игр. История противостояний.  
    Сводная таблица. Таблица-'шахматка'. Статистика. История. Результаты. 
    Клубы. Суперклубы. Команды. 
    Реал. Барселона. Ливерпуль. Манчестер Юнайтед. Бавария. Ювентус. Аякс. Милан. Интер.
    Лига чемпионов. Кубок чемпионов. Лига Европы. Кубок УЕФА. Кубок кубков. Суперкубок.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/football_ball.svg" type="image/x-icon">
    <title>История. Личные счета суперклубов. Сводная таблица</title>
    <link rel="stylesheet" href="stylesheets/football__body.css">
    <link rel="stylesheet" href="stylesheets/cap-wo-nav.css">
    <link rel="stylesheet" href="stylesheets/navigation.css">
    <link rel="stylesheet" href="stylesheets/captions.css">
    <link rel="stylesheet" href="stylesheets/table12.css">
    <link rel="stylesheet" href="stylesheets/duel-button-lower.css">
    <link rel="stylesheet" href="stylesheets/settings.css">
    <link rel="stylesheet" href="stylesheets/donate.css">
    <link rel="stylesheet" href="stylesheets/footer.css">

</head>

<body class="football__body">

    <div class="football__background">

        <? require_once 'layoutElements/header/shortHeader.php'; // Шапка, две оранжевые полосы с навигацией ?>

        <main>

            <? 
                require_once 'layoutElements/captions/history12.php'; // Заголовки (крупнейший из к-рых - 'ЛУЧШИЕ КЛУБЫ ЕВРОПЫ ЗА ВСЮ ИСТОРИЮ')
                printCaptions (["lastAccountedMatchDate" => $lastAccountedMatchDate]);
            ?>



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

                    <!-- <div class="random-buttons__div gap"></div> -->

                    <div class="random-buttons__div random-onload">
                        <label for="random-onload__input">
                            <input type="checkbox" id="random-onload__input">
                            <span class="random-onload__text">
                                Показывать случайную пару при загрузке страницы
                            </span>
                        </label>
                    </div>

                    <!-- </div> -->
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

    <script src="scripts/showSmallTableOnCellClick.js"></script>
    <script src="scripts/showHideDuels.js"></script>
    <script src="scripts/cellsColoring.js"></script>
    <script src="scripts/coloringOnLoad.js"></script>
    <script src="scripts/randPairOnLoad.js"></script>
    <script src="scripts/randomWindowOnClick.js"></script>
    <script src="scripts/duelsOnLoad.js"></script>
    <!-- <script src="scripts/service/service_rebuildTable.js"></script> -->
    
</body>

</html>    