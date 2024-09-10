import viewPassword from "./modules/viewPassword.js"
import steps from "./modules/steps.js"
import maskInput from "./modules/masksInput.js"
import CepSearch from "./CepSearch.js"
import modals from "./modules/modals.js";
import previewImage from "./modules/previewImage.js";
import activeLoader from "./modules/activeLoader.js";

const ViewPassword = new viewPassword();
ViewPassword.init();

const stepsForm = new steps('#btnNext','#btnPrevious',['#containerDataCompany','#containerDataCompany2','#containerDataAdmin','#containerDataImage'],'#counterStatusForm','.bullet','#controls','#sendButton');
stepsForm.init();

const formatInputs = new maskInput("#inputPhone","#inputCpf");
formatInputs.init();

const formatInputs2 = new maskInput("#inputPhoneCompany",null,"#inputCep");
formatInputs2.init();

const inputConfirmPassword = document.querySelector("#inputConfirmPassword");
inputConfirmPassword.addEventListener('paste', function(event) {
    event.preventDefault(); 
});


document.addEventListener('DOMContentLoaded', () => {
    const cepSearch = new CepSearch();

    cepSearch.cep.addEventListener('blur', () => {
        cepSearch.fetchAddress();
    });
});

const manageModalCep = new modals('#modalCep','#btnOpenModalCep','#btnCloseModalCep');
manageModalCep.init();

const previewAvatar = new previewImage('#previewAvatar','#inputAvatar','#iconAvatar','#spanAvatar','#msgInputAvatar');
previewAvatar.init();

const previewLogo = new previewImage('#previewLogo','#inputLogo','#iconLogo','#spanLogo','#msgInputLogo');
previewLogo.init();

const previewImageCompany = new previewImage('#previewImage','#inputImage','#iconImage','#spanImage','#msgInputImage');
previewImageCompany.init();

const form = document.querySelector('#formCadCompany');
const loader = new activeLoader();
form.addEventListener('submit',()=>{
    loader.setEnabled();
});

form.addEventListener('keypress',(e)=>{
    if (e.key === 'Enter') {
        e.preventDefault(); 
    }
});