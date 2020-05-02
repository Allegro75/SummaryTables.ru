
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
