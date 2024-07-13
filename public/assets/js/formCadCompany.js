import viewPassword from "./modules/viewPassword.js"
import steps from "./modules/steps.js"
import maskInput from "./modules/masksInput.js"

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