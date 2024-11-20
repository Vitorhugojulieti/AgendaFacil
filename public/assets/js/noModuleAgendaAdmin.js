// document.addEventListener('DOMContentLoaded', function() {
//     if (!window.FullCalendar || !FullCalendar.Calendar) {
//       console.error("FullCalendar não foi carregado corretamente.");
//       return;
//     }
  
//     const calendarEl = document.getElementById('calendar');
//     if (!calendarEl) {
//       console.error("Elemento do calendário não encontrado.");
//       return;
//     }
  
//     const calendar = new FullCalendar.Calendar(calendarEl, {
//       plugins: [ FullCalendar.dayGridPlugin ],
//       initialView: 'dayGridMonth',
//       eventClick: function(info) {
//         info.jsEvent.preventDefault();
//         if (info.event.url) {
//           window.open(info.event.url, '_blank');
//         }
//       }
//     });
  
//     calendar.render();
//   });
  

// Executar quando o documento HTML for completamente carregado
document.addEventListener('DOMContentLoaded', function() {

    // Receber o SELETOR calendar do atributo id
    var calendarEl = document.getElementById('calendar');

    // Instanciar FullCalendar.Calendar e atribuir a variável calendar
    var calendar = new FullCalendar.Calendar(calendarEl, {
        // Criar o cabeçalho do calendário
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        // Definir o idioma usado no calendário
        locale: 'pt-br',

        // Definir a data inicial
        //initialDate: '2023-01-12',
        //initialDate: '2023-10-12',

        // Permitir clicar nos nomes dos dias da semana 
        navLinks: true, 

        // Permitir clicar e arrastar o mouse sobre um ou vários dias no calendário
        selectable: false,

        // Indicar visualmente a área que será selecionada antes que o usuário solte o botão do mouse para confirmar a seleção
        selectMirror: true,

        // Permitir arrastar e redimensionar os eventos diretamente no calendário.
        editable: true,

        // Número máximo de eventos em um determinado dia, se for true, o número de eventos será limitado à altura da célula do dia
        dayMaxEvents: true, 

        // events: 'http://localhost/admin/schedule/getSchedules' 
        datesSet: function(info) {
       
            // Obtém as datas de início e fim da visualização atual
            var start = info.startStr; // Data de início
            var end = info.endStr;     // Data de fim

            // Fazer uma requisição AJAX para buscar eventos dentro desse intervalo
            fetch(`http://localhost:8889/admin/schedule/getSchedules/?start=${start}&end=${end}`)
                .then(response => response.json())
                .then(events => {
                    calendar.removeAllEvents();   // Remove eventos anteriores
                    calendar.addEventSource(events); // Adiciona os novos eventos
                })
                .catch(error => console.error('Erro ao carregar eventos:', error));
        },

        eventClick: function(info) {
            var eventId = info.event.id; // Supondo que você tenha um campo 'id' em seus eventos
            
            window.location.href = 'http://localhost:8889/admin/schedule/show/' + eventId; 
        }
    });

    calendar.render();
});