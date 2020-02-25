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





//
//ФУНКЦИЯ для изменения ЧИСЛА клубов в таблице
//(функция переделанная из старой, в к-рой была зависимость от числа 16):
//

const tableRowsQuantity = table.rows.length;
const tableColumnsQuantity = table.rows[1].cells.length;

const rebuildTable = (clubsQuantity) => {

    //Для начала возвращаем таблицу в 16-клубный вид (открываем все скрытые ячейки):
    let hiddenElements = table.querySelectorAll('td[hidden], tr[hidden]');
    for (i = 0; i < hiddenElements.length; i++) {
        hiddenElements[i].hidden = false;
    }

    //Теперь перебираем таблицу и скрываем ненужное:
    //
    //Сначала скрываем лишние строки, начиная с последней:
    for (let i = tableRowsQuantity - 1; i > clubsQuantity; i -= 1) {
        table.rows[i].hidden = true;
    };
    //А когда доходим до строки, к-рую скрывать уже не надо,
    //начинаем перебирать строки,
    for (let i = clubsQuantity; i >= 0; i -= 1) {
        //а внутри них перебирать уже ячейки, начиная с последней:
        for (let indexOfCell = table.rows[i].cells.length - 1; 
            //пока не дойдём до ячейуи, к-рую скрывать не надо:
            indexOfCell > table.rows[i].cells.length - tableRowsQuantity + clubsQuantity;
            indexOfCell -= 1) {
                //ну, а пока не дошли, скрываем ячейки:
                table.rows[i].cells[indexOfCell].hidden = true;
            };
    }; 
};


//Перестраиваем полную таблицу на 8 клубов:
rebuildTable(24);
