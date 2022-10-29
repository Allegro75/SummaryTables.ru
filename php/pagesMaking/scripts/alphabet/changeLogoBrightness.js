
// Для ЗАМЕНЫ логотипов на лого другой светлоты:
document.addEventListener('DOMContentLoaded', () => {

    // Для определения КОДА клуба по адресу его лого:
    const logoCode = (elem) => {
        if (elem.getAttribute(`src`).slice(-9, -4) === `_dark`) {
            return elem.getAttribute(`src`).slice(-12, -9);
        } else
        return elem.getAttribute(`src`).slice(-7, -4);
    }    

    // Формируем наборы логотипов (из строк таблиц) для изменения их светлоты:
    let allLogosToLight, allLogosToDark;
    let pathToImage;
    let queryPart = `.ab-row img[src='../images/`; 

    const tryToMakeBrightList = document.querySelectorAll(`${queryPart}And.png'], ${queryPart}Mar.png']`);
    const tryToMakeDarkList = document.querySelectorAll(`${queryPart}And.png']`);

    if (tryToMakeBrightList.length > 0 ) {
        allLogosToLight = tryToMakeBrightList;
        pathToImage = `../images/`;
    }
    else {
        // Это сработает в файле alphabet.html из корня проекта:
        queryPart = `.ab-row img[src='images/`;
        pathToImage = `images/`;
        allLogosToLight = document.querySelectorAll(`${queryPart}And.png'], ${queryPart}Mar.png']`);       
    }

    // Перебираем массив логотипов для ОСВЕТЛЕНИЯ:
    if (allLogosToLight.length > 0) {
        allLogosToLight.forEach(elem => {
            // Находим список, в к-ром находится данный логотип:
            let listWLogo = elem.parentElement.parentElement.parentElement.parentElement;
            // Находим строку, в к-рой находится данный логотип:
            let strWLogo = elem.parentElement.parentElement.parentElement;        
            // Находим индекс строки с данным логотипом в списке:
            let indexInList = [...listWLogo.children].indexOf(strWLogo);
            if ((indexInList % 2) === 0) {
               elem.setAttribute('src', `${pathToImage}${logoCode(elem)}_light.png`);
            }            
        });
    }

    if (tryToMakeDarkList.length > 0 ) {
        allLogosToDark = tryToMakeDarkList;
        pathToImage = `../images/`;
    }
    else {
        // Это сработает в файле alphabet.html из корня проекта:
        queryPart = `.ab-row img[src='images/`;
        pathToImage = `images/`;
        allLogosToDark = document.querySelectorAll(`${queryPart}And.png']`);;       
    }

    // Перебираем массив логотипов для ЗАТЕМНЕНИЯ:
    if (allLogosToDark.length > 0) {
        allLogosToDark.forEach(elem => {
            // Находим список, в к-ром находится данный логотип:
            let listWLogo = elem.parentElement.parentElement.parentElement.parentElement;
            // Находим строку, в к-рой находится данный логотип:
            let strWLogo = elem.parentElement.parentElement.parentElement;        
            // Находим индекс строки с данным логотипом в списке:
            let indexInList = [...listWLogo.children].indexOf(strWLogo);
            if ((indexInList % 2) === 1) {
               elem.setAttribute('src', `${pathToImage}${logoCode(elem)}_dark.png`);
            }            
        });  
    }  

});