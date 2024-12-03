import menuTab from "./modules/menuTab.js";
import modals from "./modules/modals.js";
import search from "./modules/search.js";
import share from "./modules/share.js";

const modalShareManager = new modals();
const shareButton = new share('#btnShare',modalShareManager);
window.setShareData = function(title, text, url) {
    shareButton.setShareData(title, text, url);
    shareButton.init();
};

const menuTabManager = new menuTab('#menuTab',['#services','#galery','#details']);
menuTabManager.init();

const searchServices = new search('.service','#inputSearchService');
searchServices.init();

