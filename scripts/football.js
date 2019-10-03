//
///Для того, чтобы по клику на ячейку всплывало окно с подробной статистикой:
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
    }


    
//    
//Делаем переключатель числа клубов в таблице:
//

//Задаём стартовое число клубов:
let clubsQuantity = 8;
//И перестраиваем 16-клубную таблицу на 8:
rebuildTable(8);

//Задаём js-имена кнопок переключателя:
//const clubsMinimum = document.querySelector('.selector button.minimum');
const lessClubs = document.querySelector('.selector button.less');
const clubsChoise = document.querySelector('.selector button.choice');
const moreClubs = document.querySelector('.selector button.more');
//const clubsMaximum = document.querySelector('.selector button.maximum');
//moreClubs.onclick = function () {alert("I'm a minimum");}

//Делаем функции меняющие количество клубов(clubsQuantity) в переключателе:

// clubsMinimum.onclick = function () {
//     clubsQuantity = 2;
//     clubsChoise.innerHTML = clubsQuantity;
//     rebuildTable(clubsQuantity);
// }
// clubsMaximum.onclick = function () {
//     clubsQuantity = 16;
//     clubsChoise.innerHTML = clubsQuantity;
//     rebuildTable(clubsQuantity);
// }
lessClubs.onclick = function () {
    if (clubsQuantity > 2) {
        clubsQuantity -= 1;
        clubsChoise.innerHTML = clubsQuantity;
        //rebuildTable(clubsQuantity);
    }
}
moreClubs.onclick = function () {
    if (clubsQuantity < 16) {
        clubsQuantity += 1;
        clubsChoise.innerHTML = clubsQuantity;
        //rebuildTable(clubsQuantity);
    }
}
clubsChoise.onclick = function () {
    rebuildTable(clubsQuantity);
}


//Делаем функцию, перестраивающую таблицу:
function rebuildTable (clubsQuantity) {
    //Для начала возвращаем таблицу в 16-клубный вид (открываем все скрытые элементы):
    let hiddenElements = table.querySelectorAll('td[hidden], tr[hidden]');
    for (i = 0; i < hiddenElements.length; i++) {
        hiddenElements[i].hidden = false;
    }

    //Теперь перебираем таблицу и скрываем ненужное:
    for (i = 16; i >= 0; i--) {
        for (indexOfCell = table.rows[i].cells.length - 1; 
            indexOfCell > (table.rows[i].cells.length - 1) - (16 - clubsQuantity); 
            indexOfCell--) {
            table.rows[i].cells[indexOfCell].hidden = true;
        }
        if (i > clubsQuantity) table.rows[i].hidden = true;
    }
}


