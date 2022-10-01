
document.addEventListener('DOMContentLoaded', async function() {

    let rawClubsArr = [] // Массив названий клубов вместе со страной их "приписки"
    let matchesArr = []

    // Получение данных о клубах и матчах:
    // if (true) {
    async function getClubsAndMatchesArrs () {

      const bigTable = document.querySelector('.stat-results__table')
      const tableRowsArr = Array.from(bigTable.rows);
      tableRowsArr.forEach((row, rowInd) => {

          if (rowInd > 0) {

              if (row.cells[7].textContent.trim() !== '– : –') { // Если матч сыгран

                  let curMatch = {}
                  // console.log('стадия:\n') // стадия
                  // console.log(row.cells[3].textContent) // стадия
                  curMatch['stage'] = row.cells[3].textContent

                  // console.log('дата:\n') // дата
                  // console.log(row.cells[5].textContent.trim().substr(0, 10)) // дата
                  curMatch['date'] = row.cells[5].textContent.trim().substr(0, 10)

                  const clubNames = row.cells[6].querySelectorAll('span.table-item__name') // клубы-участники
                  let rawClubName_1 = clubNames[0].textContent
                  let rawClubName_2 = clubNames[1].textContent
                  if ( ! (rawClubsArr.includes(rawClubName_1)) ) {
                    rawClubsArr.push(rawClubName_1)
                  }
                  if ( ! (rawClubsArr.includes(rawClubName_2)) ) {
                    rawClubsArr.push(rawClubName_2)
                  }
                  curMatch['firstClub'] = rawClubName_1
                  curMatch['secClub'] = rawClubName_2

                  // console.log('счёт:\n') // счёт
                  // console.log(row.cells[7].textContent.trim()) // счёт
                  // console.log('\n')
                  curMatch['score'] = row.cells[7].textContent.trim()

                  matchesArr.push(curMatch)

              }

          }
          
      });

      // console.log(rawClubsArr);
      console.log(matchesArr);
      const clubsAndMatches = {
        'clubs' : rawClubsArr,
        'matches' : matchesArr,
      }

    }


    // AJAX-запрос:
    // if (true) {
    async function ajax () {
      
      let response = await fetch('parser.php', {
        method: 'POST',
        // dataType: 'html',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(rawClubsArr)
      });
      
      let result = await response.json();
      console.log(result);

    }


    await getClubsAndMatchesArrs()
    await ajax()

})
