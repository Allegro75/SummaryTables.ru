//
// Скрипт для расстановки ссылок на турниры в ячейки таблицы: 
//

document.addEventListener('DOMContentLoaded', () => {

// Определяем служебные переменные:    

    const table = document.querySelector('table');

    const addHrefToRow = (rowIndex, year, tourney) => {
        for (let ci = 2; ci <= 5; ci ++) {
            let node = table.rows[rowIndex].cells[ci];
            node.innerHTML = `
                                <a href="http://wildstat.ru/p/50/ch/EUR_${tourney[0]}_${year - 1}_${year}" 
                                target="_blank"
                                title="Посмотреть турнир ${tourney[1]} ${year - 1}/${year}">
                                    ${node.innerHTML}
                                </a>                            
                            `;        
        }
    };

    const addHrefForFairCup5860 = (rowIndex) => {
        for (let ci = 2; ci <= 5; ci ++) {
            let node = table.rows[rowIndex].cells[ci];
            node.innerHTML = `
                                <a href="http://wildstat.ru/p/51/ch/EUR_ICFC_1958_1960" 
                                target="_blank"
                                title="Посмотреть турнир кубка ярмарок 1958/1960">
                                    ${node.innerHTML}
                                </a>                            
                            `;        
        }
    };

    const addHrefForFairCup5558 = (rowIndex) => {
        for (let ci = 2; ci <= 5; ci ++) {
            let node = table.rows[rowIndex].cells[ci];
            node.innerHTML = `
                                <a href="http://wildstat.ru/p/51/ch/EUR_ICFC_1955_1958" 
                                target="_blank"
                                title="Посмотреть турнир кубка ярмарок 1955/1958">
                                    ${node.innerHTML}
                                </a>                            
                            `;        
        }
    };

    const defineYearForGroupStage = (ri) => {
        let neighborGameRow = 
        ( !( table.rows[ri - 1].classList.contains(`duel-result`) ) &&
        !( table.rows[ri - 1].classList.value === `` ) ) ?
        table.rows[ri - 1] : table.rows[ri + 1];
        let year;
        if (+neighborGameRow.cells[3].textContent > +table.rows[ri].cells[3].textContent) {
            year = +neighborGameRow.cells[3].textContent;
        } else {year = +table.rows[ri].cells[3].textContent;}
        return year;
    };


// Запускаем основной цикл расстановки ссылок:  

    for (let i = 1; i < table.rows.length; i ++) {

        // Кубок/лига чемпионов:

        if ( (table.rows[i].cells[4]) &&
        (table.rows[i].cells[4].textContent.includes(`чемпионов`)) ) {
            
            if (+table.rows[i].cells[3].textContent >= 1995) {
                
                if (table.rows[i].cells[5].textContent.trim() === `группа` ||
                table.rows[i].cells[5].textContent.trim() === `отбор`) {
                    addHrefToRow(i, +table.rows[i].cells[3].textContent + 1, ['CL', 'лиги чемпионов']);
                }
                else if (table.rows[i].cells[5].textContent === `группа2`) {
                    let year = defineYearForGroupStage(i);
                    addHrefToRow(i, year, ['CL', 'лиги чемпионов']);
                }
                else {
                    addHrefToRow(i, +table.rows[i].cells[3].textContent, ['CL', 'лиги чемпионов']);
                }
            }

            // Специально для групп 1994 года, т.к. 
            // в 1993-1994 гг. группы были смещены в 1994 год,
            // а в 1994-1995 гг. группы были обычными:
            else if (+table.rows[i].cells[3].textContent == 1994) {        
                // Тут всё обычно - для стадии отбора:        
                if (table.rows[i].cells[5].textContent === `отбор`) {
                    addHrefToRow(i, +table.rows[i].cells[3].textContent + 1, ['CL', 'лиги чемпионов']);
                }

                // Вот тут всё оригинальное содержание:
                else if (table.rows[i].cells[5].textContent === `группа`) {

                    // Определяем строку с соседней игрой для игры в группе-1994:
                    let neighborGameRow1994 = 
                    ( !( table.rows[i - 1].classList.contains(`duel-result`) ) &&
                    !( table.rows[i - 1].classList.value === `` ) ) ?
                    table.rows[i - 1] : table.rows[i + 1];

                    // Если год этой игры - 1993, то год турнира - 1994:
                    if (+neighborGameRow1994.cells[3].textContent == 1993) {
                        addHrefToRow(i, 1994, ['CL', 'лиги чемпионов']);
                    }

                    else {
                    // А если год этой игры - 1994, то тут уже либо:

                    // 1) мы имеем дело с исключительным розыгрышем 1993-1994,
                    // и тогда мы должны просто перечислить 4 пары-исключения:
                        const pairHeader = document.querySelector('title').textContent;
                        if (pairHeader == `Спартак - Барселона` ||
                            pairHeader == `Барселона - Спартак` ||
                            pairHeader == `Монако - Галатасарай` ||
                            pairHeader == `Галатасарай - Монако` ||
                            pairHeader == `Порто - Андерлехт` ||
                            pairHeader == `Андерлехт - Порто` ||
                            pairHeader == `Милан - Вердер` ||
                            pairHeader == `Вердер - Милан`) {
                                addHrefToRow(i, 1994, ['CL', 'лиги чемпионов']);
                            }
                    // 2) мы имеем дело с обычным розыгрышем 1994-1995,
                        else {
                            addHrefToRow(i, 1995, ['CL', 'лиги чемпионов']); 
                        }
                    }                    
                }

                // А тут уже как обычно - для стадии плей-офф:
                else {
                    addHrefToRow(i, +table.rows[i].cells[3].textContent, ['CL', 'лиги чемпионов']);
                }
            }            


            else if ( (+table.rows[i].cells[3].textContent >= 1991) &&
            (+table.rows[i].cells[3].textContent < 1994) ) {
                
                let tour = (table.rows[i].cells[4].textContent.includes(`Лига`)) ?
                ['CL', 'лиги чемпионов'] : ['CC', 'кубка чемпионов'];  

                if (table.rows[i].cells[5].textContent === `группа`) {
                    let year = defineYearForGroupStage(i);
                    addHrefToRow(i, year, tour);
                }
                else if ( (table.rows[i].cells[5].textContent === `ФИНАЛ`) ||
                (table.rows[i].cells[5].textContent === `1/2`) ||
                (table.rows[i].cells[5].textContent === `1/4`) ) {
                    addHrefToRow(i, +table.rows[i].cells[3].textContent, tour);
                }
                else {
                    addHrefToRow(i, +table.rows[i].cells[3].textContent + 1, tour);
                }
            }
            

            else if (+table.rows[i].cells[3].textContent < 1991) {
            // Надо иметь в виду исключтительный розыгрыш КЧ 1955/1956 (первый КЧ в истории).
            // Там нек-рые матчи 1/4 проходили в 1955. В частности, Милан - Рапид Вена.
            // Если Рапид Вена когда-нибудь будет добавлен, то надо будет доработать скрипт.

                if ( (table.rows[i].cells[5].textContent === `ФИНАЛ`) ||
                (table.rows[i].cells[5].textContent === `1/2`) ||
                (table.rows[i].cells[5].textContent === `1/4`) ) {
                    addHrefToRow(i, +table.rows[i].cells[3].textContent, ['CC', 'кубка чемпионов']);
                }
                else {
                    addHrefToRow(i, +table.rows[i].cells[3].textContent + 1, ['CC', 'кубка чемпионов']);
                }
            }        
        }


        // Кубок кубков:

        else if ( (table.rows[i].cells[4]) &&
        (table.rows[i].cells[4].textContent.includes(`кубков`)) ) {

            if (+table.rows[i].cells[3].textContent >= 1961) {

                if ( (table.rows[i].cells[5].textContent === `ФИНАЛ`) ||
                (table.rows[i].cells[5].textContent === `1/2`) ||
                (table.rows[i].cells[5].textContent === `1/4`) ) {
                    addHrefToRow(i, +table.rows[i].cells[3].textContent, ['CWC', 'кубка кубков']);            
                }
                else {
                    addHrefToRow(i, +table.rows[i].cells[3].textContent + 1, ['CWC', 'кубка кубков']);
                }
            }

            // Специально для первого кубка кубков (1960/1961), в к-ром
            // 1/4 финала игралась в 1960 г.:        
            else {
                addHrefToRow(i, +table.rows[i].cells[3].textContent + 1, ['CWC', 'кубка кубков']);
            }
        }


        // Кубок УЕФА/ярмарок, лига Европы:

            // Лига Европы:

        else if ( (table.rows[i].cells[4]) &&
        ( table.rows[i].cells[4].textContent.includes(`Европы`) ) ) {
            if ( ( table.rows[i].cells[5].textContent.includes(`группа`) ) ||
            ( table.rows[i].cells[5].textContent.includes(`отбор`) ) ) {
                addHrefToRow(i, +table.rows[i].cells[3].textContent + 1, ['EL', 'лиги Европы']);         
            }
            else {
                addHrefToRow(i, +table.rows[i].cells[3].textContent, ['EL', 'лиги Европы']);        
            }
        }

            // Кубок УЕФА:        
        
        else if ( (table.rows[i].cells[4]) &&
        ( table.rows[i].cells[4].textContent.includes(`УЕФА`) ) ) {
            if ( (table.rows[i].cells[5].textContent === `ФИНАЛ`) ||
            (table.rows[i].cells[5].textContent === `1/2`) ||
            (table.rows[i].cells[5].textContent === `1/4`) ||

            ( (table.rows[i].cells[5].textContent === `1/8`) &&
            (+table.rows[i].cells[3].textContent >= 2000) ) ||

            ( (table.rows[i].cells[5].textContent === `1/16`) &&
            (+table.rows[i].cells[3].textContent >= 2004) ) ) {
                addHrefToRow(i, +table.rows[i].cells[3].textContent, ['UEFA', 'кубка УЕФА']);
            } else {
                addHrefToRow(i, +table.rows[i].cells[3].textContent + 1, ['UEFA', 'кубка УЕФА']);
            }
        }

            // Кубок ярмарок:

        else if ( (table.rows[i].cells[4]) &&
        ( table.rows[i].cells[4].textContent.includes(`Кубок ярмарок`) ) ) {
            if (+table.rows[i].cells[3].textContent >= 1961) {

                if ( (table.rows[i].cells[5].textContent === `ФИНАЛ`) ||
                (table.rows[i].cells[5].textContent === `1/2`) ) {
                    addHrefToRow(i, +table.rows[i].cells[3].textContent, ['ICFC', 'кубка ярмарок']);
                }
                
                else if (table.rows[i].cells[5].textContent === `1/4`) {
                    if ( (+table.rows[i].cells[3].textContent == 1961) ||
                    (+table.rows[i].cells[3].textContent == 1960) ) {
                        addHrefToRow(i, 1961, ['ICFC', 'кубка ярмарок']);
                    } else {
                        addHrefToRow(i, +table.rows[i].cells[3].textContent, ['ICFC', 'кубка ярмарок']);
                    }
                }

                else if (table.rows[i].cells[5].textContent === `1/8`) {
                    if ( table.rows[i].cells[3].classList.contains(`next-year-tourney`) ) {
                        addHrefToRow(i, +table.rows[i].cells[3].textContent + 1, ['ICFC', 'кубка ярмарок']);
                    } else {
                        let year = defineYearForGroupStage(i);
                        addHrefToRow(i, year, ['ICFC', 'кубка ярмарок']);                    
                    } 
                }

                else {
                    addHrefToRow(i, +table.rows[i].cells[3].textContent + 1, ['ICFC', 'кубка ярмарок']);
                }
            }

            else if (+table.rows[i].cells[3].textContent == 1960) {
                if (table.rows[i].cells[5].textContent === `1/4`) {
                    let year = defineYearForGroupStage(i);
                    addHrefToRow(i, year, ['ICFC', 'кубка ярмарок']);                 
                } 
                else if (table.rows[i].cells[5].textContent === `1/8`) {
                    addHrefToRow(i, +table.rows[i].cells[3].textContent + 1, ['ICFC', 'кубка ярмарок']);
                } 
                else {
                    addHrefForFairCup5860(i);
                }
            }

            else if (+table.rows[i].cells[3].textContent == 1959) {
                addHrefForFairCup5860(i);
            }

            else if (+table.rows[i].cells[3].textContent == 1958) {
                if (table.rows[i].cells[5].textContent === `ФИНАЛ`) {
                    addHrefForFairCup5558(i);
                } else {
                    addHrefForFairCup5860(i);
                }
            }
            
            else if (+table.rows[i].cells[3].textContent < 1958) {
                addHrefForFairCup5558(i);
            }        
        }    
    }
});
