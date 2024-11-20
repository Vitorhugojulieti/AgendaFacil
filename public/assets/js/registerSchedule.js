import calendar from "./modules/calendar.js";
import modals from "./modules/modals.js";
import searchClient from "./modules/searchClient.js";
import generateTimes from "../js/modules/generateTimes.js";

const manageModalServices = new modals('#modalServices','#btnOpenModalServices','#btnCloseModalServices');
manageModalServices.init();

const manageModalCancel = new modals('#modalCancel','#btnOpenModalCancel','#btnCloseModalCancel');
manageModalCancel.init();

const searchClientManager = new searchClient('#inputSearchClient','#listClients');
searchClientManager.init();

const manageModalSearchClient = new modals('#modalSearchClient','#btnOpenModalSearchClient','#btnCloseModalSearchClient');
manageModalSearchClient.init();

document.addEventListener('change', function(event) {
    if (event.target.name === 'collaborators[]') {
        const collaborators = document.querySelectorAll('.collaborator');
        collaborators.forEach((collaborator) =>{
            collaborator.classList.remove('collaborator-selected');
            collaborator.parentElement.querySelector('span').classList.remove('font-semibold');
        });
        let label = event.target.parentElement;
        label.querySelector('img').classList.add('collaborator-selected');
        label.querySelector('.name').classList.add('font-semibold');
    }
});


document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    const inputDate = document.querySelector('#inputDate');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        locale: 'pt-br',
        selectable: true,
        editable: false,
        dayMaxEvents: true,

        datesSet: function() {
            // let initialDate = new Date();
            // let year = initialDate.getFullYear();
            // let month = String(initialDate.getMonth() + 1).padStart(2, '0'); 
            // let day = String(initialDate.getDate()).padStart(2, '0');
            // let formattedDate = `${year}-${month}-${day}`;

            // const timesGenerator = new generateTimes('admin');
            // timesGenerator.setDate(formattedDate);
            // timesGenerator.generateTimesElements();
            // timesGenerator.init();
            // inputDate.value = formattedDate;
        },

        // Habilita a seleção de data
        dateClick: function(info) {
            let selectedDate = info.date;
            let year = selectedDate.getFullYear();
            let month = String(selectedDate.getMonth() + 1).padStart(2, '0'); 
            let day = String(selectedDate.getDate()).padStart(2, '0');
            let formattedDate = `${year}-${month}-${day}`;

            const timesGenerator = new generateTimes('admin');
            timesGenerator.setDate(formattedDate);
            timesGenerator.generateTimesElements();
            timesGenerator.init();
            inputDate.value = formattedDate;
        }
    });

    calendar.render();
    // document.addEventListener('click',()=>{
    //     calendar.gotoDate(inputDate.value);
    // })
});

const listClients = document.querySelector('#listClients');
const inputSearchClient = document.querySelector('#inputSearchClient');
inputSearchClient.addEventListener('click',(e)=>{
    listClients.classList.remove('hidden');
    listClients.classList.add('flex');
});

// inputSearchClient.addEventListener('focusout',(e)=>{
//     listClients.classList.remove('flex');
//     listClients.classList.add('hidden');
// });

// document.addEventListener('click',(e)=>{
//     if (e.target.id != "listClients") {
//         listClients.classList.remove('flex');
//         listClients.classList.add('hidden');
//     }
// })


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