import formValidate from "./formValidate.js"

    
export default class ValidateCadService{
    constructor(form){
        this.form = document.querySelector(form);
        // fields
        this.inputName = document.querySelector("#inputName");
        this.inputDescription = document.querySelector("#inputDescription");
        this.inputDuration = document.querySelector("#inputDuration");
        this.inputPrice = document.querySelector("#inputPrice");
        // spans errors
        this.spanErrorName = document.querySelector("#msgNameError");
        this.spanErrorDescription = document.querySelector("#msgDescriptionError");
        this.spanErrorDuration = document.querySelector("#msgDurationError");
        this.spanErrorPrice = document.querySelector("#msgPriceError");

        // icon error
        this.iconError = "<i class='bx bxs-info-circle' style='color:#fd837c'  ></i>";
    }

    isAllFieldsValid(){
        const formValidator = new formValidate();
        let formValid = true;
        this.cleanAllSpans();

        if(formValidator.isEmpty(this.inputDescription.value)){
            this.spanErrorDescription.innerHTML = this.iconError+"Campo descrição está vazio!";
            formValid = false;
        }

        if(formValidator.isEmpty(this.inputName.value)){
            this.spanErrorName.innerHTML = this.iconError+"Campo nome está vazio!";
            formValid = false;
        }

        if(formValidator.isEmpty(this.inputDuration.value)){
            this.spanErrorDuration.innerHTML = this.iconError+"Campo duração está vazio!";
            formValid = false;
        }

        if(formValidator.isEmpty(this.inputPrice.value)){
            this.spanErrorPrice.innerHTML = this.iconError+"Campo preço está vazio!";
            console.log(this.inputPrice.value);

            formValid = false;
        }
      
        return formValid;
    }

  
    cleanAllSpans(){
        this.spanErrorName.innerHTML = "";
        this.spanErrorDescription.innerHTML = "";
        this.spanErrorDuration.innerHTML = "";
        this.spanErrorPrice.innerHTML = "";
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