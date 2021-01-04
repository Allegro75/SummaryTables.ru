// Для ЗАМЕНЫ логотипов на лого другой светлоты:
document.addEventListener('DOMContentLoaded', () => {

    // Ищем логотипы для ЗАМЕНЫ на СВЕТЛОЕ в групповых таблицах:
    const queryPart = `table img.football-logo-table[src='../../images/`;
    const logosToLightInTables = document.querySelectorAll(`${queryPart}Zen.png'], ${queryPart}Mar.png'], ${queryPart}Nan.png'], ${queryPart}And_dark.png']`);

    const logoCode = (elem) => {
        if (elem.getAttribute(`src`).slice(-9, -4) === `_dark`) {
            return elem.getAttribute(`src`).slice(-12, -9);
        } else
        return elem.getAttribute(`src`).slice(-7, -4);
    }

    // Если такие логотипы есть:
    if (logosToLightInTables.length > 0) {

        // Запускаем перебор логотипов:
        for (let i = 0; i <= logosToLightInTables.length - 3; i += 3) {

            // Определяем таблицу, в к-рой находится наше лого:
            const zenitTable = logosToLightInTables[i].parentElement.parentElement.parentElement.parentElement;

            // Определяем номер группы:
            const groupNumber = +zenitTable.querySelector(`thead td:first-child`).innerText;

            // Если номер группы чётный:
            if ((groupNumber % 2) === 0) {
                // Меняем лого на светлый в верхней строке:
                logosToLightInTables[i].setAttribute('src', `../../images/${logoCode(logosToLightInTables[i])}_light.png`);

                // Определяем строку нашего клуба:
                const zenitRowNumber = +logosToLightInTables[i + 1].parentElement.previousElementSibling.innerText;
                // Если номер строки нечётный, то уходим:
                if ((zenitRowNumber % 2) === 1) continue;
                // Если же чётный:
                else {
                    logosToLightInTables[i + 1].setAttribute('src', `../../images/${logoCode(logosToLightInTables[i + 1])}_light.png`);
                    logosToLightInTables[i + 2].setAttribute('src', `../../images/${logoCode(logosToLightInTables[i + 2])}_light.png`);
                }
            }
        }
    }

    // Ищем логотипы для ЗАМЕНЫ на ТЁМНОЕ в групповых таблицах:
    const logosToDarkInTables = document.querySelectorAll(`${queryPart}Zur.png']`);

    // Если такие логотипы есть:
    if (logosToDarkInTables.length > 0) {

        // Запускаем перебор логотипов:
        for (let i = 0; i <= logosToDarkInTables.length - 3; i += 3) {

            // Определяем строку нашего клуба:
            const zurichRowNumber = +logosToDarkInTables[i + 1].parentElement.previousElementSibling.innerText;
            // Если номер строки нечётный:
            if ((zurichRowNumber % 2) === 1) {
                logosToDarkInTables[i + 1].setAttribute('src', `../../images/${logoCode(logosToDarkInTables[i + 1])}_dark.png`);
                logosToDarkInTables[i + 2].setAttribute('src', `../../images/${logoCode(logosToDarkInTables[i + 2])}_dark.png`);
            }
        }
    }
    
});