document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        locale: 'pt-br',
        navLinks: true, 

        selectable: false,

        selectMirror: true,

        editable: true,

        dayMaxEvents: true, 

        datesSet: function(info) {
       
            var start = info.startStr; // Data de início
            var end = info.endStr;     // Data de fim

            fetch(`http://localhost:8889/schedule/getSchedules/?start=${start}&end=${end}`)
                .then(response => response.json())
                .then(events => {
                    calendar.removeAllEvents();   
                    calendar.addEventSource(events); 
                })
                .catch(error => console.error('Erro ao carregar eventos:', error));
        },

        eventClick: function(info) {
            var eventId = info.event.id; 
            
            window.location.href = 'http://localhost:8889/schedule/show/' + eventId; 
        }
    });

    calendar.render();
});