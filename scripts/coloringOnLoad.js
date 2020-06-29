
document.addEventListener('DOMContentLoaded', () => {
    let results = document.querySelectorAll('.results');
    let duels = document.querySelectorAll('.duels');

    // Для установки галки в чекбокс, если он был отжат раньше:
    const coloringCheckBox = document.getElementById(`coloring-onload__input`);
    if (localStorage.woColoringOnLoad === `true`) {
        coloringCheckBox.checked = true;
        // Если сейчас ячейки раскрашены (т.е. если мы в history36):
        if (document.querySelector('td.has-history').style.backgroundColor) {
            // то отменяем раскраску:
            document.querySelectorAll('td.has-history').forEach((item) => {
                item.style.backgroundColor = '';
            });
        }
    }

    // Для раскрашивания при первой загрузке сайта
    // или при (localStorage.woColoringOnLoad == false):

    if (!localStorage.woColoringOnLoad || (localStorage.woColoringOnLoad === 'false')) {
        // Сначала проверяем, что у нас есть '.results'
        // (т.е., что мы не в history36
        // (а если мы в history36, то ничего делать не надо)):
        if (document.querySelectorAll('.results').length > 0) {
            // Теперь проверяем, не заказан ли пользователем дуэльный вид:
            if (localStorage.showDuels === `true`) {
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
            // и если не заказан, то раскрашиваем results:
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