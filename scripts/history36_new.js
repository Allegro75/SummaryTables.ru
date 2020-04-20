
//
//Для ВСПЛЫТИЯ окон с подробной статистикой по клику на ячейку большой таблицы:
//

const table = document.querySelector('table.main-table');
table.onclick = function() {
    var target = event.target;
    while (target != table) {
        if (target.getAttribute('class') == 'statistics has-history') {
            var tableDataId = target.getAttribute('id');
            var urlInWindowOpen = 'football-small-tables/' +
            tableDataId + '.html';
            window.open(urlInWindowOpen, '', 'width=650px, height=900px');
            return;
            }
        target = target.parentNode;
        }
    };



// Служебные скрипты для переделывания таблицы:  

// Для вставки колонки со "Стяуа":

// for (let ri = 1; ri < 33; ri += 1) {
//     if ( (ri != 26) && (ri != 28) ) {
//         let rowID = '';        
//         let rowPSGID = table.rows[ri].cells[31].getAttribute('id');
//         if ( rowPSGID.includes('MU') ) {rowID = 'MU';}
//         else if ( rowPSGID.includes('Aj') ) {rowID = 'Aj';}
//         else {rowID = rowPSGID.slice(0, 3);}

//         let idInSteRow = `Ste${rowID}`;
//         let newCell = document.getElementById(idInSteRow).cloneNode(true);
//         newCell.id = `${rowID}Ste`;
//         let rowClubInRussian = table.rows[ri].cells[1].querySelector('img').getAttribute('title');
//         let divInNewCell = newCell.querySelector('div');
//         if ( newCell.classList.contains('no-history') ) {
//             divInNewCell.setAttribute('title', `"${rowClubInRussian}" против "Стяуа"
// Не встречались`);
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
//                 divInNewCell.setAttribute('title', `"${rowClubInRussian}" против "Стяуа"
// ${oldDefeats} побед в дуэлях, ${oldVictories} поражения${oldTextToCopy}Кликните, чтобы узнать подробности`);                 
//             }
//             else {
//                 divInNewCell.setAttribute('title', `"${rowClubInRussian}" против "Стяуа"
// ${oldDefeats} побед в дуэлях, ${oldVictories} поражения
// Кликните, чтобы узнать подробности`); 
//             }          
//         }
//         table.rows[ri].cells[34].after(newCell);
//     }
// }


// Для вставки колонки с "Фейеноордом":

// for (let ri = 1; ri < 33; ri += 1) {
//     if ( (ri != 26) && (ri != 28) ) {
//         let rowID = '';        
//         let rowPSGID = table.rows[ri].cells[31].getAttribute('id');
//         if ( rowPSGID.includes('MU') ) {rowID = 'MU';}
//         else if ( rowPSGID.includes('Aj') ) {rowID = 'Aj';}
//         else {rowID = rowPSGID.slice(0, 3);}

//         let idInFeyRow = `Fey${rowID}`;
//         let newCell = document.getElementById(idInFeyRow).cloneNode(true);
//         newCell.id = `${rowID}Fey`;
//         let rowClubInRussian = table.rows[ri].cells[1].querySelector('img').getAttribute('title');
//         let divInNewCell = newCell.querySelector('div');
//         if ( newCell.classList.contains('no-history') ) {
//             divInNewCell.setAttribute('title', `"${rowClubInRussian}" против "Фейеноорда"
// Не встречались`);
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
//                 divInNewCell.setAttribute('title', `"${rowClubInRussian}" против "Фейеноорда"
// ${oldDefeats} побед в дуэлях, ${oldVictories} поражения${oldTextToCopy}Кликните, чтобы узнать подробности`);                 
//             }
//             else {
//                 divInNewCell.setAttribute('title', `"${rowClubInRussian}" против "Фейеноорда"
// ${oldDefeats} побед в дуэлях, ${oldVictories} поражения
// Кликните, чтобы узнать подробности`); 
//             }          
//         }
//         table.rows[ri].cells[29].after(newCell);
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


// Для вставки полурыбных (слизанных со строки "Аякса") ячеек с новыми соперниками
// в неполные строки:

// let marRivals = ``;
// for (let marCellInd = 3; marCellInd < table.rows[26].cells.length; marCellInd += 1) {
//     let currentCellID = table.rows[26].cells[marCellInd].getAttribute('id');
//     if (currentCellID) {
//         let marCurrentRival = currentCellID.slice(3);
//         marRivals = `${marRivals}${marCurrentRival}`;
//     }
// }

// for (let ajxCellInd = 3; ajxCellInd < table.rows[10].cells.length; ajxCellInd += 1) {
//     let currentCellID = table.rows[10].cells[ajxCellInd].getAttribute('id');
//     if (currentCellID) {
//         let ajxCurrentRival = currentCellID.slice(2);
//         if ( !( marRivals.includes(ajxCurrentRival) ) ) {
//             let newCell = document.getElementById(currentCellID).cloneNode(true);
//             newCell.id = `Mar${ajxCurrentRival}`;
//             table.rows[26].append(newCell);

//             newCell = document.getElementById(currentCellID).cloneNode(true);
//             newCell.id = `Fey${ajxCurrentRival}`;
//             table.rows[28].append(newCell);

//             newCell = document.getElementById(currentCellID).cloneNode(true);
//             newCell.id = `Ste${ajxCurrentRival}`;
//             table.rows[33].append(newCell);            
//             }
//     }
// }
