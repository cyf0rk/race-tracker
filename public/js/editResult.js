const resultId = document.getElementById('result-id');
const editButtons = document.querySelectorAll('.result-edit-button');

editButtons.forEach(button => {
    button.addEventListener('click', () => {
        resultId.value = button.value;
    });
})