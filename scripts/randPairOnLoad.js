
document.addEventListener('DOMContentLoaded', () => {

// Для всплытия СЛУЧАЙНОГО окна с подробной статистикой:
    if (localStorage.showRandomWindow === `true`) {
        const allCellsWHistory = document.querySelectorAll('td.has-history');
        let randomPairIndex = Math.floor( ( allCellsWHistory.length * Math.random() ) );
        const randomPairCell = allCellsWHistory[randomPairIndex];
        const randomCellID = randomPairCell.getAttribute('id'); 
        const urlInRandomWindow = `football-small-tables/${randomCellID}.html`;
        window.open(urlInRandomWindow, ``, `width=520px, height=970px`);
    }

// Для управления localStorage.showRandomWindow:
    const randomOnLoadBtn = document.getElementById(`random-onload__input`);
    if (localStorage.showRandomWindow === `true`) {
        randomOnLoadBtn.checked = true; 
    }
    randomOnLoadBtn.addEventListener('change', () => {
        if (!localStorage.showRandomWindow) {
            localStorage.showRandomWindow = true;
        } else if (localStorage.showRandomWindow === `true`) {
            localStorage.showRandomWindow = false;
        } else {
            localStorage.showRandomWindow = true;
        }
    });
});