 
// Для всплытия СЛУЧАЙНОГО окна с подробной статистикой:
// То же, что и randomWindowOnClick.js, но с ориентацией на динамическую (php) страницу с данными об истории матчей пары

document.addEventListener('DOMContentLoaded', () => {
    document.querySelector(`button.show-random__btn`).addEventListener('click', () =>{
        const allCellsWHistory = document.querySelectorAll('td.has-history');
        let randomPairIndex = Math.floor( ( allCellsWHistory.length * Math.random() ) );
        const randomPairCell = allCellsWHistory[randomPairIndex];
        // const randomCellID = randomPairCell.getAttribute('id');
        const firstClubId = randomPairCell.getAttribute(`data-first-club-id`);
        const secClubId = randomPairCell.getAttribute(`data-sec-club-id`);          
        // const urlInRandomWindow = `football-small-tables/${randomCellID}.html`;
        const urlInRandomWindow = `http://summarytables.ru/selected-pair-small-table.php?club_1=${firstClubId}&club_2=${secClubId}`;
        window.open(urlInRandomWindow, ``, `width=520px, height=970px, top=0, left=0`);
    });
});