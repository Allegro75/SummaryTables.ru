
// Для ПОДСВЕЧИВАНИЯ ячеек:

document.addEventListener('DOMContentLoaded', () => {

    const allCurrentRows = document.querySelectorAll(`tr.current`);

    const allLegendStripes = document.querySelectorAll(`.table-explanation__explanation`);

    const highlightRows = (parameter, color) => {
        const rowsToHighlight = document.querySelectorAll(`tr.${parameter}`);
        rowsToHighlight.forEach(item => {item.style.backgroundColor = color;});
    }

    const returnColor = parameter => {
        const rowsToReturn = document.querySelectorAll(`tr.${parameter}`);
        rowsToReturn.forEach(item => {item.style.backgroundColor = ``;});
    }

    allLegendStripes.forEach(item => {
        item.addEventListener('mouseover', () => {
            if ( item.classList.contains(`explanation_russia`) ) {
                item.style.backgroundColor = `#FF9999`;
                highlightRows(`russia`, `#FF9999`);
            } else if ( item.classList.contains(`explanation_ukraine`) ) {
                item.style.backgroundColor = `#66ccff`;
                highlightRows(`ukraine`, `#66ccff`);
            } else if ( item.classList.contains(`explanation_current`) ) {
                item.style.backgroundColor = `#ffffcc`;
                highlightRows(`current`, `#ffffcc`);
            }
        });
        item.addEventListener('mouseout', () => {
            if ( item.classList.contains(`explanation_russia`) ) {
                returnColor(`russia`);
                item.style.backgroundColor = ``;
            } else if ( item.classList.contains(`explanation_ukraine`) ) {
                returnColor(`ukraine`);
                item.style.backgroundColor = ``;
            } else if ( item.classList.contains(`explanation_current`) ) {
                returnColor(`current`);
                item.style.backgroundColor = ``;
            }
        });
    });
}); 