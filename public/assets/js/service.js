import modals from "./modules/modals.js";
import search from "./modules/search.js";

window.openModalDelete = openModalDelete;

const managerModalDelete = new modals('#modalService','#btnModalDelete','#btnCloseModalService');
managerModalDelete.init();

const managerModalFilters = new modals('#modalFilters','#btnOpenModalFilters','#btnCloseModalFilters');
managerModalFilters.init();

function openModalDelete(id,name,used){
    let btnDelete = document.querySelector('#btnDelete');
    btnDelete.href = '/admin/service/destroy/'+id+'/'+used;
    console.log(used)
    if(used){
        managerModalDelete.setMessage("Deseja inativar o serviço: "+name+" ?",'#messageDelete');
        managerModalDelete.setTextButtonDelete("Inativar");
    }else{
        managerModalDelete.setMessage("Deseja excluir o serviço: "+name+" ?",'#messageDelete');
        managerModalDelete.setTextButtonDelete("Excluir");
    }
    managerModalDelete.openModal();
}

const searchElements = new search('.row','#inputSearch');
searchElements.init();

const spanCountFilters = document.querySelector('#iconFilter');

const inputRangeDuration = document.querySelector('#inputRangeDuration');
const spanRangeDuration = document.querySelector('#viewRangeDuration');
const inputRangePrice = document.querySelector('#inputRangePrice');
const spanRangePrice = document.querySelector('#viewRangePrice');

inputRangeDuration.addEventListener('change',()=>{
    if(inputRangeDuration.value >= 60){
        spanRangeDuration.innerHTML = ((inputRangeDuration.value - 60) /10) == 0 ? '1 Hr' : ((inputRangeDuration.value - 60) /10)+1 +' Hr';
    }else{
        spanRangeDuration.innerHTML = inputRangeDuration.value+' Min';
    }
})

inputRangePrice.addEventListener('change',()=>{
    spanRangePrice.innerHTML = 'Até R$ '+inputRangePrice.value+'.00';
})

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
    spanRangeDuration.innerHTML = '';
    spanRangePrice.innerHTML = '';
    inputRangeDuration.value = 0;
    inputRangePrice.value = 0;
    labelAll.checked = true;
    changeLabelSelected();
  
});


btnFilter.addEventListener('click',()=>{
    let url = `/admin/service/`;
    
    if(inputRangeDuration.value != 0){
        url.split('?').length - 1 == 0 ? url += `?duration=${inputRangeDuration.value}` : url += `&duration=${inputRangeDuration.value}`;
    }

    if(inputRangePrice.value != 0){
        url.split('?').length - 1 == 0 ? url += `?price=${inputRangePrice.value}` : url += `&price=${inputRangePrice.value}`;
    }

    const selectedOptionStatus = document.querySelector('input[name="status"]:checked');
    if(!selectedOptionStatus.value == ""){
        url.split('?').length - 1 == 0 ? url += `?status=${selectedOptionStatus.value}` : url += `&status=${selectedOptionStatus.value}`;
    }

    window.location.href = url;
});

function initializeModalFiltersApplied(){
    const urlParams = new URLSearchParams(window.location.search);

    if (!urlParams.has('duration') && !urlParams.has('price') && !urlParams.has('status')) {
        inputRangeDuration.value = 0;
        inputRangePrice.value = 0;
        labelAll.checked = true;
        changeLabelSelected();
    }else{
        inputRangeDuration.value = urlParams.get('duration');
        if(inputRangeDuration.value >= 60){
            spanRangeDuration.innerHTML = ((inputRangeDuration.value - 60) /10) == 0 ? '1 Hr' : ((inputRangeDuration.value - 60) /10)+1 +' Hr';
        }else{
            spanRangeDuration.innerHTML = inputRangeDuration.value+' Min';
        }
    
        inputRangePrice.value = urlParams.get('price');
        spanRangePrice.innerHTML = 'Até R$ '+inputRangePrice.value+'.00';
    
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