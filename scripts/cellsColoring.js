
// Для РАСКРАШИВАНИЯ ячеек:

document.addEventListener('DOMContentLoaded', () => {
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
}); 