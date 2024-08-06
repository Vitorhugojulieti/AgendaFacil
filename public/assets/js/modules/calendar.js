import generateTimes from "./generateTimes.js";
export default class calendar{
    constructor(container){
        this.container = document.querySelector(container);
        this.now = new Date();
    }

    generateCalendar(month, year) {
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const firstDay = new Date(year, month, 1).getDay();
        
        let html = '<div class="w-2/4 border border-lightGray shadow-sm shadow-black rounded-md flex flex-col gap-2"><h3 class="font-Poppins font-semibold text-lg p-4">'+this.now.toLocaleString('pt-BR', { month: 'long' }).charAt(0).toUpperCase() + this.now.toLocaleString('pt-BR', { month: 'long' }).slice(1)+' '+this.now.getFullYear()+'</h3><table><thead><tr>';
        html += '<th class="text-lightGray font-Poppins font-light">Dom</th><th class="text-lightGray font-Poppins font-light">Seg</th><th class="text-lightGray font-Poppins font-light">Ter</th><th class="text-lightGray font-Poppins font-light">Qua</th><th class="text-lightGray font-Poppins font-light">Qui</th><th class="text-lightGray font-Poppins font-light">Sex</th><th class="text-lightGray font-Poppins font-light">Sáb</th>';
        html += '</tr></thead><tbody><tr>';

        // Preencher as células do primeiro mês
        for (let i = 0; i < firstDay; i++) {
            html += '<td></td>';
        }

        for (let day = 1; day <= daysInMonth; day++) {
            console.log(day === this.now.getDate());
            if(day === this.now.getDate()){
                html += `<td class="day-selected text-center p-2"><input type="radio" name="day" id="day${day}" value=${day} checked class="hidden"/> <label class="hover:cursor-pointer w-4 h-4"  for="day${day}">${day}</label></td>`;
            }else{
                html += `<td class="text-center p-2"><input type="radio" name="day" id="day${day}" value=${day} class="hidden"/> <label class="hover:cursor-pointer w-4 h-4"  for="day${day}">${day}</label></td>`;
            }
            if ((firstDay + day) % 7 === 0) {
                html += '</tr><tr>';
            }
        }

        // Preencher o resto do mês com células vazias
        if ((firstDay + daysInMonth) % 7 !== 0) {
            for (let i = (firstDay + daysInMonth) % 7; i < 7; i++) {
                html += '<td></td>';
            }
        }

        html += '</tr></tbody></table></div>';
        this.container.innerHTML = html;
    }

    init(){
        const timesGenerator = new generateTimes();
        timesGenerator.setDay(this.now.getDate());
        timesGenerator.generateTimesElements();
        timesGenerator.init();
        const now = new Date();
        this.generateCalendar(now.getMonth(), now.getFullYear());
        document.addEventListener('change', function(event) {
            if (event.target.name === 'day') {
                const labels = document.querySelectorAll('label');
                labels.forEach(label => label.parentElement.classList.remove('day-selected'));
                event.target.parentElement.classList.add('day-selected');
                timesGenerator.setDay(event.target.value);
                timesGenerator.generateTimesElements();
            }
        });
    }
}