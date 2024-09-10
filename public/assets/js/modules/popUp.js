export default class popUp{
    constructor(popUp,btnOpen){
        this.popUp = document.querySelector(popUp);
        this.btnOpen = document.querySelector(btnOpen);
    }

    openPopUp(){
        this.btnOpen.addEventListener('click',()=>{
            this.popUp.classList.toggle('hidden');
        console.log('aqui');

        })
    }

    closePopUp(){
        let popup = this.popUp;
        let btn = this.btnOpen;
        document.addEventListener('click', function(event) {
            const isClickInside = popup.contains(event.target);
            const isClickInsideBtnOpen = btn.contains(event.target);

            if (!isClickInside && !isClickInsideBtnOpen) {
                popup.classList.add('hidden');
            }
        })
    }

    init(){
        this.closePopUp();
        this.openPopUp();
    }
}