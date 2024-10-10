import formValidate from "./formValidate.js";

export default class validateStepFormCadCompany{
    constructor(){
        this.formValidate = new formValidate();
        //setp1
        this.nameCompany = document.querySelector('#inputNameCompany');
        this.cnpj = document.querySelector('#inputCnpjCompany');
        this.phoneCompany = document.querySelector('#inputPhoneCompany');
        this.category = document.querySelector('#inputCategory');
        //times
        this.openingHoursMorningStart = document.querySelector('#inputOpeningHoursMorningStart');
        this.openingHoursMorningEnd = document.querySelector('#inputOpeningHoursMorningEnd');
        this.openingHoursAfternoonStart = document.querySelector('#inputOpeningHoursAfternoonStart');
        this.openingHoursAfternoonEnd = document.querySelector('#inputOpeningHoursAfternoonEnd');

        this.spanNameCompany = document.querySelector('#msgNameCompanyError');
        this.spanPhoneCompany = document.querySelector('#msgPhoneCompanyError');
        this.spanCategoryCompany = document.querySelector('#msgCategoryCompanyError');
        this.spanCnpjCompany = document.querySelector('#msgCnpjError');
        //times
        this.spanOpeningHoursMorning = document.querySelector('#msgOpeningHoursMorningError');
        this.spanOpeningHoursAfternoon = document.querySelector('#msgOpeningHoursAfternoonError');
        //setp2
        this.cep = document.querySelector('#inputCep');
        this.number = document.querySelector('#inputNumber');
        this.road = document.querySelector('#inputRoad');
        this.city = document.querySelector('#inputCity');
        this.state = document.querySelector('#inputState');
        this.district = document.querySelector('#inputDistrict');

        this.spanCep = document.querySelector('#msgCepError');
        this.spanRoad = document.querySelector('#msgRoadError');
        this.spanCity = document.querySelector('#msgCityError');
        this.spanState = document.querySelector('#msgStateError');
        this.spanNumber = document.querySelector('#msgNumberError');
        this.spanDistrict = document.querySelector('#msgDistrictError');

        //setp3
        this.name = document.querySelector('#inputName');
        this.cpf = document.querySelector('#inputCpf');
        this.phone = document.querySelector('#inputPhone');
        this.email = document.querySelector('#inputEmail');
        this.password = document.querySelector('#inputPassword');
        this.passwordConfirm = document.querySelector('#inputConfirmPassword');

        this.spanErrorName = document.querySelector("#msgNameError");
        this.spanErrorPhone = document.querySelector("#msgPhoneError");
        this.spanErrorCpf = document.querySelector("#msgCpfError");
        this.spanErrorEmail = document.querySelector("#msgEmailError");
        this.spanErrorPassword = document.querySelector("#msgPasswordError");
        this.spanErrorConfirmPassword = document.querySelector("#msgConfirmPasswordError");
        // icon error
        this.iconError = "<i class='bx bxs-info-circle' style='color:#fd837c'  ></i>";
    }

    validateStep1(){
        let valid =true;

        if(this.formValidate.isEmpty(this.nameCompany.value)){
            this.spanNameCompany.innerHTML = this.iconError+'Campo nome está vazio!';
            valid = false;
        }

        if(this.formValidate.isEmpty(this.phoneCompany.value)){
            this.spanPhoneCompany.innerHTML = this.iconError+'Campo telefone está vazio!';
            valid = false;
        }

        if(!this.formValidate.isPhoneValid(this.phoneCompany.value)){
            this.spanPhoneCompany.innerHTML = this.iconError+'Campo telefone está invalido!';
            valid = false;
        }

        if(this.formValidate.isEmpty(this.cnpj.value)){
            this.spanCnpjCompany.innerHTML = this.iconError+'Campo cnpj está vazio!';
            valid = false;
        }

        if(!this.formValidate.isCnpjValid(this.cnpj.value)){
            this.spanCnpjCompany.innerHTML = this.iconError+'Campo cnpj está invalido!';
            valid = false;
        }

        if(this.formValidate.isEmpty(this.category.value)){
            this.spanCategoryCompany.innerHTML = this.iconError+'Campo categoria está vazio!';
            valid = false;
        }
        //times
        if(this.formValidate.isEmpty(this.openingHoursMorningStart.value)){
            this.spanOpeningHoursMorning.innerHTML = this.iconError+'Campo horario inicial está vazio!';
            valid = false;
        }

        if(this.formValidate.isEmpty(this.openingHoursMorningEnd.value)){
            this.spanOpeningHoursMorning.innerHTML = this.iconError+'Campo horario final está vazio!';
            valid = false;
        }

        if(this.formValidate.isEmpty(this.openingHoursAfternoonStart.value)){
            this.spanOpeningHoursAfternoon.innerHTML = this.iconError+'Campo horario inicial está vazio!';
            valid = false;
        }

        if(this.formValidate.isEmpty(this.openingHoursAfternoonEnd.value)){
            this.spanOpeningHoursAfternoon.innerHTML = this.iconError+'Campo horario final está vazio!';
            valid = false;
        }

        return valid;
    }

    validateStep2(){
        let valid = true;

        if(this.formValidate.isEmpty(this.cep.value)){
            this.spanCep.innerHTML = this.iconError+'Campo cep está vazio!';
            valid = false;
        }

        if(!this.formValidate.isCepValid(this.cep.value)){
            this.spanCep.innerHTML = this.iconError+'Campo cep está invalido!';
            valid = false;
        }

        if(this.formValidate.isEmpty(this.road.value)){
            this.spanRoad.innerHTML = this.iconError+'Campo endereço está vazio!';
            valid = false;
        }

        if(this.formValidate.isEmpty(this.city.value)){
            this.spanCity.innerHTML = this.iconError+'Campo cidade está vazio!';
            valid = false;
        }

        if(this.formValidate.isEmpty(this.state.value)){
            this.spanState.innerHTML = this.iconError+'Campo estado está vazio!';
            valid = false;
        }

        
        if(this.formValidate.isEmpty(this.number.value)){
            this.spanNumber.innerHTML = this.iconError+'Campo numero está vazio!';
            valid = false;
        }

        if(this.formValidate.isEmpty(this.district.value)){
            this.spanDistrict.innerHTML = this.iconError+'Campo bairro está vazio!';
            valid = false;
        }

        return valid;
    }

    validateStep3(){
        let valid = true;

        if(!this.formValidate.isEmailValid(this.email.value)){
            this.spanErrorEmail.innerHTML = this.iconError+"Email invalido!";
            valid = false;
        }

        if(!this.formValidate.isCpfValid(this.cpf.value)){
            this.spanErrorCpf.innerHTML = this.iconError+"CPF invalido!";
            valid = false;
        }

        if(!this.formValidate.isPasswordValid(this.password.value)){
            this.spanErrorPassword.innerHTML = this.iconError+"Senha invalida!";
            valid = false;
        }

        if(!this.formValidate.isPhoneValid(this.phone.value)){
            this.spanErrorPhone.innerHTML = this.iconError+"Telefone invalido!";
            valid = false;
        }

        if(this.formValidate.isEmpty(this.email.value)){
            this.spanErrorEmail.innerHTML = this.iconError+"Campo email está vazio!";
            valid = false;
        }

        if(this.formValidate.isEmpty(this.name.value)){
            this.spanErrorName.innerHTML = this.iconError+"Campo nome está vazio!";
            valid = false;
        }

        if(this.formValidate.isEmpty(this.phone.value)){
            this.spanErrorPhone.innerHTML = this.iconError+"Campo telefone está vazio!";
            valid = false;
        }

        if(this.formValidate.isEmpty(this.cpf.value)){
            this.spanErrorCpf.innerHTML = this.iconError+"Campo cpf está vazio!";
            valid = false;
        }

        if(this.formValidate.isEmpty(this.password.value)){
            this.spanErrorPassword.innerHTML = this.iconError+"Campo senha está vazio!";
            valid = false;
        }

        if(!this.formValidate.isEqualValues(this.password.value,this.passwordConfirm.value)){
            this.spanErrorConfirmPassword.innerHTML = this.iconError+"senhas não são iguais!";
            valid = false;
        }

        if(this.formValidate.isEmpty(this.passwordConfirm.value)){
            this.spanErrorConfirmPassword.innerHTML = this.iconError+"Campo confirmar senha está vazio!";
            valid = false;
        }


        return valid;
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

        this.spanNameCompany.innerHTML = "";
        this.spanCnpjCompany.innerHTML = "";
        this.spanPhoneCompany.innerHTML = "";
        this.spanCep.innerHTML = "";
        this.spanCity.innerHTML = "";
        this.spanState.innerHTML = "";
        this.spanRoad.innerHTML = "";
        this.spanNumber.innerHTML = "";
    }

    init(index){
        console.log(index);
        this.cleanAllSpans();

        let valid;
        if(index === 0){
            valid = this.validateStep1();
        }else if(index === 1){
            valid = this.validateStep2();
        }else if(index === 2){
            valid = this.validateStep3();
        }

        return valid;
    }
}