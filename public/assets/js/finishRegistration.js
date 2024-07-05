import validateFinishRegistration from "./modules/validateFinishRegistration.js";
import viewPassword from "./modules/viewPassword.js"
import modals from "./modules/modals.js";

const validateRegistration = new validateFinishRegistration();
validateRegistration.init();

const ViewPassword = new viewPassword();
ViewPassword.init();

const manageModalPassword = new modals('#modalPassword','#btnOpenModalPassword','#btnCloseModalPassword');
manageModalPassword.init();