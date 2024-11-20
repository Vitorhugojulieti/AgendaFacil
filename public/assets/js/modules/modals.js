export default class modals{
    constructor(modal,btnOpen,btnClose){
        this.modal = document.querySelector(modal);
        this.btnOpen = document.querySelector(btnOpen);
        this.btnClose = document.querySelector(btnClose);
    }

    setMessage(message,elementMessage){
        if(elementMessage && message){
            this.elementMessage = document.querySelector(elementMessage);
            this.elementMessage.innerHTML = message;   
        }
    }

    openModal(){
        this.modal.showModal();
    }

    closeModal(){
        this.modal.close();
    }

    setTextButtonDelete(message){
        if(message != null){
            let button = document.querySelector('#btnDelete');
            button.innerHTML = message;
        }
    }

    init(){
       if(this.btnOpen){
            this.btnOpen.addEventListener('click',(e)=>{
                this.modal.showModal();
            });
       }

        this.btnClose.addEventListener('click',(e)=>{
            this.modal.close();
        });
    }
}