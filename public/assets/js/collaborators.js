import modals from "./modules/modals.js";
import search from "./modules/search.js";

window.openModalDelete = openModalDelete;

const managerModalDelete = new modals('#modalCollaborators','#btnModalDelete','#btnCloseModalCollaborator');
managerModalDelete.init();

const managerModalFilters = new modals('#modalFilters','#btnOpenModalFilters','#btnCloseModalFilters');
managerModalFilters.init();

const managerModalCollaborator = new modals('#modalCollaborator','#btnOpenModalCollaborator','#btnCloseModalCollaborators');
managerModalCollaborator.init();


function openModalDelete(id,name){
    let btnDelete = document.querySelector('#btnDelete');
    btnDelete.href = '/admin/collaborator/destroy/'+id;
    managerModalDelete.setMessage("Deseja inativar o colaborador: "+name+" ?",'#messageDelete');
    managerModalDelete.openModal();
    console.log(id,name);
}

const searchElements = new search('.row','#inputSearch');
searchElements.init();