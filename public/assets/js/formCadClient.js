import maskInput from "./modules/masksInput.js";
import modals from "./modules/modals.js";
import validateFormCadClient from "./modules/validateFormCadClient.js";
import viewPassword from "./modules/viewPassword.js"

const ViewPassword = new viewPassword();
ViewPassword.init();

const validateFormClient  = new validateFormCadClient();
validateFormClient.init();

const manageModalPassword = new modals('#modalPassword','#btnOpenModalPassword','#btnCloseModalPassword');
manageModalPassword.init();

const formatInputs = new maskInput("#inputPhone","#inputCpf");
formatInputs.init();

const inputConfirmPassword = document.querySelector("#inputConfirmPassword");
inputConfirmPassword.addEventListener('paste', function(event) {
    event.preventDefault(); 
});

