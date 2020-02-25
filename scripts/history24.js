//
//Пробую делать отдельный файл со скриптами для history
//


//
//Для ВСПЛЫТИЯ окон с подробной статистикой по клику на ячейку большой таблицы:
//

var table = document.querySelector('table.main-table');
table.onclick = function() {
    var target = event.target;
    while (target != table) {
        if (target.getAttribute('class') == 'statistics has-history') {
            var tableDataId = target.getAttribute('id');
            var urlInWindowOpen = 'football-small-tables/' +
            tableDataId + '.html';
            window.open(urlInWindowOpen, '', 'width=650px, height=900px');
            return;
            }
        target = target.parentNode;
        }
    };


    
// Переключатель в ДУЭЛЬНыЙ вид:
let results = document.querySelectorAll('.results');
let duels = document.querySelectorAll('.duels');
const duelsSwitch = document.querySelector('.duel-button button.results-duels-switch');
const lowDuelsSwitch = document.querySelector('.button-normal button.results-duels-switch');

duelsSwitch.onclick = function () {showHideDuels();};
const showHideDuels = () => {
    for (i = 0; i < results.length; i++) {
        results[i].hidden = !results[i].hidden;
        duels[i].hidden = !duels[i].hidden; 
    }
};

lowDuelsSwitch.onclick = function () {showHideDuels();};

