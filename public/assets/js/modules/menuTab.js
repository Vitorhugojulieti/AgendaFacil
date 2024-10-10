export default class menuTab{
    constructor(menu, sections){
        this.menu = document.querySelector(menu);
        this.sections = sections;
    }

    initializeSections(){
        let sectionsHtml = [];
        this.sections.forEach(section => {
            sectionsHtml.push(document.querySelector(section));
        });
        this.sections = sectionsHtml;
    }

    disableAllSections(){
        this.sections.forEach(section => {
            section.classList.add('hidden');
            section.classList.remove('flex');
        });
    }

    activeSection(section){
        this.disableAllSections();
        section.classList.add('flex');
        section.classList.remove('hidden');
    }

    initializeTabs(){
        this.sections[0].classList.add('flex');
        this.sections[0].classList.remove('hidden');
    }

    init(){
        this.initializeSections();
        this.initializeTabs();

        this.menu.addEventListener('change',(e)=>{
            let opts = document.querySelectorAll('.opt');
            if (e.target.name === 'opt') {
                opts.forEach(opt => opt.classList.remove('opt-selected'));
                e.target.parentElement.classList.add('opt-selected');
                this.sections.forEach(section => {
                    if(section.getAttribute('id') == e.target.value){
                        this.activeSection(section);
                    }
                });
            }

        })
    }
}