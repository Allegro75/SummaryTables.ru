
// Для РАСКРАШИВАНИЯ ячеек:

document.addEventListener('DOMContentLoaded', () => {
    let results = document.querySelectorAll('.results');
    let duels = document.querySelectorAll('.duels');
    document.querySelector(`button.make-coloring__btn`).addEventListener('click', () => {
        // Если сейчас ячейки раскрашены:
        if (document.querySelector('td.has-history').style.backgroundColor) {
            // то отменяем раскраску:            
            document.querySelectorAll('td.has-history').forEach((item) => {
                item.style.backgroundColor = '';
            });
        }
        // а если не раскрашены:
        else {
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
            // А если таблица НЕ в дуэльном виде:
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