import search from "./modules/search.js";
import modals from "./modules/modals.js";

window.openModalDelete = openModalDelete;


const searchElements = new search('.row','#inputSearch');
searchElements.init();

const managerModalDelete = new modals('#modalDelete','#btnModalDelete','#btnCloseModalDelete');
managerModalDelete.init();

const modalFilterManager = new modals('#modalFilter','#btnOpenModalFilter','#btnCloseModalFilter');
modalFilterManager.init();

function openModalDelete(id,name){
    let btnDelete = document.querySelector('#btnDelete');
    btnDelete.href = '/admin/voucher/destroy/'+id;
    managerModalDelete.setMessage("Deseja inativar o voucher: "+name+" ?",'#messageDelete');
    managerModalDelete.openModal();
    console.log(id,name);
}

