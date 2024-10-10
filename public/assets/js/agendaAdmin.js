import modals from "./modules/modals.js";
import search from "./modules/search.js";


const managerModalFilters = new modals('#modalFilters','#btnOpenModalFilters','#btnCloseModalFilters');
managerModalFilters.init();

const searchElements = new search('.row','#inputSearch');
searchElements.init();