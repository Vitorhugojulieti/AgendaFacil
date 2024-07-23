import viewPassword from "./modules/viewPassword.js"
import maskInput from "./modules/masksInput.js"
import modals from "./modules/modals.js";
import previewImage from "./modules/previewImage.js";
import validateFormCadClient from "./modules/validateFormCadClient.js";

const validateFormClient  = new validateFormCadClient('#formCadCollaborator');
validateFormClient.init();

const ViewPassword = new viewPassword();
ViewPassword.init();

const formatInputs = new maskInput("#inputPhone","#inputCpf");
formatInputs.init();

const inputConfirmPassword = document.querySelector("#inputConfirmPassword");
inputConfirmPassword.addEventListener('paste', function(event) {
    event.preventDefault(); 
});


// const manageModalCep = new modals('#modalCep','#btnOpenModalCep','#btnCloseModalCep');
// manageModalCep.init();

const previewAvatar = new previewImage('#previewAvatar','#inputAvatar');
previewAvatar.init();


