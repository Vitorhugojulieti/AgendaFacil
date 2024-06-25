import validateFormLogin from "./modules/validateFormLogin.js";
import viewPassword from "./modules/viewPassword.js"

const ViewPassword = new viewPassword();
ViewPassword.init();

const validatorFormLogin = new validateFormLogin('#formloginClient','#inputEmail','#inputPassword','#msgEmailError','#msgPasswordError');
validatorFormLogin.init();