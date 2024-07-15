export default class activeLoader{
    constructor(){
        this.loader = document.querySelector('.loading');
    }

    setEnabled(){
        this.loader.classList.remove('hidden');
        this.loader.classList.add('block');
    }

    setDisabled(){
        this.loader.classList.remove('block');
        this.loader.classList.add('hidden');
    }

}