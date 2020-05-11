
//
//Для ВСПЛЫТИЯ окон с подробной статистикой по клику на ячейку большой таблицы:
//

const table = document.querySelector('table.main-table');
table.onclick = function() {
    let target = event.target;
    while (target != table) {
        if (target.getAttribute('class') == 'statistics has-history') {
            let tableDataId = target.getAttribute('id');
            let urlInWindowOpen = 'football-small-tables/' +
            tableDataId + '.html';
            window.open(urlInWindowOpen, '', 'width=650px, height=900px');
            return;
            }
        target = target.parentNode;
        }
    };


// Скрипт для раскрашивания ячеек:

let duels = document.querySelectorAll('.duels');

duels.forEach((item) => {
    if ( item.parentNode.classList.contains('has-history') ) {
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


// Служебные скрипты для переделывания таблицы:  

// Для вставки колонки с "Гётеборгом":

// for (let ri = 1; ri <= 36; ri += 1) {
//     if (ri != 34) {
//         let rowID = ''; 
//         if (ri === 1) { rowID = 'RMa'; }
//         else {       
//             let rowRMaID = table.rows[ri].cells[3].getAttribute('id');
//             rowID = rowRMaID.slice(0, 3);
//         }

//         let idInGtbRow = `Gtb${rowID}`;
//         let newCell = document.getElementById(idInGtbRow).cloneNode(true);
//         newCell.id = `${rowID}Gtb`;
//         let rowClubInRussian = table.rows[ri].cells[1].querySelector('img').getAttribute('title');
//         let divInNewCell = newCell.querySelector('div');
//         if ( newCell.classList.contains('no-history') ) {
//             divInNewCell.setAttribute('title', `"${rowClubInRussian}" против "Гётеборга"
// В еврокубках не встречались`);
//         }
//         else {
//             let clearDivText = divInNewCell.textContent.trim();
//             let oldVictories = clearDivText[0];
//             let oldDefeats = clearDivText[4];  
//             divInNewCell.textContent = `${oldDefeats} - ${oldVictories}`;               

//             let oldTitleText = divInNewCell.getAttribute('title');                    
//             if ( oldTitleText.includes('победителя') ) {
//                 let textWWithoutClickWords = oldTitleText.slice(0, -34);
//                 let lastCommaIndex = textWWithoutClickWords.lastIndexOf(',');
//                 let oldTextToCopy = textWWithoutClickWords.slice(lastCommaIndex);
//                 divInNewCell.setAttribute('title', `"${rowClubInRussian}" против "Гётеборга"
// ${oldDefeats} побед в дуэлях, ${oldVictories} поражения${oldTextToCopy}Кликните, чтобы узнать подробности`);                 
//             }
//             else {
//                 divInNewCell.setAttribute('title', `"${rowClubInRussian}" против "Гётеборга"
// ${oldDefeats} побед в дуэлях, ${oldVictories} поражения
// Кликните, чтобы узнать подробности`); 
//             }          
//         }
//         table.rows[ri].cells[35].after(newCell);
//     }
// }


// Для упорядочивания ячеек в строках с 25-й и  ниже:

// for (let ci = 4; ci <= 36; ci ++) {
//     let secPartOfCellID = table.rows[1].cells[ci].getAttribute('id').slice(3);
//     for (let ri = 25; ri <= 34; ri ++) {
//         let firstPartOfCellID = table.rows[ri].cells[3].getAttribute('id').slice(0, 3);
//         if (secPartOfCellID === firstPartOfCellID) {
//             let logo = table.rows[ri].querySelectorAll('img')[1].parentNode;
//             table.rows[ri].cells[ci - 1].after(logo);
//         }
//         else {
//             let cellID = `${firstPartOfCellID}${secPartOfCellID}`;
//             table.rows[ri].cells[ci - 1].after( document.getElementById(cellID) );
//         }
//     }
// }


// Для вставки полурыбных (слизанных со строки "Аякса") ячеек с новыми соперниками
// в неполные строки:

// let monRivals = ``;
// for (let monCellInd = 3; monCellInd < table.rows[29].cells.length; monCellInd += 1) {
//     let currentCellID = table.rows[29].cells[monCellInd].getAttribute('id');
//     if (currentCellID) {
//         let monCurrentRival = currentCellID.slice(3);
//         monRivals = `${monRivals}${monCurrentRival}`;
//     }
// }

// for (let ajxCellInd = 3; ajxCellInd < table.rows[10].cells.length; ajxCellInd += 1) {
//     let currentCellID = table.rows[10].cells[ajxCellInd].getAttribute('id');
//     if (currentCellID) {
//         let ajxCurrentRival = currentCellID.slice(2);
//         if ( !( monRivals.includes(ajxCurrentRival) ) ) {
//             let newCell = document.getElementById(currentCellID).cloneNode(true);
//             newCell.id = `Mon${ajxCurrentRival}`;
//             table.rows[29].append(newCell);
//         }
//     }
// }


// Для вставки колонки с "Монако":

// for (let ri = 1; ri <= 34; ri += 1) {
//     if (ri != 29) {
//         let rowID = '';        
//         let rowPSGID = table.rows[ri].cells[31].getAttribute('id');
//         if ( rowPSGID.includes('MU') ) {rowID = 'MU';}
//         else if ( rowPSGID.includes('Aj') ) {rowID = 'Aj';}
//         else {rowID = rowPSGID.slice(0, 3);}

//         let idInMonRow = `Mon${rowID}`;
//         let newCell = document.getElementById(idInMonRow).cloneNode(true);
//         newCell.id = `${rowID}Mon`;
//         let rowClubInRussian = table.rows[ri].cells[1].querySelector('img').getAttribute('title');
//         let divInNewCell = newCell.querySelector('div');
//         if ( newCell.classList.contains('no-history') ) {
//             divInNewCell.setAttribute('title', `"${rowClubInRussian}" против "Монако"
// В еврокубках не встречались`);
//         }
//         else {
//             let clearDivText = divInNewCell.textContent.trim();
//             let oldVictories = clearDivText[0];
//             let oldDefeats = clearDivText[4];  
//             divInNewCell.textContent = `${oldDefeats} - ${oldVictories}`;               

//             let oldTitleText = divInNewCell.getAttribute('title');                    
//             if ( oldTitleText.includes('победителя') ) {
//                 let textWWithoutClickWords = oldTitleText.slice(0, -34);
//                 let lastCommaIndex = textWWithoutClickWords.lastIndexOf(',');
//                 let oldTextToCopy = textWWithoutClickWords.slice(lastCommaIndex);
//                 divInNewCell.setAttribute('title', `"${rowClubInRussian}" против "Монако"
// ${oldDefeats} побед в дуэлях, ${oldVictories} поражения${oldTextToCopy}Кликните, чтобы узнать подробности`);                 
//             }
//             else {
//                 divInNewCell.setAttribute('title', `"${rowClubInRussian}" против "Монако"
// ${oldDefeats} побед в дуэлях, ${oldVictories} поражения
// Кликните, чтобы узнать подробности`); 
//             }          
//         }
//         table.rows[ri].cells[30].after(newCell);
//     }
// }


// Для удаления дивов 'results':
 
// const results = document.querySelectorAll('.results');
// results.forEach(item => item.remove());


// Для удаления ячеек с "Ноттингемом" и "Астон Виллой":

// for (let ri = 25; ri < table.rows.length; ri += 1) {
//     for (let ci = 0; ci <= table.rows[ri].cells.length; ci +=1) {
//         if ( (table.rows[ri].cells[ci]) && (table.rows[ri].cells[ci].getAttribute('id') !== null) ) {
//             let currentCellID = table.rows[ri].cells[ci].getAttribute('id');
//             if ( currentCellID.includes('Not', 3) ||
//             currentCellID.includes('AsV', 3) ) {
//                 table.rows[ri].cells[ci].classList.add('for-deleting');
//             }
//         }
//     }
// }

// const forDeleting = document.querySelectorAll('.for-deleting');

// forDeleting.forEach(item => item.remove());
