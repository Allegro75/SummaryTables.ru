
document.addEventListener(`DOMContentLoaded`, () => {
    const allStatRows = document.querySelectorAll(`.ab-row`);

    // Для навешивания подсказок (titles) на строки:

    allStatRows.forEach( item => item.addEventListener('mouseover', () => {
        let club1Name = item.querySelector(`.row-club_1`).innerHTML.trim().slice(0, - 2);
        let club2Name = item.querySelector(`.row-club_2`).innerHTML.trim();
        let victories = +item.querySelector(`.ab-games__victories`).innerHTML.trim().slice(1);
        let victInRus;
        if (victories === 1) {victInRus = `победа`;}
        else if ((victories !== 0) && (victories <= 4)) {victInRus = `победы`;}
        else {victInRus = `побед`;}
        let draws = +item.querySelector(`.ab-games__draws`).innerHTML.trim().slice(1);
        let drawsInRus;
        if (draws === 1) {drawsInRus = `ничья`;}
        else if ((draws !== 0) && (draws <= 4)) {drawsInRus = `ничьи`;}
        else {drawsInRus = `ничьих`;}
        let lesions = +item.querySelector(`.ab-games__lesions`).innerHTML.trim().slice(1);
        let lesionsInRus;
        if (lesions === 1) {lesionsInRus = `поражение`;}
        else if ((lesions !== 0) && (lesions <= 4)) {lesionsInRus = `поражения`;}
        else {lesionsInRus = `поражений`;}
        item.setAttribute(`title`, `${club1Name} - ${club2Name}
${victories} ${victInRus}, ${draws} ${drawsInRus}, ${lesions} ${lesionsInRus}
Кликните, чтобы узнать подробности`);
    }) );

    // Для ВСПЛЫТИЯ окон с подробной статистикой по клику на строку из списка:

    allStatRows.forEach( item => item.addEventListener('click', () => {
        let tableDataId = item.getAttribute(`id`);
        let urlInWindowOpen = `../../football-small-tables/${tableDataId}.html`;
        window.open(urlInWindowOpen, ``, `width=520px, height=970px, top=0, left=0`);
    }) );
})

