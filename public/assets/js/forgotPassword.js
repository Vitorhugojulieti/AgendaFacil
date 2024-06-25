import formValidate from "./modules/formValidate.js";

const form = document.querySelector("#formForgotPassword");
const inputEmail = document.querySelector("#inputEmail");
const spanEmail = document.querySelector("#msgEmailError");
const iconError = "<i class='bx bxs-info-circle' style='color:#fd837c'  ></i>";
const formValidator = new formValidate();

form.addEventListener('submit',(e)=>{
    spanEmail.innerHTML = "";

    if(formValidator.isEmpty(inputEmail.value)){
        spanEmail.innerHTML = iconError+"Campo email está vazio!";
        e.preventDefault();
    }else if(!formValidator.isEmailValid(inputEmail.value)){
        spanEmail.innerHTML = iconError+"Email invalido!";
        e.preventDefault();
    }else{
        e.target.submit();
    }
})