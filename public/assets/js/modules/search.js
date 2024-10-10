export default class search{
    constructor(elements,inputSearch){
        this.elements = document.querySelectorAll(elements);
        this.inputSearch = document.querySelector(inputSearch);
    }

    disableElement(element){
        element.classList.add('hidden');
        // element.classList.remove('flex');
    }   

    enableElement(element){
        element.classList.remove('hidden');
        // element.classList.add('flex');
    }   

    init(){
        console.log(this.elements);
        this.inputSearch.addEventListener('input',()=>{
            let searchText = this.inputSearch.value.toLowerCase();

            console.log(searchText);

            this.elements.forEach(element => {
                if(!element.innerText.toLowerCase().includes(searchText)){
                    this.disableElement(element);
                }else{
                    this.enableElement(element);
                }
            });
        })
    }
}