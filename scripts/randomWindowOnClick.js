 
// Для всплытия СЛУЧАЙНОГО окна с подробной статистикой:

document.addEventListener('DOMContentLoaded', () => {
    document.querySelector(`button.show-random__btn`).addEventListener('click', () =>{
        const allCellsWHistory = document.querySelectorAll('td.has-history');
        let randomPairIndex = Math.floor( ( allCellsWHistory.length * Math.random() ) );
        const randomPairCell = allCellsWHistory[randomPairIndex];
        const randomCellID = randomPairCell.getAttribute('id'); 
        const urlInRandomWindow = `football-small-tables/${randomCellID}.html`;
        // const newWindowLeftPosition = document.documentElement.clientWidth - 480;
        // const newWindowTopPosition = document.documentElement.clientHeight - 560;
        // window.open(urlInRandomWindow, ``, `width=480px, height=600px, left=${newWindowLeftPosition}px, top=${newWindowTopPosition}px`);
        window.open(urlInRandomWindow, ``, `width=520px, height=970px, top=0, left=0`);
    });
});