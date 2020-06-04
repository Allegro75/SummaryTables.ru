
// Для ВСПЛЫТИЯ окон с подробной статистикой по клику на ячейку большой таблицы:

document.addEventListener('DOMContentLoaded', () => {
    // const table = document.querySelector('table.main-table');
    const allTables = document.querySelectorAll('table.main-table');

    allTables.forEach( item => item.onclick = function () {showSmallTable();} )

    const showSmallTable = () => {
        let target = event.target;
        while (!target.classList.contains(`main-table`)) {
            if (target.getAttribute('class') == 'statistics has-history') {
                let tableDataId = target.getAttribute('id');
                let urlInWindowOpen = `football-small-tables/${tableDataId}.html`;
                window.open(urlInWindowOpen, '', 'width=500px, height=900px');
                return;
                }
            target = target.parentNode;
            }
        };
});