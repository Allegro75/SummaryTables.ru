//Сделал добавку (с названиями команд) к всплывающей подсказке:

let statisticsCells = document.querySelectorAll('td.statistics');

for (let cell of statisticsCells) {
    let divInCell = cell.firstElementChild;
    let oldTitleText = divInCell.getAttribute('title');
    let cellId = cell.getAttribute('id');
    let firstClubName, secondClubName;
    switch (cellId.slice(0, 2)) {
        case 'Aj':
            firstClubName = 'Аякс';
            break;
        case 'At':
            firstClubName = 'Атлетико';
            break;
        case 'Be':
            firstClubName = 'Бенфика';
            break;        
        case 'Bo':
            firstClubName = 'Боруссия';
            break;
        case 'Ch':
            firstClubName = 'Челси';
            break;
        case 'In':
            firstClubName = 'Интер';
            break;
        case 'Ju':
            firstClubName = 'Ювентус';
            break;        
        case 'Li':
            firstClubName = 'Ливерпуль';
            break;
        case 'MC':
            firstClubName = 'МанСити';
            break;
        case 'Na':
            firstClubName = 'Наполи';
            break;
        case 'PS':
            firstClubName = 'ПСЖ';
            break;        
        case 'RM':
            firstClubName = 'Реал';
            break;
        case 'To':
            firstClubName = 'Тоттенхэм';
            break;
        case 'Va':
            firstClubName = 'Валенсия';
            break;

        case 'Ba':
            if (cellId[2] == 'r') firstClubName = 'Барселона';
            else firstClubName = 'Бавария';
            break;   

        default:
            break;
    }

    switch (cellId.slice(-2)) {
        case 'Aj':
            secondClubName = 'Аякс';
            break;
        case 'tM':
            secondClubName = 'Атлетико';
            break;
        case 'en':
            secondClubName = 'Бенфика';
            break;        
        case 'oD':
            secondClubName = 'Боруссия';
            break;
        case 'he':
            secondClubName = 'Челси';
            break;
        case 'nt':
            secondClubName = 'Интер';
            break;
        case 'uv':
            secondClubName = 'Ювентус';
            break;        
        case 'iv':
            secondClubName = 'Ливерпуль';
            break;
        case 'MC':
            secondClubName = 'МанСити';
            break;
        case 'ap':
            secondClubName = 'Наполи';
            break;
        case 'SG':
            secondClubName = 'ПСЖ';
            break;        
        case 'Ma':
            secondClubName = 'Реал';
            break;
        case 'ot':
            secondClubName = 'Тоттенхэм';
            break;
        case 'al':
            secondClubName = 'Валенсия';
            break;
        case 'ar':
            secondClubName = 'Барселона';
            break;
        case 'av':
            secondClubName = 'Бавария';
            break;   

        default:
            break;
    }

    divInCell.setAttribute('title', firstClubName + ' - ' 
    + secondClubName + "\n" + oldTitleText);
}

