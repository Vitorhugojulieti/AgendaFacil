import modals from "./modules/modals.js";
import search from "./modules/search.js";


const managerModalFilters = new modals('#modalFilters','#btnOpenModalFilters','#btnCloseModalFilters');
managerModalFilters.init();




// filtros
const spanCountFilters = document.querySelector('#iconFilter')

const inputStartDate = document.querySelector('#inputStartDate');
const inputEndDate = document.querySelector('#inputEndDate');


const containerStatus = document.querySelector('#containerStatus');
const labelsStatus = containerStatus.querySelectorAll('label');

containerStatus.addEventListener('change', function(event) {
    if (event.target.name === 'status') {
        labelsStatus.forEach(label => label.classList.add('bg-principal5'));
        labelsStatus.forEach(label => label.classList.remove('bg-principal10'));
        event.target.parentElement.classList.remove('bg-principal5');
        event.target.parentElement.classList.add('bg-principal10');
    }
});

function changeLabelSelected(){
    labelsStatus.forEach(label => label.classList.add('bg-principal5'));
    labelsStatus.forEach(label => label.classList.remove('bg-principal10'));
    const selectedOptionStatus = document.querySelector('input[name="status"]:checked');
    selectedOptionStatus.parentElement.classList.remove('bg-principal5');
    selectedOptionStatus.parentElement.classList.add('bg-principal10');
}


const btnResetFilter = document.querySelector('#btnReset');
const btnFilter = document.querySelector('#btnFilter');
const labelAll = document.querySelector('#radioAll');

btnResetFilter.addEventListener('click',()=>{
    inputStartDate.value = '';
    inputEndDate.value = '';
    labelAll.checked = true;
    changeLabelSelected();
});


btnFilter.addEventListener('click',()=>{
    let url = `/admin/schedule/`;
    
    if(inputStartDate.value != ''){
        url.split('?').length - 1 == 0 ? url += `?startDate=${inputStartDate.value}` : url += `&startDate=${inputStartDate.value}`;
    }

    if(inputEndDate.value != ''){
        url.split('?').length - 1 == 0 ? url += `?endDate=${inputEndDate.value}` : url += `&endDate=${inputEndDate.value}`;
    }

    const selectedOptionStatus = document.querySelector('input[name="status"]:checked');
    if(!selectedOptionStatus.value == ""){
        url.split('?').length - 1 == 0 ? url += `?status=${selectedOptionStatus.value}` : url += `&status=${selectedOptionStatus.value}`;
    }

    window.location.href = url;
});

function initializeModalFiltersApplied(){
    const urlParams = new URLSearchParams(window.location.search);

    if (!urlParams.has('startDate') && !urlParams.has('endDate') && !urlParams.has('status')) {
        inputStartDate.value = '';
        inputEndDate.value = '';
        labelAll.checked = true;
        changeLabelSelected();
    }else{
        inputStartDate.value = urlParams.get('startDate');
        inputEndDate.value = urlParams.get('endDate');
    
        const status = urlParams.get('status');
        labelsStatus.forEach(label =>{
            if(status == label.querySelector('input').value){
                label.querySelector('input').checked = true;
                changeLabelSelected();
            }
        })
    }

    console.log(urlParams)
    if(urlParams.size == 1){
        spanCountFilters.innerHTML = 1;
        spanCountFilters.classList.remove('hidden');
        spanCountFilters.classList.add('flex');
    }else if(urlParams.size == 2){
        spanCountFilters.innerHTML = 2;
        spanCountFilters.classList.remove('hidden');
        spanCountFilters.classList.add('flex');
    }else if(urlParams.size == 3){
        spanCountFilters.innerHTML = 3;
        spanCountFilters.classList.remove('hidden');
        spanCountFilters.classList.add('flex');
    }
    

    
}

initializeModalFiltersApplied()


//calendar
document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        },

        locale: 'pt-br',
        navLinks: true, 
        selectable: true,
        selectMirror: true,
        editable: true,
        dayMaxEvents: true, 
        datesSet: function(info) {

            console.log(info);
       
            var start = info.startStr; // Data de início
            var end = info.endStr;     // Data de fim

            fetch(`http://localhost:8889/admin/schedule/getSchedules/?start=${start}&end=${end}`)
                .then(response => response.json())
                .then(events => {
                    calendar.removeAllEvents();   // Remove eventos anteriores
                    calendar.addEventSource(events); // Adiciona os novos eventos
                })
                .catch(error => console.error('Erro ao carregar eventos:', error));
        },

        eventClick: function(info) {
            var eventId = info.event.id;
            window.location.href = 'http://localhost:8889/admin/schedule/show/' + eventId; 
        },
    });
    calendar.render();
});


const searchElements = new search('.row','#inputSearch');
searchElements.init();