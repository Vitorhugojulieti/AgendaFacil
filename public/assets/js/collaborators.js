import modals from "./modules/modals.js";
import search from "./modules/search.js";

window.openModalDelete = openModalDelete;

const managerModalDelete = new modals('#modalCollaborators','#btnModalDelete','#btnCloseModalCollaborator');
managerModalDelete.init();

const managerModalFilters = new modals('#modalFilters','#btnOpenModalFilters','#btnCloseModalFilters');
managerModalFilters.init();

function openModalDelete(id,name){
    let btnDelete = document.querySelector('#btnDelete');
    btnDelete.href = '/admin/collaborator/destroy/'+id;
    managerModalDelete.setMessage("Deseja excluir o colaborador: "+name+" ?",'#messageDelete');
    managerModalDelete.openModal();
    console.log(id,name);
}

const searchElements = new search('tr','#inputSearch');
searchElements.init();