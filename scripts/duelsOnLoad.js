
document.addEventListener('DOMContentLoaded', () => {
    let results = document.querySelectorAll('.results');
    let duels = document.querySelectorAll('.duels');

    // Переключатель в ДУЭЛЬНыЙ вид:
    if (localStorage.showDuels === `true`) {
        for (let i = 0; i < results.length; i++) {
            results[i].hidden = !results[i].hidden;
            duels[i].hidden = !duels[i].hidden;
        }
    }

    // Для установки галки в чекбокс, если он был отжат раньше:
    const duelsCheckBox = document.getElementById(`duels-row__input`);
    if (localStorage.showDuels === `true`) {
        duelsCheckBox.checked = true;
    }

    // Реакции на пользовательские манипуляции с чекбоксом:
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