import validateFinishRegistration from "./modules/validateFinishRegistration.js";
import viewPassword from "./modules/viewPassword.js"
import modals from "./modules/modals.js";
import maskInput from "./modules/masksInput.js"


const formatInputs = new maskInput("#inputPhone","#inputCpf");
formatInputs.init();

const validateRegistration = new validateFinishRegistration();
validateRegistration.init();

const ViewPassword = new viewPassword();
ViewPassword.init();

const manageModalPassword = new modals('#modalPassword','#btnOpenModalPassword','#btnCloseModalPassword');
manageModalPassword.init();