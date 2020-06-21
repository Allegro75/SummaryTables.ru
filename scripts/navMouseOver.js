
// Для перекрашивания пунктов НАВИГАЦИИ при наведении мыши:

document.addEventListener('DOMContentLoaded', () => {
    let navItems = document.querySelectorAll('li.nav__stripe__list__item');
    navItems.forEach((item) => {
        item.addEventListener('mouseover', () => {
            item.querySelector('img.nav__icon_yellow').style = 'display: none;';
            item.querySelector('img.nav__icon_black').style = 'display: inline;';
        });
        item.addEventListener('mouseout', () => {
            item.querySelector('img.nav__icon_yellow').style = 'display: inline;';
            item.querySelector('img.nav__icon_black').style = 'display: none;';
        });        
    });    
}); 