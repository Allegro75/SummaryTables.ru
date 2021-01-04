// Для ЗАМЕНЫ логотипов на лого другой светлоты:
document.addEventListener('DOMContentLoaded', () => {

    // Формируем набор логотипов "Андерлехта" в строках таблиц:
    let allAnderlLogos, pathToImage;
    const tryToMakeLogosList = document.querySelectorAll(`.ab-row img[src='../images/And.png`);
    if (tryToMakeLogosList.length > 0 ) {
        allAnderlLogos = tryToMakeLogosList;
        pathToImage = `../images/`;
    } else {
        // Это сработает в файле alphabet.html из корня проекта:
        allAnderlLogos = document.querySelectorAll(`.ab-row img[src='images/And.png`);        
        if (allAnderlLogos.length === 0) return;
        pathToImage = `images/`;
    }

    // Перебираем массив логотипов:
    for (let i = 0; i < allAnderlLogos.length; i++) {
        // Находим список, в к-ром находится данный логотип:
        let listWLogo = allAnderlLogos[i].parentElement.parentElement.parentElement.parentElement;
        // Находим строку, в к-рой находится данный логотип:
        let strWLogo = allAnderlLogos[i].parentElement.parentElement.parentElement;
        // Находим индекс строки с данным логотипом в списке:
        let indexInList = [...listWLogo.children].indexOf(strWLogo);

        if ((indexInList % 2) === 0) {
            allAnderlLogos[i].setAttribute('src', `${pathToImage}And_light.png`);
        } else {
            allAnderlLogos[i].setAttribute('src', `${pathToImage}And_dark.png`);
        }
    }

});