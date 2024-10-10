export default class validateStoreSchedule{
    constructor(form, acordions, sendButton){
        this.form = form;
        this.acordions = acordions;
        this.sendButton = sendButton;
    }

    activeSendButton(){
        this.sendButton.classList.remove('btnDisabled');
    }

    validateAcordionData(){

    }

    validateAcordionPayment(){

    }


    validateAllAcordions(){
        let valid = true;

        if(!this.validateAcordionData()){
            valid = false;
        }

        if(!this.validateAcordionPayment()){
            valid = false;
        }

        return valid;
    }

    init(){
        this.form.addEventListener('submit',(e)=>{
            e.preventDefault();
            if(this.validateAllAcordions()){
                e.target.submit();
            }
        })
    }

}