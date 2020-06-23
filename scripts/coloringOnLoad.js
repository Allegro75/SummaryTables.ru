
document.addEventListener('DOMContentLoaded', () => {
    let results = document.querySelectorAll('.results');

    // Для установки галки в чекбокс, если он был отжат раньше:
    const coloringCheckBox = document.getElementById(`coloring-onload__input`);
    if (localStorage.woColoringOnLoad === `true`) {
        coloringCheckBox.checked = true;
    }

    // Для раскрашивания при первой загрузке сайта
    // или при (localStorage.woColoringOnLoad == false):

    if (!localStorage.woColoringOnLoad || (localStorage.woColoringOnLoad === 'false')) {
        // Сначала проверяем, что у нас есть '.results'
        // (т.е., что мы не в history36
        // (а если мы в history36, то ничего делать не надо)):
        if (document.querySelectorAll('.results').length > 0) {
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