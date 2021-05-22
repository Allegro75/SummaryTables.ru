// Для ЗАМЕНЫ логотипов на лого другой светлоты:
document.addEventListener('DOMContentLoaded', () => {

    // Ищем логотипы для ЗАМЕНЫ на СВЕТЛОЕ в групповых таблицах:
    const queryPart = `table img.football-logo-table[src='../../images/`;
    const logosToLightInTables = document.querySelectorAll(`${queryPart}Zen.png'], ${queryPart}Mar.png'], ${queryPart}Nan.png'], ${queryPart}And_dark.png'], ${queryPart}DyK.png'], ${queryPart}Mon.png']`);
    // Доп. массив для логотипов, нуждающихся в замене на светлый вариант даже на светло-сером фоне:
    const additionalArray = [`Mon`, `Zen`];

    const logoCode = (elem) => {
        if (elem.getAttribute(`src`).slice(-9, -4) === `_dark`) {
            return elem.getAttribute(`src`).slice(-12, -9);
        } else
            return elem.getAttribute(`src`).slice(-7, -4);
    }

    // Служебный объект, в к-рый мы будем добавлять логоКоды по ходу перебора с тем, чтобы не обрабатывать заново уже перебранный клуб:
    let noHandlingObj = {};    

    // Служебный массив, в к-рый мы будем добавлять логотипы из logosToLightInTables с тем, чтобы затем осветлить логотипы:
    const toLightLogosInds = [];

    // Если такие логотипы есть:
    if (logosToLightInTables.length > 0) {

        // Запускаем перебор логотипов:
            // Раннее мы перебирали, прыгая через три позиции, что давало корректный результат для большинства случаев,
            // однако, для групп, внутри к-рых сразу два логотипа, нуждающихся в коррекции, это не работало,
            // поэтому перебор усложнился:
        for (let i = 0; i <= logosToLightInTables.length - 3; i += 1) {

            let curCode = logoCode(logosToLightInTables[i]);
            // Проверяем, чтобы либо клуб не встречался ранее, 
            // либо встретился в 4-й раз (т.е. на странице две группы с этим клубом - касается ЛЧ в период 2000-2003, кажется)
            if (!(curCode in noHandlingObj) || noHandlingObj[curCode] === 3) { 
                
                noHandlingObj[curCode] = (curCode in noHandlingObj) ? 4 : 1;

                // Определяем таблицу, в к-рой находится наше лого:
                const zenitTable = logosToLightInTables[i].parentElement.parentElement.parentElement.parentElement;

                // Определяем номер группы:
                const groupNumber = +zenitTable.querySelector(`thead td:first-child`).innerText;

                // Если номер группы чётный
                // или текущий лого относится к типу "Монако", нуждающихся в замене на светлый вариант даже на светло-сером фоне:
                if (((groupNumber % 2) === 0) || (additionalArray.includes(curCode))) {

                    toLightLogosInds.push(logosToLightInTables[i]);

                    // Определяем две следующих (после верхней строки группы) позиции текущего лого в logosToLightInTables:
                    let logo2 = logo3 = 0;
                    for (let innerIter = i + 1; logo3 === 0; innerIter += 1) {
                        if (curCode === logoCode(logosToLightInTables[innerIter])) {
                            if (logo2 === 0) {
                                logo2 = innerIter;
                            } else {
                                logo3 = innerIter;
                            }
                        }
                    }

                    // Определяем строку нашего клуба:
                    const zenitRowNumber = +logosToLightInTables[logo2].parentElement.previousElementSibling.innerText;

                    // Если номер строки нечётный, то уходим:
                    if ((zenitRowNumber % 2) === 1) continue;
                    // Если же чётный:
                    else {
                        toLightLogosInds.push(logosToLightInTables[logo2], logosToLightInTables[logo3]);
                    }
                }
            } else {
                noHandlingObj[curCode] += 1;
                continue;
            }
        }

        // Осветляем логотипы:
        toLightLogosInds.forEach((el) => {
            el.setAttribute('src', `../../images/${logoCode(el)}_light.png`);
        })
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


    // Ищем логотипы для ЗАМЕНЫ на ТЁМНОЕ на СВЕТЛО-СЕРОМ в групповых таблицах:
    const logosOnLightGrey = document.querySelectorAll(`${queryPart}DyK.png']`);

    // Если такие логотипы есть:
    if (logosOnLightGrey.length > 0) {

        // Запускаем перебор логотипов:
        for (let i = 0; i <= logosOnLightGrey.length - 3; i += 3) {

            // Определяем таблицу, в к-рой находится наше лого:
            const logoTable = logosOnLightGrey[i].parentElement.parentElement.parentElement.parentElement;

            // Определяем номер группы:
            const groupNumber = +logoTable.querySelector(`thead td:first-child`).innerText;

            // Если номер группы чётный:
            if ((groupNumber % 2) === 1) {
                // Меняем лого на светлый в верхней строке:
                logosOnLightGrey[i].setAttribute('src', `../../images/${logoCode(logosOnLightGrey[i])}_dark.png`);

                // Определяем строку нашего клуба:
                const logoRowNumber = +logosOnLightGrey[i + 1].parentElement.previousElementSibling.innerText;
                // Если номер строки нечётный, то уходим:
                if ((logoRowNumber % 2) === 1) continue;
                // Если же чётный:
                else {
                    logosOnLightGrey[i + 1].setAttribute('src', `../../images/${logoCode(logosOnLightGrey[i + 1])}_dark.png`);
                    logosOnLightGrey[i + 2].setAttribute('src', `../../images/${logoCode(logosOnLightGrey[i + 2])}_dark.png`);
                }
            }
        }
    }

});