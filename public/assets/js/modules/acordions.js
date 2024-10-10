export default class acordions{
    constructor(acordions){
        this.acordions = acordions;
    }

    initializeAcordions(){
        let htmlAcordions = [];
        this.acordions.forEach(acordion => {
            htmlAcordions.push(document.querySelector(acordion));
        });
        this.acordions = htmlAcordions; 
    }

    setChecked(numberAcordion){
        this.acordions[numberAcordion].classList.add('check');
    }

    setNotChecked(numberAcordion){
        this.acordions[numberAcordion].classList.remove('check');
    }

    setActive(numberAcordion){
        this.acordions[numberAcordion].classList.add('active');
    }

    setNotActive(numberAcordion){
        this.acordions[numberAcordion].classList.remove('active');
    }

    init(){
        this.initializeAcordions();
        this.setActive(0);
        this.setChecked(0);
        console.log(this.acordions);
            this.acordions.forEach(acordion => {
            acordion.addEventListener('click',(e)=>{
                acordion.classList.toggle('active');
            })
        });
    }
}