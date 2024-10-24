// checkbox manager styles 
const days = document.querySelectorAll('.day');
const containerHours = document.querySelector('#containerHours');
const containerInputs = document.querySelector('#containerInputs');
const buttonAdd = document.querySelector('#btnAddHour');
const arrayCheckboxs = document.querySelectorAll('.check-day');
let counter = 0;


days.forEach(day => {
    day.addEventListener('change',(e)=>{
       console.log(e.target.parentElement);
       e.target.parentElement.classList.toggle('day-check');
    });
});

// manager hours
function addHours(element){
    element.parentElement.parentElement.querySelector('.flex-1').classList.add('hidden');
    element.parentElement.parentElement.querySelector('.hours').classList.remove('hidden');
    element.parentElement.parentElement.querySelector('.hours').classList.add('flex');
}

function clearChecks(){
    // let days = document.querySelectorAll('.day');
    days.forEach(day => {
        day.classList.remove('day-check');
        day.querySelector('input[type="checkbox"]').checked = false;    
    });
}


function createInputs(){
    let html = `<div id="inputsHour" class="w-full border-b border-b-lightGray flex justify-center items-center gap-4 p-2">
                        <div class="hours flex items-center gap-4">
                            <div class="morning flex items-center gap-4">
                                <span class=" text-principal10 font-semibold ">Manhã</span>
                                <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                    <input type="time" min="00:00" max="11:59" id="inputOpeningHoursMorningStart"  class="w-full p-2 outline-none bg-transparent  transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder " >
                                </div>

                                <span class=" text-principal10 font-semibold ">as</span>

                                <div class="flex items-center border-2 border-grayInput rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                    <input type="time" min="00:00" max="11:59" id="inputOpeningHoursMorningEnd"  class="w-full p-2 outline-none bg-transparent  transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder " >
                                </div>
                            </div>

                            <div class="afternoon flex items-center gap-4">
                                <span class=" text-principal10 font-semibold ">Tarde</span>
                                <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                    <input type="time" min="12:00" max="23:59" id="inputOpeningHoursAfternoonStart"  class="w-full p-2 outline-none bg-transparent  transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder " >
                                </div>

                                <span class=" text-principal10 font-semibold ">as</span>
                                
                                <div class="flex items-center border-2 border-grayInput   rounded focus-within:border-principal10 focus-within:text-principal10 focus-within:bg-white" style="box-shadow:0 0 10px 5px rgb(0,0,0,0.02);">
                                    <input type="time" min="12:00" max="23:59" id="inputOpeningHoursAfternoonEnd"  class="w-full p-2 outline-none bg-transparent  transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder " >
                                </div>
                            </div>

                            <button type="button" onclick="cancelHour(this)"><i class='bx bx-x text-3xl' style='color:#e22b20'  ></i></button>
                            <button type="button" onclick="create(this)"><i class='bx bx-check text-3xl' style='color:#8ef1b3'  ></i></i></button>
                        </div>
                    </div>`;
    containerInputs.innerHTML = html;
}

function cancel(){
    const inputs = document.querySelector('#inputsHour');
    inputs.remove();
}

function create(){
    const index = document.querySelectorAll('.hour').length;
    const weekDays = ['Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado','Domingo']

    const openingMorningStart = document.querySelector('#inputOpeningHoursMorningStart');
    const openingMorningEnd = document.querySelector('#inputOpeningHoursMorningEnd');
    const openingAfternoonStart = document.querySelector('#inputOpeningHoursAfternoonStart');
    const openingAfternoonEnd = document.querySelector('#inputOpeningHoursAfternoonEnd');
    
    const containerCheckbox = document.querySelector('#container-checkboxs');
    const checkedBoxes = containerCheckbox.querySelectorAll('input[type="checkbox"]:checked');
    const days = Array.from(checkedBoxes).map(checkbox => checkbox.value);

    if(checkedBoxes.length == 0){
        let error = `<span id="errorHours" class="notification error" >Nenhum dia selecionado!</span>`;
        document.querySelector('main').insertAdjacentHTML('beforeend', error);
    }else if((checkedBoxes.length == 0) || openingMorningStart.value == ""  || openingAfternoonEnd.value == ""){
        let error = `<span id="errorHours" class="notification error" >Nenhum horario selecionado!</span>`;
        document.querySelector('main').insertAdjacentHTML('beforeend', error);
    }else{
        let html = `<div class="hour w-full flex items-center justify-between border border-lightGray rounded p-2">
        <div class="w-full flex flex-col">
            <div class="w-full flex items-center gap-4">
            ${days.map(day => `
                <span class="text-base text-grayInput font-semibold">${weekDays[day]}</span>
            `).join('')}
            </div>
            <span class="text-base text-principal10 font-semibold">Manhã ${openingMorningStart.value} as ${openingMorningEnd.value} - Tarde ${openingAfternoonStart.value} as ${openingAfternoonEnd.value}</span>
        </div>
        <button onclick="deleteHour(this)"><i class='bx bx-x text-3xl' style='color:#e22b20'></i></button>

        <div class="hidden">
            ${days.map(day => `
                <input type="checkbox" name="days[${index}][]"   value="${day}" checked>
            `).join('')}

            ${openingMorningStart.value == "" ? '' : `<input type="time" value="${openingMorningStart.value}" name="inputOpeningHoursMorningStart[${index}]"  class="w-full p-2 outline-none bg-transparent  transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder " />`}
            ${openingMorningEnd.value == "" ? '' : `<input type="time" value="${openingMorningEnd.value}" name="inputOpeningHoursMorningEnd[${index}]"  class="w-full p-2 outline-none bg-transparent  transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder " />`}
            ${openingAfternoonStart.value == "" ? '' : `<input type="time" value="${openingAfternoonStart.value}" name="inputOpeningHoursAfternoonStart[${index}]"  class="w-full p-2 outline-none bg-transparent  transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder " />`}
            ${openingAfternoonEnd.value == "" ? '' : `<input type="time" value="${openingAfternoonEnd.value}" name="inputOpeningHoursAfternoonEnd[${index}]"  class="w-full p-2 outline-none bg-transparent  transition-all duration-300 focus:border-principal10 focus:text-black placeholder:text-placeholder " />`}
        </div>
    </div>`;

    const containerHours = document.querySelector('#containerHours');
    containerHours.insertAdjacentHTML('beforeend', html);

    clearChecks();
    cancelHour();

    }
}

function deleteHour(element){
    element.parentElement.remove();
}


buttonAdd.addEventListener("click",(e)=>{
    e.preventDefault();
    createInputs();
})

window.addHours = addHours;
window.clearChecks = clearChecks;
window.cancelHour = cancel;
window.create = create;
window.deleteHour = deleteHour;
