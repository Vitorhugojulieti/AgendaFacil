import maskInput from "./modules/masksInput.js";
import modals from "./modules/modals.js";
import searchCompany from "./searchCompany.js";

const managerModalFilters = new modals('#modalFilters','#btnOpenModalFilters','#btnCloseModalFilters');
managerModalFilters.init();

const maskInputCep = new maskInput(null,null,'#inputLocation');
maskInputCep.init();

$(document).ready(function() {
    $('#slidesBanners').slick({
      centerMode: true,
      centerPadding: '50px',
      slidesToShow: 1,
      slidesToScroll: 1,
      variableWidth: true,
      focusOnSelect: true,
      infinite: true,
      draggable: false,
      swipe: false,
      initialSlide: 0, 
      touchMove: false,
      autoplay: true,
      autoplaySpeed: 5000,
    });
  });

const labelsCategory = document.querySelector('#containerCategory').querySelectorAll('label');
document.querySelector('#containerCategory').addEventListener('change', function(event) {
if (event.target.name === 'category') {
    labelsCategory.forEach(label => label.classList.add('bg-white'));
    labelsCategory.forEach(label => label.classList.remove('bg-principal5'));
    event.target.parentElement.classList.remove('bg-white');
    event.target.parentElement.classList.add('bg-principal5');
}
});

const searchCompanyManager = new searchCompany('#inputSearchCompany','#listCompanys');
searchCompanyManager.init();


// filters

function changeLabelSelected(){
    labelsCategory.forEach(label => label.classList.add('bg-white'));
    labelsCategory.forEach(label => label.classList.remove('bg-principal5'));
    const selectedOptionStatus = document.querySelector('input[name="category"]:checked');
    selectedOptionStatus.parentElement.classList.remove('bg-white');
    selectedOptionStatus.parentElement.classList.add('bg-principal5');
}


const btnResetFilter = document.querySelector('#btnReset');
const btnFilter = document.querySelector('#btnFilter');
const labelAll = document.querySelector('#radioAll');
const spanCountFilters = document.querySelector('#iconFilter');


btnResetFilter.addEventListener('click',()=>{
    labelAll.checked = true;
    changeLabelSelected();
});


btnFilter.addEventListener('click',()=>{
    let url = `/home/`;

    const selectedOptionStatus = document.querySelector('input[name="category"]:checked');
    if(!selectedOptionStatus.value == ""){
        url += `?category=${selectedOptionStatus.value}`;
    }

    window.location.href = url;
});

function initializeModalFiltersApplied(){
        const urlParams = new URLSearchParams(window.location.search);
        
        const category = urlParams.get('category');
        labelsCategory.forEach(label =>{
            if(category == label.querySelector('input').value){
                label.querySelector('input').checked = true;
                changeLabelSelected();
            }
        })

    console.log(urlParams)
    if(urlParams.size == 1){
        spanCountFilters.innerHTML = 1;
        spanCountFilters.classList.remove('hidden');
        spanCountFilters.classList.add('flex');
    }
    

    
}

initializeModalFiltersApplied()