import generateSchedules from "./generateSchedules.js";

export default class generateScrollMonthsAndDays {
    constructor(containerMonths, containerDays,requestUser) {
        this.containerMonths = document.querySelector(containerMonths);
        this.containerDays = document.querySelector(containerDays);
        this.requestUser = requestUser;
        this.months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        this.weekdays = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado']; // Nomes dos dias da semana
    }

    generateHtmlMonths() {
        let html = '';
        for (let index = 0; index < this.months.length; index++) {
            if (new Date().getMonth() === index) {
                html += `<label for="month${this.months[index]}" class="day-selected rounded-full text-center text-xl months text-grayInput  p-2 cursor-pointer"><input type="radio" name="month" id="month${this.months[index]}" value=${index + 1} class="hidden" checked/>${this.months[index]}</label>`;
            } else {
                html += `<label for="month${this.months[index]}" class="rounded-full text-center text-xl months text-grayInput p-2 cursor-pointer"><input type="radio" name="month" id="month${this.months[index]}" value=${index + 1} class="hidden"/>${this.months[index]}</label>`;
            }
        }
        html += '</div>';
        this.containerMonths.innerHTML = html;
    }

    generateHtmlDays(month, year) {
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        let html = '';

        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day); // Criar uma nova data para o dia atual
            const dayOfWeek = this.weekdays[date.getDay()]; // Pegar o nome do dia da semana correspondente
            if(new Date().getDate() == day){
                html += `<label for="day${day}" class="days day-selected rounded-full text-grayInput text-center  p-2  flex flex-col items-center cursor-pointer" >
                        <input type="radio" name="day" id="day${day}" value=${day} class="hidden" checked/> 
                        <span class="text-base font-Poppins ">${day}</span>
                        <span class="text-sm font-Poppins ">${dayOfWeek}</span>
                    </label>`;
            }else{
                html += `<label for="day${day}" class="days rounded-full text-grayInput text-center  p-2  flex flex-col items-center cursor-pointer" >
                        <input type="radio" name="day" id="day${day}" value=${day} class="hidden"/> 
                        <span class="text-base font-Poppins ">${day}</span>
                        <span class="text-sm font-Poppins ">${dayOfWeek}</span>
                    </label>`;
            }
        }
        html += '</div>';
        this.containerDays.innerHTML = html;
    }

    init() {
        this.generateHtmlMonths();
        this.generateHtmlDays(new Date().getMonth(), new Date().getFullYear());

        // Get schedules today
        console.log(new Date().getMonth());
        console.log(new Date().getDate());
        const scheduleManager = new generateSchedules('#listSchedules',this.requestUser);
        scheduleManager.setMonth(new Date().getMonth() + 1);
        scheduleManager.setDay(new Date().getDate());
        scheduleManager.generate();

        document.addEventListener('change', function(event) {
            if (event.target.name == 'day') {
                scheduleManager.setDay(event.target.value);
                scheduleManager.generate();
                let labels = document.querySelectorAll('label.days');
                labels.forEach(label =>
                    label.classList.remove('day-selected')
                );
                console.log(event.target.parentElement);
                event.target.parentElement.classList.add('day-selected');
            } else if (event.target.name == 'month') {
                scheduleManager.setMonth(event.target.value);
                scheduleManager.generate();
                let labels = document.querySelectorAll('label.months');
                labels.forEach(label =>
                    label.classList.remove('day-selected')
                );
                event.target.parentElement.classList.add('day-selected');
            }
        });
    }
}
