import modals from "./modules/modals.js";


const manageModalCancel = new modals('#modalCancel','#btnOpenModalCancel','#btnCloseModalCancel');
manageModalCancel.init();

const manageModalComplete = new modals('#modalComplete','#btnOpenModalComplete','#btnCloseModalComplete');
manageModalComplete.init();

const containerReasons = document.querySelector('#containerRadiosReason');

containerReasons.addEventListener('change', function(event) {
    if (event.target.name === 'reason') {
        const labels = containerReasons.querySelectorAll('label');
        console.log(labels);
        labels.forEach((label) =>{
            label.classList.remove('optReason-selected');
        });
        event.target.parentElement.classList.add('optReason-selected');
    }
});