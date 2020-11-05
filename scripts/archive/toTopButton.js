// Для формирования СТРЕЛОЧНОЙ навигации по турнирам:
document.addEventListener('DOMContentLoaded', () => {
    const toTopFunction = () => {
        document.body.scrollTop = 0; // Для Safari
        document.documentElement.scrollTop = 0; // Для других браузеров
    }

    document.body.insertAdjacentHTML(`beforeend`,
    `<button id='toTop' title='Наверх'>
    ▲<br>Наверх</button>`);

    const toTopBtn = document.getElementById(`toTop`);

    toTopBtn.addEventListener(`click`, toTopFunction);

    const scrollFunction = () => {        
        if (document.body.scrollTop > 480 ||
            document.documentElement.scrollTop > 480) {
                toTopBtn.style.display = `block`;
            } else {
                toTopBtn.style.display = `none`;
            }
    }

    window.onscroll = function() {scrollFunction()};    
});