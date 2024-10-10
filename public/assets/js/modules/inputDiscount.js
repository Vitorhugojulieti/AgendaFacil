export default class inputDiscount{
    constructor(btnAdd,btnLess,display,step,displayAmount){
        this.btnAdd = document.querySelector(btnAdd);
        this.btnLess = document.querySelector(btnLess);
        this.display = document.querySelector(display);
        this.valueDiscount = 0;
        this.step = step;
        this.displayAmount = document.querySelector(displayAmount);
    }

    add(){
        if(this.display.value  && this.display.value != 100){
            this.display.value = parseInt(this.display.value) + parseInt(this.step);
            this.updateDisplayAmount();
        }
    }

    remove(){

        if(this.display.value != 0 && this.display.value != 100){
            this.display.value = parseInt(this.display.value) - parseInt(this.step);
            this.updateDisplayAmount();
        }

        if(this.display.value == 0){
            this.displayAmount.innerHTML = this.initialValue;
        }
       
        if(this.display.value == 100){
            this.display.value = 0;
            this.displayAmount.innerHTML = this.initialValue;
        }
    }

    updateDisplayAmount() {
        const discountPercentage = parseFloat(this.display.value) / 100;
        const discountedPrice = parseFloat(this.initialValue) * (1 - discountPercentage);
        this.displayAmount.innerHTML = discountedPrice.toFixed(2);
    }


    init(){
        this.initialValue = parseFloat(this.displayAmount.innerHTML);
        this.updateDisplayAmount();

        this.btnAdd.addEventListener('click',(e)=>{
            this.add();
        })

        this.btnLess.addEventListener('click',(e)=>{
            this.remove();
        })
    }
}