 
// Для всплытия СЛУЧАЙНОГО окна с подробной статистикой:

document.addEventListener('DOMContentLoaded', () => {
    if (localStorage.showRandomWindow === `true`) {
        const allCellsWHistory = document.querySelectorAll('td.has-history');
        let randomPairIndex = Math.floor( ( allCellsWHistory.length * Math.random() ) );
        const randomPairCell = allCellsWHistory[randomPairIndex];
        const randomCellID = randomPairCell.getAttribute('id'); 
        const urlInRandomWindow = `football-small-tables/${randomCellID}.html`;
        window.open(urlInRandomWindow, ``, `width=520px, height=970px`);
    }
});