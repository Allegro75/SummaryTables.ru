
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


//Скрипт для добаления рыбы последней колонки: 

// let addTDInnerHTML = ''; 

// for (let i = 1; i < table.rows.length - 1; i += 1) {
//     addTDInnerHTML = table.rows[i].cells[31].innerHTML;
//     table.rows[i].append(document.createElement('td'));
//     table.rows[i].cells[33].innerHTML = addTDInnerHTML;
//     table.rows[i].cells[33].id = table.rows[i].cells[21].getAttribute('id');
//     table.rows[i].cells[33].setAttribute('class', table.rows[i].cells[21].getAttribute('class'));
// };   


// Скрипт для удаления дивов 'results':
 
// const results = document.querySelectorAll('.results');
// for(let i = 17; i >= 0; i -= 1) {
//     results[i].remove();
// };