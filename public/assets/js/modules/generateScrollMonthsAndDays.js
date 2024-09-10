import generateSchedules from "./generateSchedules.js";

export default class generateScrollMonthsAndDays{
    constructor(containerMonths,containerDays){
        this.containerMonths = document.querySelector(containerMonths);
        this.containerDays = document.querySelector(containerDays);
        this.months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    }

    generateHtmlMonths(){
        let html = '';
        for (let index = 0; index < this.months.length; index++) {
            if(new Date().getMonth() === index){
                // let monthHtml = `<span class="text-principal10 font-semibold text-2xl" > ${this.months[index]}</span>`;
                html += `<div class="rounded-full  text-center text-xl  p-2 "><input type="radio" name="month" id="month${this.months[index]}" value=${index+1} class="hidden"/> <label   for="month${this.months[index]}" class="months text-principal10 font-semibold text-2xl">${this.months[index]}</label></div>`;

                // html += monthHtml;
            }else{
                // let monthHtml = `<span class="text-grayInput text-xl">${this.months[index]}</span>`;
                // html += monthHtml;
                html += `<div class="rounded-full text-center text-xl  p-2 "><input type="radio" name="month" id="month${this.months[index]}" value=${index+1} class="hidden"/> <label   for="month${this.months[index]}" class="months text-grayInput text-xl">${this.months[index]}</label></div>`;

            }
        }
        html += '</div>';
        this.containerMonths.innerHTML = html;
    }

    generateHtmlDays(month,year){
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        let html = '';

        for (let day = 1; day <= daysInMonth; day++) {
            html += `<div class="rounded-full text-grayInput text-center text-xl  p-2 w-4 h-4 flex flex-col items-center"><input type="radio" name="day" id="day${day}" value=${day} class="hidden"/> <label   for="day${day}" class="days">${day}</label><span class="text-sm font-Poppins text-grayInput">${'QINTA'}</span></div>`;
        }
        html += '</div>';
        this.containerDays.innerHTML = html;
    }
    // setSelectedDay(day){
    //     day.
    // }

    init(){
        this.generateHtmlMonths();
        this.generateHtmlDays(new Date().getMonth(),new Date().getFullYear());

        //get schedules today
        console.log(new Date().getMonth());
        console.log(new Date().getDate());
        const scheduleManager = new generateSchedules('#listSchedules');
        scheduleManager.setMonth(new Date().getMonth()+1);
        scheduleManager.setDay(new Date().getDate());
        scheduleManager.generate();
       

        document.addEventListener('change', function(event) {
            if (event.target.name == 'day') {
                scheduleManager.setDay(event.target.value);
                console.log(event.target.value)
                scheduleManager.generate();
                let labels = document.querySelectorAll('label.days');
                labels.forEach(label => 
                    label.parentElement.classList.remove('day-selected')
                );
                event.target.parentElement.classList.add('day-selected');
            }else if(event.target.name == 'month'){
                scheduleManager.setMonth(event.target.value);
                console.log(event.target.value)

                scheduleManager.generate();
                let labels = document.querySelectorAll('label.months');
                labels.forEach(label => 
                    label.parentElement.classList.remove('day-selected')
                );
                event.target.parentElement.classList.add('day-selected');
            }
        });
    }
}