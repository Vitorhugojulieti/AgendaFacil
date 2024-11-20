import search from "./modules/search.js";
import modals from "./modules/modals.js";

const searchElements = new search('.row','#inputSearch');
searchElements.init();

window.openModalDelete = openModalDelete;

const managerModalDelete = new modals('#modalDelete','#btnModalDelete','#btnCloseModalDelete');
managerModalDelete.init();

const managerModalFilters = new modals('#modalFilters','#btnOpenModalFilters','#btnCloseModalFilters');
managerModalFilters.init();

function openModalDelete(id,name){
    let btnDelete = document.querySelector('#btnDelete');
    btnDelete.href = '/admin/voucher/destroy/'+id;
    managerModalDelete.setMessage("Deseja inativar o voucher: "+name+" ?",'#messageDelete');
    managerModalDelete.openModal();
    console.log(id,name);
}

const spanCountFilters = document.querySelector('#iconFilter')
const spanRangePrice = document.querySelector('#viewRangePrice');

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
const inputAllStatus = containerStatus.querySelector('#radioAll');

btnResetFilter.addEventListener('click',()=>{
    spanRangePrice.innerHTML = '';
    inputRangePrice.value = 0;
    inputAllStatus.checked = true;
    changeLabelSelected();
});


btnFilter.addEventListener('click',()=>{
    let url = `/admin/voucher/`;

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

    if (!urlParams.has('price') && !urlParams.has('status')) {
        inputRangePrice.value = 0;
        inputAllStatus.checked = true;
        changeLabelSelected();
    }else{
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

    if (urlParams.has('price') && urlParams.has('status')) {
        spanCountFilters.innerHTML = 2;
        spanCountFilters.classList.remove('hidden');
        spanCountFilters.classList.add('flex');
    }else if(urlParams.has('price') || urlParams.has('status')){
        spanCountFilters.innerHTML = 1;
        spanCountFilters.classList.remove('hidden');
        spanCountFilters.classList.add('flex');
    }
    
}

initializeModalFiltersApplied()