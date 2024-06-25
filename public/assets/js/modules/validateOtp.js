import formValidate from "./formValidate.js"

export default class validateOtp{
    constructor(classInputs){
        this.inputs = document.querySelectorAll(classInputs);
        this.form = document.querySelector("#formOtp");
    }

    handleFocus(index){
        this.inputs[index + 1].focus();
    }

    testLimitValue(input){
        return input.value.length > 0;
    }

    verifyFiled(input, index){
        if (index < this.inputs.length - 1) {
            if(this.testLimitValue(input)){
                this.handleFocus(index);
            }
        }
    }

    validAllFields(){
        const formValidator = new formValidate();
        let formValid = true;

        this.inputs.forEach((input) =>{
            if(formValidator.isEmpty(input.value)){
                formValid = false;
            }
        })

        return formValid;
    }

    manageOtp(){
        this.inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                this.verifyFiled(input,index);
            });
        });

    }

    sendForm(){
        this.form.addEventListener('submit',(e)=>{
            e.preventDefault();
            if(this.validAllFields()){
                e.target.submit();
            }
        })
    }

    init(){
        this.manageOtp();
        this.sendForm();
    }
}
