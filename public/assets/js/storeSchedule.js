import calendar from "./modules/calendar.js";
import modals from "./modules/modals.js";

const manageModalPassword = new modals('#modalServices','#btnOpenModalServices','#btnCloseModalServices');
manageModalPassword.init();

const calendarSchedule = new calendar('#containerCalendar');
calendarSchedule.init();

document.addEventListener('change', function(event) {
    if (event.target.name === 'collaborators[]') {
        const collaborators = document.querySelectorAll('.collaborator');
        collaborators.forEach(collaborator => collaborator.classList.remove('collaborator-selected'));
        let label = event.target.parentElement;
        label.querySelector('img').classList.add('collaborator-selected');
    }
});

var socket = io('http://localhost:3000');
    socket.on('connect', function() {
      console.log('Conectado ao servidor WebSocket');
      socket.send('Olá, servidor!');
    });
    socket.on('response', function(data) {
      console.log('Resposta do servidor:', data);
    });