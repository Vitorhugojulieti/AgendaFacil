import popUp from "./modules/popUp.js";
import menuMobile from "./modules/menuMobile.js";
import notifications from "./modules/notifications.js";
import modals from "./modules/modals.js";

const popUpManagerAvatar = new popUp('#popUpAvatar','#btnOpenPopUpAvatar');
popUpManagerAvatar.init();

const popUpManagerNotification = new popUp('#popUpNotification','#btnOpenPopUpNotification');
popUpManagerNotification.init();

// const notificationsManager = new notifications();
// notificationsManager.init('#displayNotifications','#notificationList');

const menuMobileManager = new menuMobile('#btnOpenMenuMobile','#btnCloseMenuMobile','#menuMobile');
menuMobileManager.init();

const managerModalLocation = new modals('#modalLocation','#btnOpenModalLocation','#btnCloseModalLocation');
managerModalLocation.init();

document.addEventListener('DOMContentLoaded', function () {
    let spanLocation = document.querySelector('#spanLocation');
    if(spanLocation.innerText === 'Não encontrado!'){
        managerModalLocation.openModal();
        viewLocation.innerText = '';
    }
});

const form = document.querySelector('#formLocation');
form.addEventListener('submit',(e)=>{
    let valid = true;
    if(formValidator.isEmpty(inputCep.value)){
        e.preventDefault();
        spanError.innerHTML = iconError+" CEP invalido!";
        valid = false;
    }

    if(!formValidator.isCepValid(inputCep.value)){
        e.preventDefault();
        spanError.innerHTML = iconError+" CEP invalido!";
        valid = false;
    }
    
    if(valid){
        e.target.submit();
    }
})

const btnCloseModal = document.querySelector('#btnCloseModalLocation');
if(viewLocation.innerText != "Não encontrado!"){
    btnCloseModal.classList.remove('hidden');
}

//block esc button 
// document.addEventListener("keydown", function(event) {
//     if (event.key === "Escape" || event.keyCode === 27) {
//         event.preventDefault(); // Bloqueia a ação padrão
//     }
// });