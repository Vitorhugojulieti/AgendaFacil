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


document.getElementById('formCancel').addEventListener('submit', function(e) {
    e.preventDefault();
    const radios = document.querySelectorAll('input[name="reason"]');
    let isChecked = false;

    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
        isChecked = true;
        break;
        }
    }

    if (!isChecked) {
        document.querySelector('#msgFormCancel').innerHTML = 'Selecione pelo menos um motivo para o cancelamento!';
    }else{
        e.target.submit();
    }
});