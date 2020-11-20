// Для ЗАМЕНЫ логотипа "ЗЕНИТА" на белый:
document.addEventListener('DOMContentLoaded', () => {
    // Ищем логотипы Зенита в групповых таблицах:
    const zenitLogoInTable = document.querySelectorAll(`table img.football-logo-table[src='../../images/Zen.png']`);
    // Если таких логотипов нет, то уходим:
    if (zenitLogoInTable.length === 0) return;
    // Если же есть:
    else {
        // Определяем таблицу, в к-рой находится наше лого:
        const zenitTable = zenitLogoInTable[0].parentElement.parentElement.parentElement.parentElement;
        // Определяем номер группы:
        const groupNumber = +zenitTable.querySelector(`thead td:first-child`).innerText;
        // Если номер группы нечётный, то уходим:
        if ((groupNumber % 2) === 1) return;
        // Если же чётный:
        else {
            // Меняем лого на белый в верхней строке:
            zenitLogoInTable[0].setAttribute('src', '../../images/Zen_light.png');
            // Определяем строку Зенита:
            const zenitRowNumber = +zenitLogoInTable[1].parentElement.previousElementSibling.innerText;
            // Если номер строки нечётный, то уходим:
            if ((zenitRowNumber % 2) === 1) return;
            // Если же чётный:
            else {
                zenitLogoInTable[1].setAttribute('src', '../../images/Zen_light.png');
                zenitLogoInTable[2].setAttribute('src', '../../images/Zen_light.png');
            }
        }
    }
});