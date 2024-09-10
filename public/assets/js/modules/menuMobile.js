export default class menuMobile{
    constructor(btnOpen,btnClose,menu){
        this.btnOpen = document.querySelector(btnOpen);
        this.btnClose = document.querySelector(btnClose);
        this.menu = document.querySelector(menu);
    }

    open(){
        this.menu.classList.remove('hidden');
        this.menu.classList.add('flex');
        this.menu.classList.add('menuTransition');
    }

    close(){
        this.menu.classList.add('hidden');
        this.menu.classList.remove('flex');
        this.menu.classList.remove('menuTransition');
    }

    init(){
        this.btnOpen.addEventListener('click', ()=>{
            this.open();
        });

        this.btnClose.addEventListener('click', ()=>{
            this.close();
        });
    }
}