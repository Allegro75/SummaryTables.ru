
// Для простой (только КОЛОНКИ)
// перестройки таблицы - иностранные клубы в АЛФАВИТНОМ порядке (и обратно):

document.addEventListener('DOMContentLoaded', function() {
    const alphaBetaDiv = document.querySelector(`div.change-range-text`);
    const table = document.querySelector(`table.main-table`);
    
    // Задаём массив с ОРИГИНАЛЬНЫМ(по достижениям) порядком клубов:
    const origOrder = [];
    // Перебираем строку с логотипами:
    for (i = 1; i < table.rows[0].cells.length - 2; i++) {
        // Ищем НАЗВАНИЯ клубов массива:
        let clubName = table.rows[0].cells[i].querySelector(`img`).getAttribute('title');
        // Ищем ID для клубов массива:
        let clubId = ``;
        if ( table.rows[1].cells[i + 2].getAttribute('id') ) {
            clubId = table.rows[1].cells[i + 2].getAttribute('id').slice(3);
        } 
            // Если в первой строке (в основном мы с работаем только с ней)
            // клубов встретили логотип самого клуба,
            // обращаемся ко второй строке:
        else {
            clubId = table.rows[2].cells[i + 2].getAttribute('id').slice(3);
        }        
        origOrder.push({name: clubName, id: clubId});
    }

    // Задаём массив с АЛФАВИТНЫМ порядком клубов:
    const aBOrder = origOrder.slice();
    aBOrder.sort( (a, b) => {
        if (a.name > b.name) {
        return 1;
        } else {
        return -1;
        }
    } );

    // Задаём функцию для перестройки таблицы:
    // Параметром order будет приходить целевой массив (авлфавитный либо оригинальный):
    const rebuidCols = (tableElem, order) => {
        // Перебираем строку с логотипами:
        for (i = 1; i < tableElem.rows[0].cells.length - 2; i++) {
            // Ищем нужное лого:
            let logoCell = tableElem.rows[0].querySelector(`img[title="${order[i - 1].name}"]`).parentNode;
            // И вставляем:
            tableElem.rows[0].cells[i - 1].after(logoCell);
            // И вставляем порядковый номер:
            tableElem.rows[0].cells[i].querySelector(`span.number`).innerHTML = `${i}`;
        }
        // Перебираем основные строки (строки с результатами):
        for (ri = 1; ri < tableElem.rows.length; ri++) {
            // Определяем ID строки:
            let rowID = tableElem.rows[ri].cells[3].getAttribute('id').slice(0, 3);
            // Перебираем ячейки в строке:
            for (ci = 3; ci < tableElem.rows[ri].cells.length - 3; ci++) {
                // Если ID строки совпало с ID соперника:
                if (rowID === order[ci - 3].id) {
                    // Вставляем логотип команды из строки:
                    tableElem.rows[ri].cells[ci - 1].after(tableElem.rows[ri].querySelectorAll(`img`)[1].parentNode)
                } 
                // В остальных (нормальных) случаях ищем и вставляем ячейку на новое место:
                else {
                    let newCell = tableElem.rows[ri].querySelector(`#${rowID}${order[ci - 3].id}`);
                    tableElem.rows[ri].cells[ci - 1].after(newCell);
                }
            }
        }
    }

    alphaBetaDiv.addEventListener(`click`, function() {

        if (table.classList.contains(`ab-table`)) {
            table.classList.remove(`ab-table`);            
            rebuidCols(table, origOrder);
            alphaBetaDiv.innerHTML =`Упорядочить по алфавиту &#9654;`;
        } else {
            rebuidCols(table, aBOrder);
            table.classList.add(`ab-table`);
            alphaBetaDiv.innerHTML =`Упорядочить по достижениям &#9654;`;
        }
    });
});
