
// Для ВСПЛЫТИЯ окон с подробной статистикой по клику на ячейку большой таблицы:
// (В отличие от первой версии подобного скрипта, здесь мы открываем файл php (а не статический html))

document.addEventListener(`DOMContentLoaded`, () => {

    const allTables = document.querySelectorAll(`table.main-table`);

    allTables.forEach(item => item.onclick = function () { showSmallTable(); })

    const showSmallTable = () => {
        let target = event.target;
        while (!target.classList.contains(`main-table`)) {
            if (target.getAttribute(`class`) == `statistics has-history`) {
                const firstClubId = target.getAttribute(`data-first-club-id`);
                const secClubId = target.getAttribute(`data-sec-club-id`);
                const urlInWindowOpen = `summarytables.ru/selected-pair-small-table.php?club_1=${firstClubId}&club_2=${secClubId}`;
                window.open(urlInWindowOpen, ``, `width=520px, height=970px, top=0, left=0`);
                return;
            }
            target = target.parentNode;
        }
    };

});