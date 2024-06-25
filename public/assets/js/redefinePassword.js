import viewPassword from "./modules/viewPassword.js"
import modals from "./modules/modals.js"
import validateEqualsPassword from "./modules/validateEqualsPassword.js";

const ViewPassword = new viewPassword();
ViewPassword.init();

const manageModal = new modals("#modalPassword","#btnOpenModalPassword","#btnCloseModalPassword");
manageModal.init();

const validEqualsPassword = new validateEqualsPassword("#formRedefinePassword","#inputPassword","#inputConfirmPassword","#msgPasswordError","#msgConfirmPasswordError");
validEqualsPassword.init();