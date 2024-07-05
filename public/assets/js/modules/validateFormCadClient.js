import formValidate from "./formValidate.js"

export default class validateFormCadClient{
    constructor(){
        this.form = document.querySelector("#formCadClient");
        // fields
        this.inputName = document.querySelector("#inputName");
        this.inputCpf = document.querySelector("#inputCpf");
        this.inputEmail = document.querySelector("#inputEmail");
        this.inputPhone = document.querySelector("#inputPhone");
        this.inputPassword = document.querySelector("#inputPassword");
        this.inputConfirmPassword = document.querySelector("#inputConfirmPassword");
        // spans errors
        this.spanErrorName = document.querySelector("#msgNameError");
        this.spanErrorPhone = document.querySelector("#msgPhoneError");
        this.spanErrorCpf = document.querySelector("#msgCpfError");
        this.spanErrorEmail = document.querySelector("#msgEmailError");
        this.spanErrorPassword = document.querySelector("#msgPasswordError");
        this.spanErrorConfirmPassword = document.querySelector("#msgConfirmPasswordError");
        // icon error
        this.iconError = "<i class='bx bxs-info-circle' style='color:#fd837c'  ></i>";
    }

    isAllFieldsValid(){
        const formValidator = new formValidate();
        let formValid = true;
        this.cleanAllSpans();

        if(!formValidator.isEmailValid(this.inputEmail.value)){
            this.spanErrorEmail.innerHTML = this.iconError+"Email invalido!";
            formValid = false;
        }

        if(!formValidator.isCpfValid(this.inputCpf.value)){
            this.spanErrorCpf.innerHTML = this.iconError+"CPF invalido!";
            formValid = false;
        }

        if(!formValidator.isPasswordValid(this.inputPassword.value)){
            this.spanErrorPassword.innerHTML = this.iconError+"Senha invalida!";
            formValid = false;
        }

        if(!formValidator.isPhoneValid(this.inputPhone.value)){
            this.spanErrorPhone.innerHTML = this.iconError+"Telefone invalido!";
            formValid = false;
        }

        if(formValidator.isEmpty(this.inputEmail.value)){
            this.spanErrorEmail.innerHTML = this.iconError+"Campo email está vazio!";
            formValid = false;
        }

        if(formValidator.isEmpty(this.inputName.value)){
            this.spanErrorName.innerHTML = this.iconError+"Campo nome está vazio!";
            formValid = false;
        }

        if(formValidator.isEmpty(this.inputPhone.value)){
            this.spanErrorPhone.innerHTML = this.iconError+"Campo telefone está vazio!";
            formValid = false;
        }

        if(formValidator.isEmpty(this.inputCpf.value)){
            this.spanErrorCpf.innerHTML = this.iconError+"Campo cpf está vazio!";
            formValid = false;
        }

        if(formValidator.isEmpty(this.inputPassword.value)){
            this.spanErrorPassword.innerHTML = this.iconError+"Campo senha está vazio!";
            formValid = false;
        }

        if(!formValidator.isEqualValues(this.inputPassword.value,this.inputConfirmPassword.value)){
            this.spanErrorConfirmPassword.innerHTML = this.iconError+"senhas não são iguais!";
            formValid = false;
        }

        if(formValidator.isEmpty(this.inputConfirmPassword.value)){
            this.spanErrorConfirmPassword.innerHTML = this.iconError+"Campo confirmar senha está vazio!";
            formValid = false;
        }
      
        return formValid;
    }

    cleanAllSpans(){
        this.spanErrorEmail.innerHTML = "";
        this.spanErrorCpf.innerHTML = "";
        this.spanErrorPhone.innerHTML = "";
        this.spanErrorEmail.innerHTML = "";
        this.spanErrorName.innerHTML = "";
        this.spanErrorPhone.innerHTML = "";
        this.spanErrorCpf.innerHTML = "";
        this.spanErrorPassword.innerHTML = "";
        this.spanErrorConfirmPassword.innerHTML = "";
        this.spanErrorConfirmPassword.innerHTML = "";
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