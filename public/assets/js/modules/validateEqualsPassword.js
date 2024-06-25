import formValidate from "./formValidate.js"

export default class validateEqualsPassword{
    constructor(form,password,confirmPassword,spanPassword,spanConfirmPassword){
        this.form = document.querySelector(form);
        this.password = document.querySelector(password);
        this.confirmPassword = document.querySelector(confirmPassword);
        this.spanPassword = document.querySelector(spanPassword);
        this.spanConfirmPassword = document.querySelector(spanConfirmPassword);
        this.iconError = "<i class='bx bxs-info-circle' style='color:#fd837c'  ></i>";

    }

    isAllFieldsValid(){
        const formValidator = new formValidate();
        this.cleanAllSpans();
        let formValid = true;

        if(!formValidator.isEqualValues(this.password.value,this.confirmPassword.value)){
            this.spanConfirmPassword.innerHTML = this.iconError+"Senhas não são iguais!";
            formValid = false;
        }

        if(formValidator.isEmpty(this.password.value)){
            this.spanPassword.innerHTML = this.iconError+"Campo senha está vazio!";
            formValid = false;
        }
        if(formValidator.isEmpty(this.confirmPassword.value)){
            this.spanConfirmPassword.innerHTML = this.iconError+"Campo confirmar senha está vazio!";
            formValid = false;
        }

        return formValid;
    }


    cleanAllSpans(){
        this.spanPassword.innerHTML = "";
        this.spanConfirmPassword.innerHTML = "";
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