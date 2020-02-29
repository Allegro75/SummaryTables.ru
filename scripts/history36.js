
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

 
//let addTDInnerHTML = ''; 
//let addTD = document.createElement('td'); 

// for (let i = 1; i < table.rows.length - 1; i += 1) {
//     addTDInnerHTML = table.rows[i].cells[25].innerHTML;
//     //addTD.innerHTML = addTDInnerHTML;
//     table.rows[i].append(document.createElement('td'));
//     table.rows[i].cells[31].innerHTML = addTDInnerHTML;
//     table.rows[i].cells[31].id = table.rows[i].cells[25].getAttribute('id');
// };   

//table.rows[1].append(table.rows[1].cells[25]);    
