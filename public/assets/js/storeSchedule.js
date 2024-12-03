import modals from "./modules/modals.js";
import generateTimes from "../js/modules/generateTimes.js";


const manageModalServices = new modals('#modalServices','#btnOpenModalServices','#btnCloseModalServices');
manageModalServices.init();

const manageModalCancel = new modals('#modalCancel','#btnOpenModalCancel','#btnCloseModalCancel');
manageModalCancel.init();

function selectCollaborator(serviceIndex, collaboratorId){
    let servicesDiv = document.querySelectorAll(`.collaborator-selection[data-service-index='${serviceIndex}']`);
    servicesDiv.forEach((div)=>{
        let label = div.querySelector('.labelCollaborator');
        label.classList.remove('collaborator-selected'); 

        const selectedLabel = div.querySelector(`label[for='collaborator${collaboratorId}']`);
        if(selectedLabel != null){
            selectedLabel.querySelector('input').checked = true;
            selectedLabel.classList.add('collaborator-selected');
        }
    })
}

window.selectCollaborator = selectCollaborator;


document.addEventListener('DOMContentLoaded', function() {

    const calendarEl = document.getElementById('calendar');
    const inputDate = document.querySelector('#inputDate');
    let selectedDateEl = null;

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
            selectDate(selectedDate);
        }
    });

    function selectDate(date) {
        // Formata a data
        let year = date.getFullYear();
        let month = String(date.getMonth() + 1).padStart(2, '0');
        let day = String(date.getDate()).padStart(2, '0');
        let formattedDate = `${year}-${month}-${day}`;

        // Remove o destaque da data anterior
        if (selectedDateEl) {
            selectedDateEl.classList.remove('fc-daygrid-day');
            selectedDateEl.classList.remove('fc-day-today');
        }

        // Encontra o elemento correspondente à nova data no calendário
        const newSelectedDateEl = calendarEl.querySelector(
            `[data-date="${formattedDate}"]`
        );

        if (newSelectedDateEl) {
            newSelectedDateEl.classList.add('fc-daygrid-day');
            newSelectedDateEl.classList.add('fc-day-today');
            selectedDateEl = newSelectedDateEl; // Atualiza a variável de rastreamento
        }

    }

    calendar.render();
});
