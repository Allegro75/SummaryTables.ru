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

//
//Для всплытия окон по клику на ячейку для УКРАИНЫ:
//
var ukraine = document.querySelector('table.ukraine');
ukraine.onclick = function() {
    var target = event.target;
    while (target != ukraine) {
        if (target.getAttribute('class') == 'statistics has-history') {
            var ukrTableDataId = target.getAttribute('id');
            var urlInWindowOpen = 'football-small-tables/' +
            ukrTableDataId + '.html';
            window.open(urlInWindowOpen, '', 'width=650px, height=900px');
            return;
            }
        target = target.parentNode;
        }
    };

//
//Для всплытия окон по клику на ячейку для ГРУЗИИ:
//
var georgia = document.querySelector('table.georgia');
georgia.onclick = function() {
    var target = event.target;
    while (target != georgia) {
        if (target.getAttribute('class') == 'statistics has-history') {
            var ukrTableDataId = target.getAttribute('id');
            var urlInWindowOpen = 'football-small-tables/' +
            ukrTableDataId + '.html';
            window.open(urlInWindowOpen, '', 'width=650px, height=900px');
            return;
            }
        target = target.parentNode;
        }
    };

//
//Для всплытия окон по клику на ячейку для АРМЕНИИ:
//
var armenia = document.querySelector('table.armenia');
armenia.onclick = function() {
    var target = event.target;
    while (target != armenia) {
        if (target.getAttribute('class') == 'statistics has-history') {
            var ukrTableDataId = target.getAttribute('id');
            var urlInWindowOpen = 'football-small-tables/' +
            ukrTableDataId + '.html';
            window.open(urlInWindowOpen, '', 'width=650px, height=900px');
            return;
            }
        target = target.parentNode;
        }
    };    

    
// Переключатель в дуэльный вид:
let results = document.querySelectorAll('.results');
let duels = document.querySelectorAll('.duels');
const duelsSwitch = document.querySelector('.duel-button button.results-duels-switch');
const lowDuelsSwitch = document.querySelector('.button-normal button.results-duels-switch');

duelsSwitch.onclick = function () {showHideDuels();};
const showHideDuels = () => {
    for (let i = 0; i < results.length; i++) {
        results[i].hidden = !results[i].hidden;
        duels[i].hidden = !duels[i].hidden; 
    }
};

lowDuelsSwitch.onclick = function () {showHideDuels();};