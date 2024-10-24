export default class generateSchedules {
    constructor(container) {
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
            const timeObj = new Date(year, month, day, hour, 0); // Minutos ajustados para 0
            times.push(timeObj);
        }

        return times;
    }

    setDay(day) {
        this.day = day;
    }

    setMonth(month) {
        this.month = month;
    }

    async getSchedules() {
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

    generateHtml(times, schedules) {
        let schedulesArray = Object.values(schedules);
        
        // Ordenar os agendamentos pelo horário inicial
        schedulesArray.sort((a, b) => new Date(a.startTime.date) - new Date(b.startTime.date));

        let html = '<div class="w-full flex flex-col">';

        // Filtrar os horários que têm agendamentos e exibi-los
        times.forEach(time => {
            const filteredSchedules = schedulesArray.filter(schedule => new Date(schedule.startTime.date).getHours() == time.getHours());
            
            if (filteredSchedules.length > 0) { // Somente exibe o horário se houver agendamentos
                const scheduleHtml = `
                    <li class="w-full flex flex-col items-start gap-2 p-4">
                        <span class="w-full border-b  border-grayInput">${time.getHours().toString().padStart(2, '0')+':'+time.getMinutes().toString().padStart(2, '0')}</span>
                        ${filteredSchedules
                            .map(schedule => `
                                <span class="w-full p-4 bg-principal4 rounded-md flex items-center justify-between mt-2 ml-8">
                                    <div class="flex items-center gap-4">
                                        <i class='bx bx-calendar-check text-3xl' style='color:#223249'></i>
                                        <div class="details flex flex-col">
                                            <span class="text-xl font-Urbanist font-semibold">Agendamento</span>
                                            <span>${new Date(schedule.startTime.date).getHours().toString().padStart(2, '0')+':'+new Date(schedule.startTime.date).getMinutes().toString().padStart(2, '0')} - ${new Date(schedule.endTime.date).getHours().toString().padStart(2, '0')+':'+new Date(schedule.endTime.date).getMinutes().toString().padStart(2, '0')}</span>
                                        </div>
                                    </div>
                                    <a href="/schedule/show/${schedule.id}" class="hover:underline">Ver mais detalhes</a>
                                </span>
                            `)
                            .join('')}
                    </li>
                `;
                html += scheduleHtml;
            }
        });
        html += `</div>`;
        this.container.innerHTML = html;
    }

    generate() {
        this.getSchedules()
            .then(data => {
                console.log('schedules:', data);
                if(data.length == 0){
                    this.container.innerHTML = ` <div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                        <i class='bx bxs-info-circle text-4xl'></i>
                        <span class="font-Urbanist font-semibold text-xl">Você não tem agendamentos para esta data!</span>
                    </div>`;
                }else{
                    this.generateHtml(this.generateTimes(), data);
                }
            })
            .catch(error => {
                console.error('Erro ao buscar horários:', error);
            });
    }
}
