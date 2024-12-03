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
    let url = `/schedule/`;
    
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

const searchElements = new search('.row','#inputSearch');
searchElements.init();