import formValidate from "./formValidate.js";

export default class validateSimpleForm{
    constructor(form,inputEmail,inputPassword,spanErrorEmail,spanErrorPassword){
        this.form = document.querySelector(form);
        // inputs
        this.inputEmail = document.querySelector(inputEmail);
        this.inputPassword = document.querySelector(inputPassword);
        // spans error
        this.spanErrorEmail = document.querySelector(spanErrorEmail);
        this.spanErrorPassword = document.querySelector(spanErrorPassword);
         // icon error
        this.iconError = "<i class='bx bxs-info-circle' style='color:#fd837c'  ></i>";
    }

    isAllFieldsValid(){
        const formValidator = new formValidate();
        this.cleanAllSpans();
        let formValid = true; 

        if(formValidator.isEmpty(this.inputEmail.value)){
            this.spanErrorEmail.innerHTML = this.iconError+"O campo email está vazio!";
            formValid = false;
        }

        if(formValidator.isEmpty(this.inputPassword.value)){
            this.spanErrorPassword.innerHTML = this.iconError+"O campo senha está vazio!";
            formValid = false;
        }

        return formValid;
    }

    cleanAllSpans(){
        this.spanErrorEmail.innerHTML = "";
        this.spanErrorPassword.innerHTML = "";
    }

    sendForm(){
        this.form.addEventListener('submit',(e)=>{
            if(this.isAllFieldsValid()){
                e.target.submit();
            }
            e.preventDefault();
        })
    }

    init(){
        this.sendForm();
    }
}