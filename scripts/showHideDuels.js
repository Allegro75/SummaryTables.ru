
// Переключатель в ДУЭЛЬНыЙ вид:

document.addEventListener('DOMContentLoaded', () => {
    let results = document.querySelectorAll('.results');
    let duels = document.querySelectorAll('.duels');
    const allDuelsButtons = document.querySelectorAll(`button.duels-switch__btn`);

    allDuelsButtons.forEach(item => item.onclick = () => {

        for (let i = 0; i < results.length; i++) {
            results[i].hidden = !results[i].hidden;
            duels[i].hidden = !duels[i].hidden;
        }

        // Скрипт для раскрашивания ячеек: 
        // Если сейчас ячейки раскрашены (а в противном случае мы ничего не делаем):
        if (document.querySelector('td.has-history').style.backgroundColor) {
            // если таблица в ДУЭЛЬНОМ виде:   
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
            } 
            // а если таблица НЕ в дуэльном виде:
            else {
                results.forEach((item) => {
                    if (item.parentNode.classList.contains('has-history')) {
                        let score = item.querySelector('.games-score').textContent.trim();
                        let firstSpaceIndex = score.indexOf(' ');
                        let victories = +(score.slice(1, firstSpaceIndex));
                        let minusIndex = score.indexOf('-');
                        let defeats = +(score.slice(minusIndex + 1));
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
        }
    });
});