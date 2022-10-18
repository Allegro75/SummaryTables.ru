// Для формирования СТРЕЛОЧНОЙ навигации по турнирам:
document.addEventListener('DOMContentLoaded', () => {
    const docHeader = document.querySelector(`h1`).innerText;
    const currentTourneyYear = +docHeader.slice(-4);
    const cTY = currentTourneyYear;
    let curTourneyName;
    if (docHeader.includes(`ЧЕМПИОНОВ`)) {
        curTourneyName = `cl`;
    } else if (docHeader.includes(`КУБКОВ`)) {
        curTourneyName = `cwc`;
    } else {
        curTourneyName = `el`;
    }

    const mainBlock = document.querySelector(`main`);
    const arNavDiv = document.createElement(`div`);
    mainBlock.prepend(arNavDiv);
    arNavDiv.classList.add(`arrow-navigation`);

    // Создаём блок для кнопок "Назад":
    if (cTY >= 1957) {
        const leftDiv = document.createElement(`div`);
        arNavDiv.append(leftDiv);
        leftDiv.classList.add(`ar-nav__left`, `ar-nav-left`);

        // Создаём ссылку на предыдущую лигу ЧЕМПИОНОВ:
        const leftCLAnchor = document.createElement(`a`);
        leftDiv.append(leftCLAnchor);
        let cLAbbr = `КЧ`;
        // Если данный файл сам является лигой чемпионов:
        if (curTourneyName === `cl`) {
            leftCLAnchor.setAttribute(`href`, `cl_${cTY - 1}.html`);
            if (cTY >= 1994) {
                leftCLAnchor.setAttribute(`title`, `Предыдущая лига чемпионов, ${cTY - 2}/${cTY - 1}`);
                cLAbbr = `ЛЧ`;
            } else {
                leftCLAnchor.setAttribute(`title`, `Предыдущий кубок чемпионов, ${cTY - 2}/${cTY - 1}`);
            }
            // Если же нет (не лигой чемпионов):
        } else {
            leftCLAnchor.setAttribute(`href`, `../champ_league/cl_${cTY - 1}.html`);
            if (cTY >= 1993) {
                leftCLAnchor.setAttribute(`title`, `Лига чемпионов предыдущего сезона, ${cTY - 2}/${cTY - 1}`);
                cLAbbr = `ЛЧ`;
            } else {
                leftCLAnchor.setAttribute(`title`, `Кубок чемпионов предыдущего сезона, ${cTY - 2}/${cTY - 1}`);
            }
        }
        const leftCLDiv = document.createElement(`div`);
        leftCLAnchor.append(leftCLDiv);
        leftCLDiv.classList.add(`arrow-nav-btn`, `arrow-nav-btn_back`);
        leftCLDiv.innerText = `◄ ${cLAbbr} ${cTY - 1}`;

        // Создаём ссылку на предыдущий кубок КУБКОВ:
        if ((cTY >= 1962) && (cTY <= 2000)) {
            const leftCWCAnchor = document.createElement(`a`);
            leftDiv.append(leftCWCAnchor);
            // Если данный файл сам является кубком кубков:
            if (curTourneyName === `cwc`) {
                leftCWCAnchor.setAttribute(`href`, `cwc_${cTY - 1}.html`);
                leftCWCAnchor.setAttribute(`title`, `Предыдущий кубок кубков, ${cTY - 2}/${cTY - 1}`);
            }
            // Если же нет (не кубком кубков):
            else {
                leftCWCAnchor.setAttribute(`href`, `../cup_win_cup/cwc_${cTY - 1}.html`);
                leftCWCAnchor.setAttribute(`title`, `Кубок кубков предыдущего сезона, ${cTY - 2}/${cTY - 1}`);
            }
            const leftCWCDiv = document.createElement(`div`);
            leftCWCAnchor.append(leftCWCDiv);
            leftCWCDiv.classList.add(`arrow-nav-btn`, `arrow-nav-btn_back`);
            leftCWCDiv.innerText = `◄ КК ${cTY - 1}`;
        }

        // Создаём ссылку на предыдущую лигу ЕВРОПЫ:
        if (cTY >= 1959) {
            const leftELAnchor = document.createElement(`a`);
            leftDiv.append(leftELAnchor);
            let eLAbbr = `КЯ`;
            let eLYear = cTY - 1;
            // Если данный файл сам является лигой Европы:
            if (curTourneyName === `el`) {
                if (cTY === 1959 || cTY === 1960) {
                    leftELAnchor.setAttribute(`href`, `el_1958.html`);
                    leftELAnchor.setAttribute(`title`, `Предыдущий кубок ярмарок, 1955/1958`);
                    eLYear = 1958;
                }
                else if (cTY === 1961) {
                    leftELAnchor.setAttribute(`href`, `el_1960.html`);
                    leftELAnchor.setAttribute(`title`, `Предыдущий кубок ярмарок, 1958/1960`);
                }
                else if (cTY <= 1972) {
                    leftELAnchor.setAttribute(`href`, `el_${cTY - 1}.html`);
                    leftELAnchor.setAttribute(`title`, `Предыдущий кубок ярмарок, ${cTY - 2}/${cTY - 1}`);
                }
                else if (cTY <= 2010) {
                    leftELAnchor.setAttribute(`href`, `el_${cTY - 1}.html`);
                    leftELAnchor.setAttribute(`title`, `Предыдущий кубок УЕФА, ${cTY - 2}/${cTY - 1}`);
                    eLAbbr = `КУ`;
                }
                else {
                    leftELAnchor.setAttribute(`href`, `el_${cTY - 1}.html`);
                    leftELAnchor.setAttribute(`title`, `Предыдущая лига Европы, ${cTY - 2}/${cTY - 1}`);
                    eLAbbr = `ЛЕ`;
                }
            }
            // Если же данный файл НЕ является лигой Европы:
            else {
                if (cTY === 1959 || cTY === 1960) {
                    leftELAnchor.setAttribute(`href`, `../euroleague/el_1958.html`);
                    leftELAnchor.setAttribute(`title`, `Предыдущий кубок ярмарок, 1955/1958`);
                    eLYear = 1958;
                }
                else if (cTY === 1961) {
                    leftELAnchor.setAttribute(`href`, `../euroleague/el_1960.html`);
                    leftELAnchor.setAttribute(`title`, `Кубок ярмарок предыдущего сезона, 1958/1960`);
                }
                else if (cTY <= 1972) {
                    leftELAnchor.setAttribute(`href`, `../euroleague/el_${cTY - 1}.html`);
                    leftELAnchor.setAttribute(`title`, `Кубок ярмарок предыдущего сезона, ${cTY - 2}/${cTY - 1}`);
                }
                else if (cTY <= 2010) {
                    leftELAnchor.setAttribute(`href`, `../euroleague/el_${cTY - 1}.html`);
                    leftELAnchor.setAttribute(`title`, `Кубок УЕФА предыдущего сезона, ${cTY - 2}/${cTY - 1}`);
                    eLAbbr = `КУ`;
                }
                else {
                    leftELAnchor.setAttribute(`href`, `../euroleague/el_${cTY - 1}.html`);
                    leftELAnchor.setAttribute(`title`, `Лига Европы предыдущего сезона, ${cTY - 2}/${cTY - 1}`);
                    eLAbbr = `ЛЕ`;
                }
            }
            const leftELDiv = document.createElement(`div`);
            leftELAnchor.append(leftELDiv);
            leftELDiv.classList.add(`arrow-nav-btn`, `arrow-nav-btn_back`);
            leftELDiv.innerText = `◄ ${eLAbbr} ${eLYear}`;
        }

    }

    // Создаём блок для кнопок "Вперёд":
    if (cTY <= 2021) {
        const rightDiv = document.createElement(`div`);
        arNavDiv.append(rightDiv);
        rightDiv.classList.add(`ar-nav__right`, `ar-nav-right`);

        // Создаём ссылку на следующую лигу ЧЕМПИОНОВ:
        const rightCLAnchor = document.createElement(`a`);
        rightDiv.append(rightCLAnchor);
        cLAbbr = `КЧ`;
        // Если данный файл сам является лигой чемпионов:
        if (curTourneyName === `cl`) {
            rightCLAnchor.setAttribute(`href`, `cl_${cTY + 1}.html`);
            if (cTY <= 1991) {
                rightCLAnchor.setAttribute(`title`, `Следующий кубок чемпионов, ${cTY}/${cTY + 1}`);
            } else {
                rightCLAnchor.setAttribute(`title`, `Следующая лига чемпионов, ${cTY}/${cTY + 1}`);
                cLAbbr = `ЛЧ`;
            }
            // Если же нет (не лигой чемпионов):
        } else {
            rightCLAnchor.setAttribute(`href`, `../champ_league/cl_${cTY + 1}.html`);
            if (cTY <= 1992) {
                rightCLAnchor.setAttribute(`title`, `Кубок чемпионов следующего сезона, ${cTY}/${cTY + 1}`);
            } else {
                rightCLAnchor.setAttribute(`title`, `Лига чемпионов следующего сезона, ${cTY}/${cTY + 1}`);
                cLAbbr = `ЛЧ`;
            }
        }
        const rightCLDiv = document.createElement(`div`);
        rightCLAnchor.append(rightCLDiv);
        rightCLDiv.classList.add(`arrow-nav-btn`, `arrow-nav-btn_forward`);
        rightCLDiv.innerText = `${cLAbbr} ${cTY + 1} ►`;

        // Создаём ссылку на следующий кубок КУБКОВ:
        if ((cTY >= 1960) && (cTY <= 1998)) {
            const rightCWCAnchor = document.createElement(`a`);
            rightDiv.append(rightCWCAnchor);
            // Если данный файл сам является кубком кубков:
            if (curTourneyName === `cwc`) {
                rightCWCAnchor.setAttribute(`href`, `cwc_${cTY + 1}.html`);
                rightCWCAnchor.setAttribute(`title`, `Следующий кубок кубков, ${cTY}/${cTY + 1}`);
            }
            // Если же нет (не кубком кубков):
            else {
                rightCWCAnchor.setAttribute(`href`, `../cup_win_cup/cwc_${cTY + 1}.html`);
                rightCWCAnchor.setAttribute(`title`, `Кубок кубков следующего сезона, ${cTY}/${cTY + 1}`)
            }
            const rightCWCDiv = document.createElement(`div`);
            rightCWCAnchor.append(rightCWCDiv);
            rightCWCDiv.classList.add(`arrow-nav-btn`, `arrow-nav-btn_forward`);
            rightCWCDiv.innerText = `КК ${cTY + 1} ►`;
        }

        // Создаём ссылку на следующую лигу ЕВРОПЫ:
        const rightELAnchor = document.createElement(`a`);
        rightDiv.append(rightELAnchor);
        eLAbbr = `КЯ`;
        eLYear = cTY + 1;
        // Если данный файл сам является лигой Европы:
        if (curTourneyName === `el`) {
            if (cTY === 1958) {
                rightELAnchor.setAttribute(`href`, `el_1960.html`);
                rightELAnchor.setAttribute(`title`, `Следующий кубок ярмарок, 1958/1960`);
                eLYear = 1960;
            }
            else if (cTY <= 1970) {
                rightELAnchor.setAttribute(`href`, `el_${cTY + 1}.html`);
                rightELAnchor.setAttribute(`title`, `Следующий кубок ярмарок, ${cTY}/${cTY + 1}`);
            }
            else if (cTY <= 2008) {
                rightELAnchor.setAttribute(`href`, `el_${cTY + 1}.html`);
                rightELAnchor.setAttribute(`title`, `Следующий кубок УЕФА, ${cTY}/${cTY + 1}`);
                eLAbbr = `КУ`;
            }
            else {
                rightELAnchor.setAttribute(`href`, `el_${cTY + 1}.html`);
                rightELAnchor.setAttribute(`title`, `Следующая лига Европы, ${cTY}/${cTY + 1}`);
                eLAbbr = `ЛЕ`;
            }
        }
        // Если же данный файл НЕ является лигой Европы:
        else {
            if (cTY <= 1957) {
                rightELAnchor.setAttribute(`href`, `../euroleague/el_1958.html`);
                rightELAnchor.setAttribute(`title`, `Следующий кубок ярмарок, 1955/1958`);
                eLYear = 1958;
            }
            else if (cTY === 1958 || cTY === 1959) {
                rightELAnchor.setAttribute(`href`, `../euroleague/el_1960.html`);
                rightELAnchor.setAttribute(`title`, `Следующий кубок ярмарок, 1958/1960`);
                eLYear = 1960;
            }
            else if (cTY <= 1970) {
                rightELAnchor.setAttribute(`href`, `../euroleague/el_${cTY + 1}.html`);
                rightELAnchor.setAttribute(`title`, `Кубок ярмарок следующего сезона, ${cTY}/${cTY + 1}`);
            }
            else if (cTY <= 2008) {
                rightELAnchor.setAttribute(`href`, `../euroleague/el_${cTY + 1}.html`);
                rightELAnchor.setAttribute(`title`, `Кубок УЕФА следующего сезона, ${cTY}/${cTY + 1}`);
                eLAbbr = `КУ`;
            }
            else {
                rightELAnchor.setAttribute(`href`, `../euroleague/el_${cTY + 1}.html`);
                rightELAnchor.setAttribute(`title`, `Лига Европы следующего сезона, ${cTY}/${cTY + 1}`);
                eLAbbr = `ЛЕ`;
            }
        }
        const rightELDiv = document.createElement(`div`);
        rightELAnchor.append(rightELDiv);
        rightELDiv.classList.add(`arrow-nav-btn`, `arrow-nav-btn_forward`);
        rightELDiv.innerText = `${eLAbbr} ${eLYear} ►`;

    }


    // Создаём блок для ссылок на "соседние" турниры:
    const bottomDiv = document.createElement(`div`);
    document.body.append(bottomDiv);
    bottomDiv.classList.add(`ar-nav-bottom`);

    // Создаём ссылку на соседнюю лигу ЧЕМПИОНОВ:
    if (curTourneyName !== `cl`) /* убеждаемся, что данный файл не является лигой чемпионов */ {
        const bottomCLAnchor = document.createElement(`a`);
        bottomDiv.append(bottomCLAnchor);
        cLAbbr = `КЧ`;
        bottomCLAnchor.setAttribute(`href`, `../champ_league/cl_${cTY}.html`);
        if (cTY >= 1993) {
            bottomCLAnchor.setAttribute(`title`, `Лига чемпионов этого сезона, ${cTY - 1}/${cTY}`);
            cLAbbr = `ЛЧ`;
        } else {
            bottomCLAnchor.setAttribute(`title`, `Кубок чемпионов этого сезона, ${cTY - 1}/${cTY}`);
        }
        const bottomCLDiv = document.createElement(`div`);
        bottomCLAnchor.append(bottomCLDiv);
        bottomCLDiv.classList.add(`arrow-nav-btn`, `arrow-nav-btn_bottom`);
        bottomCLDiv.innerText = `${cLAbbr} ${cTY}`;
    }

    // Создаём ссылку на соседний кубок КУБКОВ:
    if ((cTY >= 1961) && (cTY <= 1999) && (curTourneyName !== `cwc`)) {
        const bottomCWCAnchor = document.createElement(`a`);
        bottomDiv.append(bottomCWCAnchor);
        bottomCWCAnchor.setAttribute(`href`, `../cup_win_cup/cwc_${cTY}.html`);
        bottomCWCAnchor.setAttribute(`title`, `Кубок кубков этого сезона, ${cTY - 1}/${cTY}`);
        const bottomCWCDiv = document.createElement(`div`);
        bottomCWCAnchor.append(bottomCWCDiv);
        bottomCWCDiv.classList.add(`arrow-nav-btn`, `arrow-nav-btn_bottom`);
        bottomCWCDiv.innerText = `КК ${cTY}`;
    }

    // Создаём ссылку на соседнюю лигу ЕВРОПЫ:
    if ((cTY >= 1956) && (curTourneyName !== `el`)) {
        const bottomELAnchor = document.createElement(`a`);
        bottomDiv.append(bottomELAnchor);
        let eLAbbr = `КЯ`;
        let eLYear = cTY;     
        if (cTY >= 1956 && cTY <= 1958) {
            bottomELAnchor.setAttribute(`href`, `../euroleague/el_1958.html`);
            bottomELAnchor.setAttribute(`title`, `Параллельно идущий кубок ярмарок, 1955/1958`);
            eLYear = 1958;
        }
        else if (cTY === 1959 || cTY === 1960) {
            bottomELAnchor.setAttribute(`href`, `../euroleague/el_1960.html`);
            bottomELAnchor.setAttribute(`title`, `Параллельно идущий кубок ярмарок, 1958/1960`);
            eLYear = 1960;
        }
        else if (cTY <= 1971) {
            bottomELAnchor.setAttribute(`href`, `../euroleague/el_${cTY}.html`);
            bottomELAnchor.setAttribute(`title`, `Кубок ярмарок этого сезона, ${cTY - 1}/${cTY}`);
        }
        else if (cTY <= 2009) {
            bottomELAnchor.setAttribute(`href`, `../euroleague/el_${cTY}.html`);
            bottomELAnchor.setAttribute(`title`, `Кубок УЕФА этого сезона, ${cTY - 1}/${cTY}`);
            eLAbbr = `КУ`;
        }
        else {
            bottomELAnchor.setAttribute(`href`, `../euroleague/el_${cTY}.html`);
            bottomELAnchor.setAttribute(`title`, `Лига Европы этого сезона, ${cTY - 1}/${cTY}`);
            eLAbbr = `ЛЕ`;
        } 
        const bottomELDiv = document.createElement(`div`);
        bottomELAnchor.append(bottomELDiv);
        bottomELDiv.classList.add(`arrow-nav-btn`, `arrow-nav-btn_bottom`);
        bottomELDiv.innerText = `${eLAbbr} ${eLYear}`; 
    }
});