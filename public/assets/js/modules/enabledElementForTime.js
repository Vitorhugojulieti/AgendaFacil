export default class enabledElementForTime{
    constructor(element){
        this.element = document.querySelector(element);
        this.interval = 60;
    }

    setEnabled(){
        this.element.classList.remove('disabled');
    }

    init(){
        let uri = window.location.pathname;

        console.log(uri == "/signup/confirmEmail/resend");
        if(uri === "/signup/confirmEmail/resend"){
            let counter = this.interval;
            this.element.classList.add('disabled');

            const timer = setInterval(() => {
                counter--;
                this.element.innerHTML = "Reenviar codigo em "+counter;
                if (counter === 0) {
                    clearInterval(timer);
                    this.setEnabled();
                    this.element.innerHTML = "Reenviar codigo";
                }
            }, 1000);
        }
        
    }
}