
document.addEventListener('DOMContentLoaded', () => {

    // Переключатель в ДУЭЛЬНыЙ вид:
    if (localStorage.showDuels === `true`) {
        let results = document.querySelectorAll('.results');
        let duels = document.querySelectorAll('.duels');
        for (let i = 0; i < results.length; i++) {
            results[i].hidden = !results[i].hidden;
            duels[i].hidden = !duels[i].hidden;
        }

        // Скрипт для раскрашивания ячеек:    
        if (!duels[0].hidden) {
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
        } else {
            duels.forEach((item) => {
                item.parentNode.style.backgroundColor = '';
            });
        }

    }

    // Для управления localStorage.showDuels:
    const duelsCheckBox = document.getElementById(`duels-row__input`);
    if (localStorage.showDuels === `true`) {
        duelsCheckBox.checked = true;
    }
    duelsCheckBox.addEventListener('change', () => {
        if (!localStorage.showDuels) {
            localStorage.showDuels = true;
        } else if (localStorage.showDuels === `true`) {
            localStorage.showDuels = false;
        } else {
            localStorage.showDuels = true;
        }
    });
});