import validateStepForm from "./validateStepForm.js";

export default class steps{
    constructor(btnNext,btnPrevious,containers,counter,stepClass,controls,sendButton){
        this.btnNext = document.querySelector(btnNext);
        this.btnPrevious = document.querySelector(btnPrevious);
        this.containers = containers;
        this.counter = document.querySelector(counter);
        this.steps = document.querySelectorAll(stepClass);
        this.controls = document.querySelector(controls);
        this.sendButton = document.querySelector(sendButton);
    }

    initializeContainers(){
        let arrayElementsContainers = [];

        for (let i = 0; i < this.containers.length; i++) {
            arrayElementsContainers.push(document.querySelector(this.containers[i]));
        }

        this.containers =  arrayElementsContainers;
    }


    setNextContainer(currentIndex){
        this.activeSendButton(currentIndex -1);

        if(this.containers.length-1 > currentIndex && currentIndex !== -1 && this.validAllFieldsStep(currentIndex)){
            this.containers[currentIndex].classList.add('hidden');
            this.containers[currentIndex].classList.remove('flex');

            this.containers[currentIndex + 1].classList.remove('hidden');
            this.containers[currentIndex + 1].classList.add('flex');

            this.updateCounter();
            this.updateStep('next');
        }
    }

    setPreviousContainer(currentIndex){
        if(currentIndex !== 0 && currentIndex !== -1){
            this.containers[currentIndex].classList.add('hidden');
            this.containers[currentIndex].classList.remove('flex');

            this.containers[currentIndex - 1].classList.remove('hidden');
            this.containers[currentIndex - 1].classList.add('flex');

            this.updateCounter();
            this.updateStep('previous');
        }
    }

    testContainerVisible(){
        let index = -1;
        for (let i = 0; i < this.containers.length; i++) {
            if(this.containers[i] && this.containers[i].classList.contains('flex')){
                index = i;
                break;
            }
        }

        return index;
    }

    updateCounter(){
        let position = this.testContainerVisible() +1;
        this.counter.innerHTML = position+'/4'
    }

    updateStep(origin){
        let position = this.testContainerVisible() -1;

        if(origin === 'previous'){
            position = this.testContainerVisible();
        }
        this.steps[position].classList.toggle('complete');
    }

    initializeOnInvalid(){
        let index = 0;
        for (let i = 0; i < this.containers.length; i++) {
            if(this.containers[i].classList.contains('invalid')){
                index = i;
                break;
            }
        }

        if(index !== 0){
            for (let z = 0; z < this.containers.length; z++) {
                if(z === index){
                    this.containers[z].classList.add('flex');
                    this.containers[z].classList.remove('hidden');
                }else{
                    this.containers[z].classList.remove('flex');
                    this.containers[z].classList.add('hidden');
                }
            }
        }else{
            this.containers[0].classList.add('flex');
            this.containers[0].classList.remove('hidden');

            for (let y = 1; y < this.containers.length; y++) {
                this.containers[y].classList.remove('flex');
                this.containers[y].classList.add('hidden');
            }
        }
    }

    validAllFieldsStep(index){
        let validateStep = new validateStepForm();
        return validateStep.init(index);
    }

    activeSendButton(index){
        console.log(index);
        if(index === this.containers.length-1){
            this.controls.classList.add('hidden');
            this.controls.classList.remove('flex');

            this.sendButton.classList.add('block');
            this.sendButton.classList.remove('hidden');
        }else{
            this.controls.classList.add('flex');
            this.controls.classList.remove('hidden');

            this.sendButton.classList.add('hidden');
            this.sendButton.classList.remove('block');
        }
    }

    init(){
        this.initializeContainers();
        this.initializeOnInvalid();

        this.btnNext.addEventListener('click',(e)=>{
            this.setNextContainer(this.testContainerVisible());
        });

        this.btnPrevious.addEventListener('click',(e)=>{
            this.setPreviousContainer(this.testContainerVisible());
        })
    }
}