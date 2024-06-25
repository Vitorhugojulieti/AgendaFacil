export default class modals{
    constructor(modal,btnOpen,btnClose){
        this.modal = document.querySelector(modal);
        this.btnOpen = document.querySelector(btnOpen);
        this.btnClose = document.querySelector(btnClose);
    }

    init(){
        this.btnOpen.addEventListener('click',(e)=>{
            this.modal.showModal();
        });

        this.btnClose.addEventListener('click',(e)=>{
            this.modal.close();
        });
    }
}