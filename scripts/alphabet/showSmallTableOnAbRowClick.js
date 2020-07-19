
// Для ВСПЛЫТИЯ окон с подробной статистикой по клику на строку из списка:

document.addEventListener(`DOMContentLoaded`, () => {
    const allStatRows = document.querySelectorAll(`.ab-row`);

    allStatRows.forEach( item => item.addEventListener('click', () => {
        let tableDataId = item.getAttribute(`id`);
        let urlInWindowOpen = `../../football-small-tables/${tableDataId}.html`;
        window.open(urlInWindowOpen, ``, `width=520px, height=970px, top=0, left=0`);
    }) );
})

