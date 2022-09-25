
document.addEventListener('DOMContentLoaded', async function() {

    let clubsArr = {}
    let rawClubsArr = [] // Массив названий клубов вместе со страной их "приписки"
    let matchesArr = {}

    // Получение данных о клубах и матчах:
    // if (true) {
    async function getClubsArr () {

      const bigTable = document.querySelector('.stat-results__table')
      const tableRowsArr = Array.from(bigTable.rows);
      tableRowsArr.forEach((row, rowInd) => {

          if (rowInd > 0) {

              if (row.cells[7].textContent.trim() !== '– : –') { // Если матч сыгран

                  // console.log('стадия:\n') // стадия
                  // console.log(row.cells[3].textContent) // стадия

                  // console.log('дата:\n') // дата
                  // console.log(row.cells[5].textContent.trim().substr(0, 10)) // дата

                  const clubNames = row.cells[6].querySelectorAll('span.table-item__name')
                  // console.log('клубы-участники:\n') // клубы-участники
                  // console.log(clubNames[0].textContent) // клубы-участники
                  // console.log(clubNames[1].textContent) // клубы-участники
                  let rawClubName_1 = clubNames[0].textContent
                  let rawClubName_2 = clubNames[1].textContent
                  if ( ! (rawClubsArr.includes(rawClubName_1)) ) {
                    rawClubsArr.push(rawClubName_1)
                  }
                  if ( ! (rawClubsArr.includes(rawClubName_2)) ) {
                    rawClubsArr.push(rawClubName_2)
                  }

                  // console.log('счёт:\n') // счёт
                  // console.log(row.cells[7].textContent.trim()) // счёт
                  // console.log('\n')

              }

          }
          
      });

      console.log(rawClubsArr);

    }


    // AJAX-запрос:
    // if (true) {
    async function ajax () {

      // let user = {
      //   name: 'John',
      //   surname: 'Smith'
      // };
      
      let response = await fetch('parser.php', {
        method: 'POST',
        // dataType: 'html',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        // body: JSON.stringify(user)
        body: JSON.stringify(rawClubsArr)
      });
      
      // console.log(response);
      let result = await response.json();
      console.log(result.body);
      // console.log(result.yes);
      // console.log(result.message);

    }


    await getClubsArr()
    await ajax()

})
