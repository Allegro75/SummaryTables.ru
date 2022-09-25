
document.addEventListener('DOMContentLoaded', () => {

    // Получение данных о клубах и матчах:
    let clubsArr = {}
    let matchesArr = {}

    const bigTable = document.querySelector('.stat-results__table')
    const tableRowsArr = Array.from(bigTable.rows);
    tableRowsArr.forEach((row, rowInd) => {

        if (rowInd > 0) {

            // if (row.cells[7].textContent.trim() !== '– : –') { // Если матч сыгран

            //     console.log('стадия:\n') // стадия
            //     console.log(row.cells[3].textContent) // стадия

            //     console.log('дата:\n') // дата
            //     console.log(row.cells[5].textContent.trim().substr(0, 10)) // дата

            //     const clubNames = row.cells[6].querySelectorAll('span.table-item__name')
            //     console.log('клубы-участники:\n') // клубы-участники
            //     console.log(clubNames[0].textContent) // клубы-участники
            //     console.log(clubNames[1].textContent) // клубы-участники

            //     console.log('счёт:\n') // счёт
            //     console.log(row.cells[7].textContent.trim()) // счёт
            //     console.log('\n')

            // }

        }
        
    });


    let response = fetch('../parser.php');

    if (response.ok) { // если HTTP-статус в диапазоне 200-299      
      let json = response.json();
      console.log(response);
    } else {
      alert("Ошибка HTTP: " + response.status);
    }    

})
