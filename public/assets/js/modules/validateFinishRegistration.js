import formValidate from "./formValidate.js";

export default class validateFinishRegistration{
    constructor(){
        this.form = document.querySelector("#formFinishRegistration");

        this.inputCpf = document.querySelector("#inputCpf");
        this.inputPhone = document.querySelector("#inputPhone");

        this.spanCpf = document.querySelector("#msgCpfError");
        this.spanPhone = document.querySelector("#msgPhoneError");

        this.iconError = "<i class='bx bxs-info-circle' style='color:#fd837c'  ></i>";
    }

    isAllFieldsValid(){
        const formValidator = new formValidate();
        this.cleanAllSpans();
        let formValid = true;

       
        if(!formValidator.isPhoneValid(this.inputPhone.value)){
            this.spanPhone.innerHTML = this.iconError+"Telefone invalido!";
            formValid = false;
        }

        if(!formValidator.isCpfValid(this.inputCpf.value)){
            this.spanCpf.innerHTML = this.iconError+"Cpf invalido!";
            formValid = false;
        }

        if(formValidator.isEmpty(this.inputCpf.value)){
            this.spanCpf.innerHTML = this.iconError+"Campo cpf está vazio!";
            formValid = false;
        }

        if(formValidator.isEmpty(this.inputPhone.value)){
            this.spanPhone.innerHTML = this.iconError+"Campo telefone está vazio!";
            formValid = false;
        }

        return formValid;
    }

    cleanAllSpans(){
        this.spanCpf.innerHTML = "";
        this.spanPhone.innerHTML = "";
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