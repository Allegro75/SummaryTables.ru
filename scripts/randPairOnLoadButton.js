 
// Для управления localStorage.showRandomWindow:

document.addEventListener('DOMContentLoaded', () => {
    const randomOnLoadBtn = document.getElementById(`random-onload__input`);
    if (localStorage.showRandomWindow === `true`) {
        randomOnLoadBtn.checked = true; 
    }
    randomOnLoadBtn.addEventListener('change', () => {
        if (!localStorage.showRandomWindow) {
            localStorage.showRandomWindow = true;
        } else if (localStorage.showRandomWindow === `true`) {
            localStorage.showRandomWindow = false;
        } else {
            localStorage.showRandomWindow = true;
        }
    });
});