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



 
//    
//Делаем ПЕРЕКЛЮЧАТЕЛЬ ЧИСЛА в таблице:
//

//Задаём js-имена кнопок переключателя:

const minimumOfClubs = document.querySelector('.selector button.min');
const lessClubs = document.querySelector('.selector button.less');
const clubsChoise = document.querySelector('.selector button.choice');
const moreClubs = document.querySelector('.selector button.more');
const maximumOfClubs = document.querySelector('.selector button.max');

//Делаем функции меняющие количество клубов(clubsQuantity) в переключателе:

minimumOfClubs.onclick = function () {    
    clubsQuantity = 2;
    clubsChoise.innerHTML = clubsQuantity;
    rebuildTable(clubsQuantity);
};
lessClubs.onclick = function () {
    if (clubsQuantity > 2) {
        clubsQuantity -= 1;
        clubsChoise.innerHTML = clubsQuantity;
        rebuildTable(clubsQuantity);
    }
};
moreClubs.onclick = function () {
    if (clubsQuantity < 20) {
        clubsQuantity += 1;
        clubsChoise.innerHTML = clubsQuantity;
        rebuildTable(clubsQuantity);
    }
};
maximumOfClubs.onclick = function () {    
    clubsQuantity = 20;
    clubsChoise.innerHTML = clubsQuantity;
    rebuildTable(clubsQuantity);
};

clubsChoise.onclick = function () {
    rebuildTable(clubsQuantity);
};




// //
// //ФУНКЦИЯ для изменения ЧИСЛА клубов в таблице
// Функция переделана из старой (к-рая работает в других файлах), 
// в к-рой одновременно уменьшались и колонки, и строки.
// У нас здесь число строк остаётся всегда одинаковым.
// //

const tableRowsQuantity = table.rows.length;
const tableColumnsQuantity = table.rows[1].cells.length;

const rebuildTable = (clubsQuantity) => {

//     //Для начала открываем все скрытые ячейки:
    let hiddenElements = table.querySelectorAll('td[hidden], tr[hidden]');
    for (i = 0; i < hiddenElements.length; i++) {
        hiddenElements[i].hidden = false;
    };

//     //Теперь перебираем таблицу и скрываем ненужное:
//     //

// (коммент от 12.02.20)
// Раньше сначала скрывались лишние строки:

// (более раниий коммент)    
//Сначала скрываем лишние строки, начиная с последней:
    // for (let i = tableRowsQuantity - 1; i > clubsQuantity; i -= 1) {
    //     table.rows[i].hidden = true;
    // };

//     //А когда доходим до строки, к-рую скрывать уже не надо,
//     //начинаем перебирать строки,
    for (let i = tableRowsQuantity - 1; i >= 0; i -= 1) {
//         //а внутри них перебирать уже ячейки, начиная с последней:
        for (let indexOfCell = table.rows[i].cells.length - 1; 
//             //пока не дойдём до ячейки, к-рую скрывать не надо:
            indexOfCell > table.rows[i].cells.length - tableColumnsQuantity + 2 + clubsQuantity;
            indexOfCell -= 1) {
//                 //ну, а пока не дошли, скрываем ячейки:
                table.rows[i].cells[indexOfCell].hidden = true;
            };
    }; 
};




// //Определяем переменную clubsQuantity (иначе при попытке перестроить таблицу кнопками
// //будет вылезать ошибка):
let clubsQuantity = 10;
// //И перестраиваем полную таблицу на 10 клубов:
rebuildTable(10);



    
// Переключатель в дуэльный вид:
let results = document.querySelectorAll('.results');
let duels = document.querySelectorAll('.duels');
const duelsSwitch = document.querySelector('.duel-button button.results-duels-switch');

duelsSwitch.onclick = function () {showHideDuels();};
const showHideDuels = () => {
    for (i = 0; i < results.length; i++) {
        results[i].hidden = !results[i].hidden;
        duels[i].hidden = !duels[i].hidden; 
    }
};
