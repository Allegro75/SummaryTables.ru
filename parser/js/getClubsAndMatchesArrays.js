
console.log('yes')

document.addEventListener('DOMContentLoaded', () => {

    let clubsArr = []
    let matchesArr = []

    const bigTable = document.querySelector('.stat-results__table')
    // console.log(bigTable)
    const tableRowsArr = Array.from(bigTable.rows);
    tableRowsArr.forEach((row, rowInd) => {

        if (rowInd > 0) {
            console.log(row.cells[3].textContent)
        }
        
    });

})
