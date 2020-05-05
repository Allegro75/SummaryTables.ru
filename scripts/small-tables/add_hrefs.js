//
// Скрипт для расстановки ссылок на турниры в ячейки таблицы: 
//

const table = document.querySelector('table');

const addHref = (node, year, tourney) => {
    node.innerHTML = `
                            <a href="http://wildstat.ru/p/50/ch/EUR_${tourney[0]}_${year - 1}_${year}" 
                            target="_blank"
                            title="Посмотреть турнир ${tourney[1]} ${year - 1}/${year}">
                                ${node.innerHTML}
                            </a>                            
                        `;
};

const defineYearForGroup2Stage = (ri) => {
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


// Кубок/лига чемпионов:

for (let i = 1; i < table.rows.length; i ++) {
    if ( (table.rows[i].cells[4]) &&
    (table.rows[i].cells[4].textContent.includes(`чемпионов`)) ) {
        
        if (+table.rows[i].cells[3].textContent >= 1995) {
            
            if (table.rows[i].cells[5].textContent === `группа` ||
            table.rows[i].cells[5].textContent === `отбор`) {
                for (let ci = 2; ci <= 5; ci ++) {
                    addHref(table.rows[i].cells[ci], +table.rows[i].cells[3].textContent + 1, ['CL', 'лиги чемпионов']);
                }
            }
            else if (table.rows[i].cells[5].textContent === `группа2`) {
                let year = defineYearForGroup2Stage(i);
                for (let ci = 2; ci <= 5; ci ++) {
                    addHref(table.rows[i].cells[ci], year, ['CL', 'лиги чемпионов']);
                }                
            }
            else {
                for (let ci = 2; ci <= 5; ci ++) {
                    addHref(table.rows[i].cells[ci], +table.rows[i].cells[3].textContent, ['CL', 'лиги чемпионов']);
                } 
            }
        }


        else if ( (+table.rows[i].cells[3].textContent >= 1991) &&
        (+table.rows[i].cells[3].textContent < 1995) ) {
            
            let tour = (table.rows[i].cells[4].textContent.includes(`Лига`)) ?
            ['CL', 'лиги чемпионов'] : ['CC', 'кубка чемпионов'];            
            if (table.rows[i].cells[5].textContent === `группа`) {
                let year = defineYearForGroup2Stage(i);
                for (let ci = 2; ci <= 5; ci ++) {
                    addHref(table.rows[i].cells[ci], year, tour);
                }                
            }
            else if ( (table.rows[i].cells[5].textContent === `ФИНАЛ`) ||
            (table.rows[i].cells[5].textContent === `1/2`) ||
            (table.rows[i].cells[5].textContent === `1/4`) ) {
                for (let ci = 2; ci <= 5; ci ++) {
                    addHref(table.rows[i].cells[ci], +table.rows[i].cells[3].textContent, tour);
                }                 
            }
            else {
                for (let ci = 2; ci <= 5; ci ++) {
                    addHref(table.rows[i].cells[ci], +table.rows[i].cells[3].textContent + 1, tour);
                }                
            }
        }
        

        else if (+table.rows[i].cells[3].textContent < 1991) {
        // Надо иметь в виду исключтительный розыгрыш КЧ 1955/1956 (первый КЧ в истории).
        // Там нек-рые матчи 1/4 проходили в 1955. В частности, Милан - Рапид Вена.
        // Если Рапид Вена когда-нибудь будет добавлен, то надо будет менять скрипт.

            if ( (table.rows[i].cells[5].textContent === `ФИНАЛ`) ||
            (table.rows[i].cells[5].textContent === `1/2`) ||
            (table.rows[i].cells[5].textContent === `1/4`) ) {
                for (let ci = 2; ci <= 5; ci ++) {
                    addHref(table.rows[i].cells[ci], +table.rows[i].cells[3].textContent, ['CC', 'кубка чемпионов']);
                }                 
            }
            else {
                for (let ci = 2; ci <= 5; ci ++) {
                    addHref(table.rows[i].cells[ci], 
                    +table.rows[i].cells[3].textContent + 1, ['CC', 'кубка чемпионов']);
                }                
            }
        }        
    }
}

// Кубок кубков:
    
for (let i = 1; i < table.rows.length; i ++) {
    if ( (table.rows[i].cells[4]) &&
    (table.rows[i].cells[4].textContent.includes(`кубков`)) ) {

        if (+table.rows[i].cells[3].textContent >= 1961) {

            if ( (table.rows[i].cells[5].textContent === `ФИНАЛ`) ||
            (table.rows[i].cells[5].textContent === `1/2`) ||
            (table.rows[i].cells[5].textContent === `1/4`) ) {
                for (let ci = 2; ci <= 5; ci ++) {
                    addHref(table.rows[i].cells[ci], +table.rows[i].cells[3].textContent, ['CWC', 'кубка кубков']);
                }                 
            }
            else {
                for (let ci = 2; ci <= 5; ci ++) {
                    addHref(table.rows[i].cells[ci], 
                    +table.rows[i].cells[3].textContent + 1, ['CWC', 'кубка кубков']);
                }                
            }
        }

        // Специально для первого кубка кубков (1960/1961), в к-ром
        // 1/4 финала игралась в 1960 г.:        
        else {
            for (let ci = 2; ci <= 5; ci ++) {
                addHref(table.rows[i].cells[ci], 
                +table.rows[i].cells[3].textContent + 1, ['CWC', 'кубка кубков']);
            }
        }
    }
}