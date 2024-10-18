import acordions from "./modules/acordions.js";
import calendar from "./modules/calendar.js";
import modals from "./modules/modals.js";

const manageModalServices = new modals('#modalServices','#btnOpenModalServices','#btnCloseModalServices');
manageModalServices.init();

const manageModalCancel = new modals('#modalCancel','#btnOpenModalCancel','#btnCloseModalCancel');
manageModalCancel.init();

const calendarSchedule = new calendar('#containerCalendar');
calendarSchedule.init();


function selectCollaborator(serviceIndex, collaboratorId){
    const serviceDiv = document.querySelector(`.collaborator-selection[data-service-index='${serviceIndex}']`);
    console.log(collaboratorId);
    console.log(serviceIndex);
    console.log(serviceDiv);
        
    serviceDiv.querySelectorAll('.labelCollaborator').forEach((label) => {
        label.classList.remove('collaborator-selected'); 
    });
    
    const selectedLabel = document.querySelector(`label[for='collaborator${collaboratorId}']`);
    selectedLabel.classList.add('collaborator-selected');
    
    selectedLabel.querySelector('input').checked = true;
}

window.selectCollaborator = selectCollaborator;
