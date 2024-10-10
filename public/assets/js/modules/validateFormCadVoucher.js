import formValidate from "./formValidate.js"
import CookieManager from "./CookieManager.js";

export default class validateFormCadVoucher{
    constructor(){
        this.form = document.querySelector('#formCadVoucher');
        // fields
        this.formValidator = new formValidate();
        this.nameVoucher = document.querySelector('#inputName');
        this.descriptionVoucher = document.querySelector('#inputDescription');
        this.durationVoucher = document.querySelector('#inputDuration');
        this.activeVoucher = document.querySelector('#inputActive');
        this.containerServices = document.querySelector('#containerSelectedServices');

        this.spanNameVoucher = document.querySelector('#msgNameError');
        this.spanDescriptionVoucher = document.querySelector('#msgDescriptionError');
        this.spanErrorServices = document.querySelector('#msgErrorServices');
        // icon error
        this.iconError = "<i class='bx bxs-info-circle' style='color:#fd837c'  ></i>";
        this.managerDiscount = document.querySelector('#managerDiscount');
    }

    isAllFieldsValid(){
        let formValid = true;
        this.cleanAllSpans();

        if(this.formValidator.isEmpty(this.nameVoucher.value)){
            this.spanNameVoucher.innerHTML = this.iconError+'Campo nome está vazio!';
            formValid = false;
        }

        if(this.formValidator.isEmpty(this.descriptionVoucher.value)){
            this.spanDescriptionVoucher.innerHTML = this.iconError+'Campo descrição está vazio!';
            formValid = false;
        }

        if(this.containerServices == null){
            this.spanErrorServices.innerHTML = this.iconError+'Nenhum serviço selecionado!';
            formValid = false;
        }else if(this.containerServices.children.length < 1){
            this.spanErrorServices.innerHTML = this.iconError+'Nenhum serviço selecionado!';
            formValid = false;
        }
      
      
        return formValid;
    }

    initializeValuesCookies(){
        if(CookieManager.getCookie('nameVoucher') && CookieManager.getCookie('durationVoucher') && CookieManager.getCookie('activeVoucher') && CookieManager.getCookie('descriptionVoucher')){
            this.nameVoucher.value = CookieManager.getCookie('nameVoucher');
            this.durationVoucher.value = CookieManager.getCookie('durationVoucher');
            this.activeVoucher.value = CookieManager.getCookie('activeVoucher');
            this.descriptionVoucher.value = CookieManager.getCookie('descriptionVoucher');
        }
    }

    cleanAllSpans(){
        this.spanNameVoucher.innerHTML = "";
        this.spanDescriptionVoucher.innerHTML = "";
        this.spanErrorServices.innerHTML = "";
    }

    deleteAllCookies(){
        CookieManager.deleteCookie('nameVoucher','/admin/voucher/store');
        CookieManager.deleteCookie('durationVoucher','/admin/voucher/store');
        CookieManager.deleteCookie('activeVoucher','/admin/voucher/store');
        CookieManager.deleteCookie('descriptionVoucher','/admin/voucher/store');
    }


    sendForm(){
        this.form.addEventListener('submit',(e)=>{

            if(this.isAllFieldsValid()){
                this.deleteAllCookies();
                e.target.submit();
            }
            e.preventDefault();
        })
    }

    init(){
        this.initializeValuesCookies();
        this.sendForm();
    }
}

