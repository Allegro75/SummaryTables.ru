document.addEventListener('DOMContentLoaded', () => {

    const allAchievesCells = document.querySelectorAll(`tr.club-row td.main-table_victory.has-achieves, tr.club-row td.main-table_playoff.has-achieves`);
    allAchievesCells.forEach((cell) => {
        cell.addEventListener(`click`, () => {
            cell.querySelector(`.popup`).classList.remove(`d-none`);
        })
    });
    const allPopupCrosses = document.querySelectorAll(`.popup__cross`);
    allPopupCrosses.forEach((cross) => {
        cross.addEventListener(`click`, (event) => {
            event.stopPropagation();
            cross.parentElement.classList.add(`d-none`);
        });
    });

});