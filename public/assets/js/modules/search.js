export default class search{
    constructor(elements,inputSearch){
        this.elements = document.querySelectorAll(elements);
        this.inputSearch = document.querySelector(inputSearch);
    }

    disableElement(element){
        element.classList.add('hidden');
    }   

    enableElement(element){
        element.classList.remove('hidden');
    }   

    init(){
        console.log(this.elements);
        this.inputSearch.addEventListener('input',()=>{
            let searchText = this.inputSearch.value;

            console.log(searchText);

            this.elements.forEach(element => {
                if(!element.innerText.includes(searchText)){
                    this.disableElement(element);
                }else{
                    this.enableElement(element);
                }
            });
        })
    }
}