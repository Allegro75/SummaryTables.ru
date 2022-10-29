
document.addEventListener('DOMContentLoaded', () => {
    let duels = document.querySelectorAll('.duels');

    // Для установки галки в чекбокс, если он был отжат раньше:
    const coloringCheckBox = document.getElementById(`coloring-onload__input`);
    if (localStorage.woColoringOnLoad === `true`) {
        coloringCheckBox.checked = true;
    }

    // Для раскрашивания при первой загрузке сайта
    // или при (localStorage.woColoringOnLoad == false):
    if (!localStorage.woColoringOnLoad || (localStorage.woColoringOnLoad === 'false')) {
        duels.forEach((item) => {
            if (item.parentNode.classList.contains('has-history')) {
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

    // Реакции на пользовательские манипуляции с чекбоксом:
    coloringCheckBox.addEventListener('change', () => {
        if (!localStorage.woColoringOnLoad) {
            localStorage.woColoringOnLoad = true;
        } else if (localStorage.woColoringOnLoad === `true`) {
            localStorage.woColoringOnLoad = false;
        } else {
            localStorage.woColoringOnLoad = true;
        }
    });
});