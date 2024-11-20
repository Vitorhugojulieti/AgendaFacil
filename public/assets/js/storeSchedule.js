import modals from "./modules/modals.js";
import generateTimes from "../js/modules/generateTimes.js";


const manageModalServices = new modals('#modalServices','#btnOpenModalServices','#btnCloseModalServices');
manageModalServices.init();

const manageModalCancel = new modals('#modalCancel','#btnOpenModalCancel','#btnCloseModalCancel');
manageModalCancel.init();

function selectCollaborator(serviceIndex, collaboratorId){
    let serviceDiv = document.querySelector(`.collaborator-selection[data-service-index='${serviceIndex}']`);
    console.log(collaboratorId);
    console.log(serviceIndex);
    console.log(serviceDiv);
        
    serviceDiv.querySelectorAll('.labelCollaborator').forEach((label) => {
        label.classList.remove('collaborator-selected'); 
    });
    
    const selectedLabel = serviceDiv.querySelector(`label[for='collaborator${collaboratorId}']`);
    console.log(selectedLabel);
    selectedLabel.classList.add('collaborator-selected');
    
    selectedLabel.querySelector('input').checked = true;
}

window.selectCollaborator = selectCollaborator;


document.addEventListener('DOMContentLoaded', function() {

    const calendarEl = document.getElementById('calendar');
    const inputDate = document.querySelector('#inputDate');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next',   // Mostra apenas as setas de navegação para os meses
            center: 'title',     // Mostra o título do mês atual no centro
            right: ''            // Deixa a parte direita vazia
        },
        locale: 'pt-br',
        selectable: true,
        editable: false,
        dayMaxEvents: true,

         // Quando o calendário é carregado ou a navegação é feita
         datesSet: function() {
            let initialDate = new Date();
            let year = initialDate.getFullYear();
            let month = String(initialDate.getMonth() + 1).padStart(2, '0'); 
            let day = String(initialDate.getDate()).padStart(2, '0');
            let formattedDate = `${year}-${month}-${day}`;

            const timesGenerator = new generateTimes();
            timesGenerator.setDate(formattedDate);
            timesGenerator.generateTimesElements();
            timesGenerator.init();
            inputDate.value = formattedDate;
        },

        // Habilita a seleção de data
        dateClick: function(info) {
            let selectedDate = info.date;
            let year = selectedDate.getFullYear();
            let month = String(selectedDate.getMonth() + 1).padStart(2, '0'); 
            let day = String(selectedDate.getDate()).padStart(2, '0');
            let formattedDate = `${year}-${month}-${day}`;
            const timesGenerator = new generateTimes();
            timesGenerator.setDate(formattedDate);
            timesGenerator.generateTimesElements();
            timesGenerator.init();
            inputDate.value = formattedDate;
        }
    });

    calendar.render();
});
