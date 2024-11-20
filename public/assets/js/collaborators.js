import modals from "./modules/modals.js";
import search from "./modules/search.js";

window.openModalDelete = openModalDelete;

const managerModalDelete = new modals('#modalCollaborators','#btnModalDelete','#btnCloseModalCollaborator');
managerModalDelete.init();

const managerModalFilters = new modals('#modalFilters','#btnOpenModalFilters','#btnCloseModalFilters');
managerModalFilters.init();

const searchElements = new search('.row','#inputSearch');
searchElements.init();

function openModalDelete(id,name,used){
    let btnDelete = document.querySelector('#btnDelete');
    btnDelete.href = '/admin/collaborator/destroy/'+id+'/'+used;;
    if(used){
        managerModalDelete.setMessage("Deseja inativar o colaborador: "+name+" ?",'#messageDelete');
        managerModalDelete.setTextButtonDelete("Inativar");
    }else{
        managerModalDelete.setMessage("Deseja excluir o colaborador: "+name+" ?",'#messageDelete');
        managerModalDelete.setTextButtonDelete("Excluir");
    }
    managerModalDelete.openModal();
}

const spanCountFilters = document.querySelector('#iconFilter')


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

const containerNivel = document.querySelector('#containerNivel');
const labelsNivel = containerNivel.querySelectorAll('label');

containerNivel.addEventListener('change', function(event) {
    if (event.target.name === 'nivel') {
        labelsNivel.forEach(label => label.classList.add('bg-principal5'));
        labelsNivel.forEach(label => label.classList.remove('bg-principal10'));
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

    labelsNivel.forEach(label => label.classList.add('bg-principal5'));
    labelsNivel.forEach(label => label.classList.remove('bg-principal10'));

    const selectedOptionNivel = document.querySelector('input[name="nivel"]:checked');
    selectedOptionNivel.parentElement.classList.remove('bg-principal5');
    selectedOptionNivel.parentElement.classList.add('bg-principal10');
}


const btnResetFilter = document.querySelector('#btnReset');
const btnFilter = document.querySelector('#btnFilter');
const inputAllStatus = containerStatus.querySelector('#radioAll');
const inputAllNivel = containerNivel.querySelector('#radioAllNivel');

btnResetFilter.addEventListener('click',()=>{
    inputAllStatus.checked = true;
    inputAllNivel.checked = true;
    changeLabelSelected();
});


btnFilter.addEventListener('click',()=>{
    let url = `/admin/collaborator/`;
    
    const selectedOptionStatus = document.querySelector('input[name="status"]:checked');
    if(!selectedOptionStatus.value == ""){
        url.split('?').length - 1 == 0 ? url += `?status=${selectedOptionStatus.value}` : url += `&status=${selectedOptionStatus.value}`;
    }

    const selectedOptionNivel = document.querySelector('input[name="nivel"]:checked');
    if(!selectedOptionNivel.value == ""){
        url.split('?').length - 1 == 0 ? url += `?nivel=${selectedOptionNivel.value}` : url += `&nivel=${selectedOptionNivel.value}`;
    }

    window.location.href = url;
});

function initializeModalFiltersApplied(){
    const urlParams = new URLSearchParams(window.location.search);

    if (!urlParams.has('nivel') && !urlParams.has('status')) {
        inputAllStatus.checked = true;
        inputAllNivel.checked = true;
        changeLabelSelected();
    }else{
        const status = urlParams.get('status');
        labelsStatus.forEach(label =>{
            if(status == label.querySelector('input').value){
                label.querySelector('input').checked = true;
                changeLabelSelected();
            }
        })

        const nivel = urlParams.get('nivel');
        labelsNivel.forEach(label =>{
            if(nivel == label.querySelector('input').value){
                label.querySelector('input').checked = true;
                changeLabelSelected();
            }
        })
    }

    if (urlParams.has('nivel') && urlParams.has('status')) {
        spanCountFilters.innerHTML = 2;
        spanCountFilters.classList.remove('hidden');
        spanCountFilters.classList.add('flex');
    }else if(urlParams.has('nivel') || urlParams.has('status')){
        spanCountFilters.innerHTML = 1;
        spanCountFilters.classList.remove('hidden');
        spanCountFilters.classList.add('flex');
    }

    
}

initializeModalFiltersApplied()