import CookieManager from "./modules/CookieManager.js";
import inputDiscount from "./modules/inputDiscount.js";
import modals from "./modules/modals.js";
import validateFormCadVoucher from "./modules/validateFormCadVoucher.js";

const cadVoucherValidator = new validateFormCadVoucher();
cadVoucherValidator.init();

const modalServicesManager = new modals('#modalServices','#btnOpenModalServices','#btnCloseModalServices');
modalServicesManager.init();

const discountManager = new inputDiscount('#btnAddDiscount','#btnLessDiscount','#displayDiscount',5,'#displayAmount');
discountManager.init();

// const cookiesManager = new CookieManager();
const loadersPage = document.querySelectorAll('.reload');

//inputs 
const inputName = document.querySelector('#inputName');
const inputDuration = document.querySelector('#inputDuration');
const inputActive = document.querySelector('#inputActive');
const inputDescription = document.querySelector('#inputDescription');


loadersPage.forEach(loader => {
    loader.addEventListener('click',(e)=>{
        if(CookieManager.getCookie('nameVoucher') && CookieManager.getCookie('durationVoucher') && CookieManager.getCookie('activeVoucher') && CookieManager.getCookie('descriptionVoucher')){

            CookieManager.deleteCookie('nameVoucher','/admin/voucher/store');
            CookieManager.deleteCookie('durationVoucher','/admin/voucher/store');
            CookieManager.deleteCookie('activeVoucher','/admin/voucher/store');
            CookieManager.deleteCookie('descriptionVoucher','/admin/voucher/store');

            CookieManager.setCookie('nameVoucher',inputName.value,1,'/admin/voucher/store');
            CookieManager.setCookie('durationVoucher',inputDuration.value,1,'/admin/voucher/store');
            CookieManager.setCookie('activeVoucher',inputActive.value,1,'/admin/voucher/store');
            CookieManager.setCookie('descriptionVoucher',inputDescription.value,1,'/admin/voucher/store');
        }else{
            CookieManager.setCookie('nameVoucher',inputName.value,1,'/admin/voucher/store');
            CookieManager.setCookie('durationVoucher',inputDuration.value,1,'/admin/voucher/store');
            CookieManager.setCookie('activeVoucher',inputActive.value,1,'/admin/voucher/store');
            CookieManager.setCookie('descriptionVoucher',inputDescription.value,1,'/admin/voucher/store');
        }
    })
});


