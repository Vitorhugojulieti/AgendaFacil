import acordions from "./modules/acordions.js";
import calendar from "./modules/calendar.js";
import modals from "./modules/modals.js";

const manageModalPassword = new modals('#modalServices','#btnOpenModalServices','#btnCloseModalServices');
manageModalPassword.init();

const calendarSchedule = new calendar('#containerCalendar');
calendarSchedule.init();

// const collaboratorsHtml = document.querySelectorAll('.labelCollaborator');
// collaboratorsHtml[0].querySelector('img').classList.add('collaborator-selected');
// collaboratorsHtml[0].querySelector('input').checked = true;

document.addEventListener('change', function(event) {
    if (event.target.name === 'collaborators[]') {
        const collaborators = document.querySelectorAll('.collaborator');
        collaborators.forEach(collaborator => collaborator.classList.remove('collaborator-selected'));
        let label = event.target.parentElement;
        label.querySelector('img').classList.add('collaborator-selected');
    }
});

// const acordionsManager = new acordions(['#sectionServices','#sectionData']);
// acordionsManager.init();


document.querySelector('#services').addEventListener('click',(e)=>{
    e.stopPropagation();
})  