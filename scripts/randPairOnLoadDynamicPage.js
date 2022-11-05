
// То же, что и randPairOnLoad (возможное открытие окна со случайной парой при загрузке страницы), но с ориентацией на динамическую (php) страницу с данными об истории матчей пары 

document.addEventListener('DOMContentLoaded', () => {

// Для всплытия СЛУЧАЙНОГО окна с подробной статистикой:
    if (localStorage.showRandomWindow === `true`) {
        const allCellsWHistory = document.querySelectorAll('td.has-history');
        let randomPairIndex = Math.floor( ( allCellsWHistory.length * Math.random() ) );
        const randomPairCell = allCellsWHistory[randomPairIndex];
        // const randomCellID = randomPairCell.getAttribute('id');
        const firstClubId = randomPairCell.getAttribute(`data-first-club-id`);
        const secClubId = randomPairCell.getAttribute(`data-sec-club-id`);        
        // const urlInRandomWindow = `football-small-tables/${randomCellID}.html`;
        const urlInRandomWindow = `http://summarytables.ru/selected-pair-small-table.php?club_1=${firstClubId}&club_2=${secClubId}`;
        window.open(urlInRandomWindow, ``, `width=520px, height=970px, top=0, left=0`);
    }

    // Для установки галки в чекбокс, если он был отжат раньше:
    const randomOnLoadBtn = document.getElementById(`random-onload__input`);
    if (localStorage.showRandomWindow === `true`) {
        randomOnLoadBtn.checked = true; 
    }

    // Реакции на пользовательские манипуляции с чекбоксом:
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