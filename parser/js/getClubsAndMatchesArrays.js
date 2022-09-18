
console.log('yes')

document.addEventListener('DOMContentLoaded', () => {

    let clubsArr = []
    let matchesArr = []

    const bigTable = document.querySelector('.stat-results__table')
    bigTable.rows.forEach((row, rowInd) => {

        if (rowInd > 0) {
            console.log(row.cells[3].textContent)
        }
        
    });

})
