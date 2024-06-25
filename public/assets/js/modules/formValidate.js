export default class formValidate{
    constructor(){
        this.emailRegex = /^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[A-Za-z]+$/;
        this.cpfRegex = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
        this.phoneRegex = /^\(\d{2}\) \d{5}-\d{4}$/;
    }

    isEmailValid(value){
        return this.emailRegex.test(value);
    }

    isCpfValid(value){
        return this.cpfRegex.test(value);
    }

    isPhoneValid(value){
        return this.phoneRegex.test(value);
    }

    isEmpty(value){
        return value.trim() === "";
    }

    isEqualValues(value1,value2){
        return value1 == value2;
    }
}