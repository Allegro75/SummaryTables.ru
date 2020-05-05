



// Скрипты для автоматического создания обратной (с переменой очередности клубов) копиии
// малой таблицы: 
    
// Для перезаписи тэга title в head:
const titleTagContent = document.getElementsByTagName('title')[0].textContent;    
const delimiterIndex = titleTagContent.indexOf(' - ');
const briefName1 = titleTagContent.slice(0, delimiterIndex);
const briefName2 = titleTagContent.slice(delimiterIndex + 3);
const newTitleContent = `${briefName2} - ${briefName1}`;
document.getElementsByTagName('title')[0].textContent = newTitleContent;
    
// Для перезаписи классов у логотипов:
const logotypes = document.querySelectorAll('img');
logotypes[0].classList.toggle('logo-left');
logotypes[0].classList.toggle('logo-right');
logotypes[1].classList.toggle('logo-left');
logotypes[1].classList.toggle('logo-right');    
    
// Для перезаписи заголовка:
const h3TagContent = document.getElementsByTagName('h3')[0].textContent;    
const headerDelimiterIndex = h3TagContent.indexOf(' - ');
const longName2 = h3TagContent.slice(headerDelimiterIndex + 3);
const longName1 = h3TagContent.slice(0, headerDelimiterIndex);
const newHeaderContent = `${longName2} - ${longName1}`;
document.getElementsByTagName('h3')[0].textContent = newHeaderContent;
    
// Для перезаписи абзацев с общей статой по матчам:
//
// Для перезаписи абзаца с победами-поражениями:
const paragraphs = document.getElementsByTagName('p'),
    resultsPText = paragraphs[1].textContent,
    oldVictories = resultsPText[0],
    resultsSpaceIndex = resultsPText.lastIndexOf(' '),
    oldDefeats = resultsPText[resultsSpaceIndex - 1];
paragraphs[1].textContent = `${oldDefeats}${resultsPText.slice(1, resultsSpaceIndex - 1)}${oldVictories}${resultsPText.slice(resultsSpaceIndex)}`;   

// Для перезаписи абзаца с разницей мячей:
const goalsPText = paragraphs[2].textContent,
    goalsDelimiterIndex = goalsPText.indexOf(' - '),
    oldConcededGoales = goalsPText.slice(goalsDelimiterIndex + 3),
    oldScoredGoals = goalsPText.slice(15, goalsDelimiterIndex);
paragraphs[2].textContent = `${goalsPText.slice(0, 15)}${oldConcededGoales} - ${oldScoredGoals}`;  
    
// Для перезаписи абзаца со счетом в дуэлях:
const duelPs = document.querySelectorAll('div.duels-text p'),
    duelsPText = duelPs[1].textContent,
    oldDuelsVictories = duelsPText[0],
    duelsSpaceIndex = duelsPText.lastIndexOf(' '),
    oldDuelsDefeats = duelsPText[duelsSpaceIndex - 1];
duelPs[1].textContent = `${oldDuelsDefeats}${duelsPText.slice(1, duelsSpaceIndex - 1)}${oldDuelsVictories}${duelsPText.slice(duelsSpaceIndex)}`;
//

// Для перезаписи цвета строк (красный - зелёный):
const rows = document.querySelectorAll('table tr');
for (let i = 1; i < rows.length; i += 1) {
    if ( rows[i].classList.contains('duel-draw') ) {
        continue;
    }    
    rows[i].classList.toggle('duel-loose');
    rows[i].classList.toggle('duel-win');
    if ( rows[i].classList.contains('duel-result') ) {
        if ( rows[i].classList.contains('duel-win') ) {
            rows[i].setAttribute('title', "Дуэль выше выиграна");
            rows[i].innerHTML = '<td colspan="5"></td><td>&#9650;</td>';
        }
        else if ( rows[i].classList.contains('duel-loose') ) {
            rows[i].setAttribute('title', "Дуэль выше проиграна");
            rows[i].innerHTML = '<td colspan="5"></td><td>&#9660;</td>';
        }    
    }
}
    
// Для перезаписи колонки "Поле" ("дома" - "гости"):
const fieldCells = document.querySelectorAll('table tr td:nth-child(2)');
for (let i = 1; i < fieldCells.length - 1; i += 1) {
    let cellTitle = fieldCells[i].getAttribute('title');
    if (cellTitle && ( cellTitle == 'дома') ) {
fieldCells[i].setAttribute('title', 'в гостях');
fieldCells[i].textContent = 'г';
    }
    else if (cellTitle && ( cellTitle == 'в гостях') ) {
fieldCells[i].setAttribute('title', 'дома');
fieldCells[i].textContent = 'д';
    }
}
    
// Для перезаписи колонки таблицы "Счёт":
const scoreCells = document.querySelectorAll('table tr td:nth-child(3)');
for (let i = 1; i < scoreCells.length; i += 1) {
    let cellText = scoreCells[i].innerHTML;
    let oldScoredGoals = cellText[0];
    let oldConcededGoales = cellText[4];
    if ( cellText.includes('победа') ) {
        scoreCells[i].innerHTML = `${oldConcededGoales} : ${oldScoredGoals}${cellText.slice(5).replace('победа', 'поражение')}`;
    }
    else if ( cellText.includes('поражение') ) {
        scoreCells[i].innerHTML = `${oldConcededGoales} : ${oldScoredGoals}${cellText.slice(5).replace('поражение', 'победа')}`;
    }
    else {scoreCells[i].innerHTML = `${oldConcededGoales} : ${oldScoredGoals}${cellText.slice(5)}`;}
}    
    