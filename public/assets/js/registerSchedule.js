import calendar from "./modules/calendar.js";
import modals from "./modules/modals.js";


const calendarSchedule = new calendar('#containerCalendar');
// calendarSchedule.init();


const manageModalSearchClient = new modals('#modalSearchClient','#btnOpenModalSearchClient','#btnCloseModalSearchClient');
manageModalSearchClient.init();

document.addEventListener('change', function(event) {
    if (event.target.name === 'method') {
        const labelsMethods = document.querySelectorAll('.method');
        labelsMethods.forEach(label => label.classList.remove('selected'));
        let labelSelected = event.target.parentElement;
        labelSelected.classList.add('selected');
    }
});

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
