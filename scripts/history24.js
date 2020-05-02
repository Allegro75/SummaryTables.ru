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

lowDuelsSwitch.onclick = function () {showHideDuels();};





// Временные скрипты для переделывания таблицы по новому ранжиру:
// for (let ri = 0; ri < table.rows.length; ri += 1) {
//     for (let ci = 0; ci < table.rows[ri].cells.length; ci += 1) {
//         let cellID = table.rows[ri].cells[ci].getAttribute('id');
//         if ( (cellID && cellID.includes('PSG', 2)) || 
//         (cellID && cellID.includes('Sev', 2)) || 
//         (cellID && cellID.includes('BoM', 2)) || 
//         (cellID && cellID.includes('Lyo', 2)) ) {
//             table.rows[ri].cells[ci].remove();
//             ci -= 1;
//         }
//     }
// }

// for (let ri = 0; ri < table.rows.length; ri += 1) {
//     for (let ci = 0, benCells = 0; ci < table.rows[ri].cells.length; ci += 1) {
//         let cellID = table.rows[ri].cells[ci].getAttribute('id');
//         if (cellID && cellID.includes('Ben', 2)) {
//             benCells += 1;
//             if (benCells === 2) {
//                 table.rows[ri].cells[ci].remove();
//                 continue;
//             }
//         }
//     }
// }

// for (let i = 3; i < 27; i += 1) {
//     if (i === 16) {continue;}
//     let html = '\n\t\t\t\t\t\t<div class="results" title="Порто - Боруссия Д\n0 побед, 0 ничьих, 2 поражения\nКликните, чтобы узнать подробности">\n\t\t\t\t\t\t\t\t<p class="games-score">+0 =0 -2</p>\n\t\t\t\t\t\t\t\t<p class="goals-difference">0 - 3</p>\n\t\t\t\t\t\t</div>';
//     let currentCell = table.rows[14].cells[i];
//     currentCell.insertAdjacentHTML('afterbegin', html);
//     currentCell.querySelector('.duels').hidden = true;
// }

// for (let ri = 3; ri < table.rows.length; ri += 1) {
//     for (let ci = 0; ci < table.rows[ri].cells.length; ci += 1) {
//         let cellID = table.rows[ri].cells[ci].getAttribute('id');
//         if ( cellID && cellID.includes('Por', 2) && ci > 15 ) {            
//             table.rows[ri].cells[14].after(table.rows[ri].cells[ci]);
//             break;
//             }
//         else if ( cellID && cellID.includes('Por', 2) && ci < 15 ) {            
//             table.rows[ri].cells[15].after(table.rows[ri].cells[ci]);
//             break;
//             }
//         }
//     }

// for (let ri = 13; ri < table.rows.length; ri += 1) {
//     for (let ci = 7; ci < table.rows[ri].cells.length; ci += 1) {
//         let cellID = table.rows[ri].cells[ci].getAttribute('id');
//         if ( cellID && cellID.includes('Mil', 2) ) {            
//             table.rows[ri].cells[6].after(table.rows[ri].cells[ci]);
//             break;
//             }
//         }
//     }

// for (let ri = 3; ri < table.rows.length; ri += 1) {
//     for (let ci = 19; ci < table.rows[ri].cells.length; ci += 1) {
//         let cellID = table.rows[ri].cells[ci].getAttribute('id');
//         if ( cellID && cellID.includes('BoD', 2) ) {            
//             table.rows[ri].cells[17].after(table.rows[ri].cells[ci]);
//             break;
//             }
//         }
//     }

// for (let ri = 3; ri < table.rows.length; ri += 1) {
//     for (let ci = 26; ci > 0; ci -= 1) {
//         let cellID = table.rows[ri].cells[ci].getAttribute('id');
//         if ( cellID && cellID.includes('Cel', 2) ) {            
//             table.rows[ri].cells[25].before(table.rows[ri].cells[ci]);
//             break;
//             }
//         }
//     }


