
console.log('yes')

let clubsArr = []
let matchesArr = []

const bigTable = document.querySelector('.stat-results__table')
bigTable.rows.array.forEach((row, rowInd) => {

    if (rowInd > 0) {
        console.log(row.cells[3].textContent)
    }
    
});
