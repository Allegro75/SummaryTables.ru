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
//Для всплытия окон по клику на ячейку для ЛИТВЫ:
//
var lith = document.querySelector('table.lithuania');
lith.onclick = function() {
    var target = event.target;
    while (target != lith) {
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


// Служебные скрипты:

// Для удаления ячеек с "ПСЖ" и "Севильей":

// for (let ri = 1; ri < table.rows.length; ri += 1) {
//     for (let ci = 0; ci <= table.rows[ri].cells.length; ci +=1) {
//         if ( (table.rows[ri].cells[ci]) && ( table.rows[ri].cells[ci].getAttribute('id') !== null ) ) {
//             let currentCellID = table.rows[ri].cells[ci].getAttribute('id');
//             if ( currentCellID.includes('PSG', 3) ||
//             currentCellID.includes('Sev', 3) ) {
//                 table.rows[ri].cells[ci].classList.add('for-deleting');
//             }
//         }
//     }
// }

// const forDeleting = document.querySelectorAll('.for-deleting');

// forDeleting.forEach(item => item.remove());


// Для перестройки оставшейся таблицы с 18 клубами в правильном порядке
// (предварительно надо расставить в 18-ти логотипах (2 лишних удалить) номера последовательно с 1 до 18
// в соответствии с порядком команд в новом ранжире, игнорируя пока пропуски):

// for (let rangeNum = 5; rangeNum <= 18; rangeNum ++) {
//     for (let cellIndInLogoRow = 5; cellIndInLogoRow <= 18; cellIndInLogoRow ++) {
//         if (table.rows[0].cells[cellIndInLogoRow].querySelector('span').textContent == rangeNum) {

//             table.rows[0].cells[rangeNum - 1].after(table.rows[0].cells[cellIndInLogoRow]);

//             for (let ri = 1; ri <= 13; ri ++) {
//                 table.rows[ri].cells[rangeNum + 1].after(table.rows[ri].cells[cellIndInLogoRow + 2]);
//             }

//             break;
//         }
//     }
// };


// Для вставки полурыбных (скопированных с колонки "ПСВ") ячеек во все строки:

// for (let ri = 1; ri < table.rows.length; ri ++) {
//     let newCell = table.rows[ri].cells[20].cloneNode(true);
//     let rowID = table.rows[ri].cells[3].getAttribute('id').slice(0, 3);
//     newCell.id = `${rowID}Rom`;
//     let allDivsInCell = newCell.querySelectorAll('div');
//     let newText1 = allDivsInCell[0].getAttribute('title').replace('ПСВ', 'Рома');
//     allDivsInCell[0].setAttribute('title', newText1);
//     let newText2 = allDivsInCell[1].getAttribute('title').replace('ПСВ', 'Ромы');
//     allDivsInCell[1].setAttribute('title', newText2);
//     table.rows[ri].cells[25].after(newCell);
// }

