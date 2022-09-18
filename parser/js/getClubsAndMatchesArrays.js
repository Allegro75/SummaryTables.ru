
document.addEventListener('DOMContentLoaded', () => {

    let clubsArr = {}
    let matchesArr = {}

    const bigTable = document.querySelector('.stat-results__table')
    const tableRowsArr = Array.from(bigTable.rows);
    tableRowsArr.forEach((row, rowInd) => {

        if (rowInd > 0) {
            console.log(row.cells[3].textContent) // стадия
            console.log(row.cells[5].textContent) // дата
            console.log(row.cells[6].textContent) // клубы-участники
            console.log(row.cells[7].textContent) // счёт
        }
        
    });

})
