
document.addEventListener('DOMContentLoaded', () => {

    let clubsArr = {}
    let matchesArr = {}

    const bigTable = document.querySelector('.stat-results__table')
    const tableRowsArr = Array.from(bigTable.rows);
    tableRowsArr.forEach((row, rowInd) => {

        if (rowInd > 0) {

            console.log('стадия:\n') // стадия
            console.log(row.cells[3].textContent) // стадия
            console.log('\n') // стадия

            console.log('дата:\n') // дата
            console.log(row.cells[5].textContent.trim().substr(0, 10)) // дата
            console.log('\n') // дата

            // console.log(row.cells[6].textContent) // клубы-участники
            const clubNames = row.cells[6].querySelectorAll('span.table-item__name')
            console.log('клубы-участники:\n') // клубы-участники
            console.log(clubNames[0]) // клубы-участники
            console.log(clubNames[1]) // клубы-участники
            console.log('\n')

            console.log('счёт:\n') // счёт
            console.log(row.cells[7].textContent) // счёт
            console.log('\n')

        }
        
    });

})
