const raceName = document.querySelector('#race-name');
const raceNameLabel = document.querySelector('.race-name-label');

function validateInput() {
    const alphaNumericValidation = new RegExp(/^[a-zA-Z0-9 ]*$/);
    raceName.value.trimStart();

    if (alphaNumericValidation.test(raceName.value) === false) {
        raceName.style.borderColor = 'hsl(0, 95%, 55%)';
        raceNameLabel.classList.add('invalid-field');
        return false;
    } else {
        raceName.style.borderColor = 'hsl(0, 0%, 0%)';
        raceNameLabel.classList.remove('invalid-field');
        raceNameLabel.classList.remove('empty-field');
        return true;
    }
}