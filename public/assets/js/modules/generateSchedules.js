export default class generateSchedules{
    constructor(container){
        this.month;
        this.day;
        this.container = document.querySelector(container);
    }

    generateTimes() {
        const now = new Date();
        const times = [];
        const year = now.getFullYear();
        const month = now.getMonth();
        const day = now.getDate();
      
        for (let hour = 1; hour <= 23; hour++) {
          const timeObj = new Date(year, month, day, hour, 0); // Set minutes to 0
          times.push(timeObj);
        }
      
        return times;
    }

    setDay(day){
        this.day = day;
    }

    setMonth(month){
        this.month = month;
    }

    async  getSchedules() {
        try {
          const response = await fetch(`http://localhost:8889/Schedule/getSchedules/?day=${this.day}&month=${this.month}`);
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          const data = await response.json();
          return data;
        } catch (error) {
          console.error('There was a problem with the fetch operation:', error);
        }
      }
      

    generateHtml(times,schedules){
        const schedulesArray = Object.values(schedules);
        let html = '<div class="w-full flex flex-col">';

        times.forEach(time => {
            const scheduleHtml = `
                <li class="w-full flex flex-col items-start gap-2 p-4">
                    <span class="w-full border-b  border-grayInput">${time.toLocaleTimeString()}</span> 
                    ${schedulesArray.filter(schedule => new Date(schedule.startTime.date).getHours() == time.getHours())
                        .map(schedule => `
                            <span class="w-full p-4 bg-principal3 rounded-md flex items-center justify-between  mt-2 ml-8">
                                <div class="flex items-center gap-4">
                                    <i class='bx bx-calendar-check text-3xl' style='color:#223249'></i>
                                    <div class="details flex flex-col">
                                        <span class="text-xl font-Urbanist font-semibold">Agendamento</span>
                                        <span>${ new Date(schedule.startTime.date).toLocaleTimeString() } - ${ new Date(schedule.endTime.date).toLocaleTimeString() }</span>
                                    </div>
                                </div>
                                <a href="/schedule/show/${schedule.id}" class="hover:underline">Ver mais detalhes</a>
                            </span>
                        `)
                        .join('')}
                </li>
            `;
            html += scheduleHtml;
        });
        html +=`</div>`;
        this.container.innerHTML = html;
    }

    generate(){ 
        this.getSchedules()
        .then(data => {
            // A requisição foi bem-sucedida, os dados estão em data
            console.log('schedules -aqui:', data);
            this.generateHtml(this.generateTimes(),data);
            // Aqui você pode utilizar os dados para atualizar a interface, por exemplo
        })
        .catch(error => {
            // Ocorreu um erro durante a requisição
            console.error('Erro ao buscar horários:', error);
        });
    }
}