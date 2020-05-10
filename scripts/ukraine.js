
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

 
   
// Переключатель в дуэльный вид:
let results = document.querySelectorAll('.results');
let duels = document.querySelectorAll('.duels');
const duelsSwitch = document.querySelector('.duel-button button.results-duels-switch');

duelsSwitch.onclick = function () {showHideDuels();};

const showHideDuels = () => {
    for (let i = 0; i < results.length; i++) {
        results[i].hidden = !results[i].hidden;
        duels[i].hidden = !duels[i].hidden; 
    }
    
    if (!duels[0].hidden) {
        // Скрипт для раскрашивания ячеек:
        duels.forEach((item) => {
            if ( item.parentNode.classList.contains('has-history') ) {
                let score = item.textContent.trim();
                let victories = +(score[0]);
                let defeats = +(score[4]);
                if (victories > defeats) {
                    item.parentNode.style.backgroundColor = 'rgba(0, 255, 0, 0.1)';
                } else if (victories === defeats) {
                    item.parentNode.style.backgroundColor = 'rgba(255, 255, 0, 0.1)';
                } else {
                    item.parentNode.style.backgroundColor = 'rgba(255, 0, 0, 0.1)';
                }
            }
        });
    }
    else {
        duels.forEach( (item) => {
            item.parentNode.style.backgroundColor = '';
        });
    }
};


// Служебные скрипты:

// Для вставки полурыбных колонок с сезонами во все строки:

// for (let ri = 1; ri < table.rows.length; ri ++) {
//     let gapCell = document.createElement('td');
//     gapCell.classList.add(`main-table__gap`);
//     table.rows[ri].cells[26].after(gapCell);

//     let clubName = table.rows[ri].cells[1].querySelector(`img`).getAttribute('title');
//     let seasNumCell = document.createElement('td');
//     seasNumCell.classList.add(`main-table__seasons`);
//     let titleText = `${clubName}: 20 сезонов с участием в еврокубках`;
//     seasNumCell.setAttribute('title', titleText);
//     seasNumCell.innerHTML = `<span class="main-table__seasons">20</span>`;
//     table.rows[ri].cells[27].after(seasNumCell);
// }


// Для вставки полурыбных (скопированных с имеющейся 
// (указана во сторой строке индексом у cells) колонки) ячеек во все строки:

// for (let ri = 1; ri < table.rows.length; ri ++) {
//     let newCell = table.rows[ri].cells[4].cloneNode(true);
//     let rowID = table.rows[ri].cells[3].getAttribute('id').slice(0, 3);
//     newCell.id = `${rowID}Rom`;
//     let allDivsInCell = newCell.querySelectorAll('div');
//     let newText1 = allDivsInCell[0].getAttribute('title').replace('Барселона', 'Рома');
//     allDivsInCell[0].setAttribute('title', newText1);
//     let newText2 = allDivsInCell[1].getAttribute('title').replace('Барселоны', 'Ромы');
//     allDivsInCell[1].setAttribute('title', newText2);
//     table.rows[ri].cells[25].after(newCell);
// }


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
// в соответствии с порядком команд в новом ранжире, игнорируя пока пропуски)

// for (let rangeNum = 5; rangeNum <= 18; rangeNum ++) {
//     for (let cellIndInLogoRow = 5; cellIndInLogoRow <= 18; cellIndInLogoRow ++) {
//         if (table.rows[0].cells[cellIndInLogoRow].querySelector('span').textContent == rangeNum) {

//             table.rows[0].cells[rangeNum - 1].after(table.rows[0].cells[cellIndInLogoRow]);

//             for (let ri = 1; ri <= 8; ri ++) {
//                 table.rows[ri].cells[rangeNum + 1].after(table.rows[ri].cells[cellIndInLogoRow + 2]);
//             }

//             break;
//         }
//     }
// }

