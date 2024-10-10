export default class generateTimes{
    constructor(){
        this.legend = document.querySelector('#legendTimes');
        this.container = document.querySelector('#containerTimes');
    }
    setDay(day){
        this.day = day;
    }

    filterTimes(times) {
        let now = new Date(); 
        const timesFiltered = times.filter(time => {
          const timeObj = new Date(`${now.getFullYear()}-${now.getMonth() + 1}-${now.getDate()} ${time}`);
          return timeObj >= now;
        });
        return timesFiltered;
    }

    generateTimesElements(){
        let now = new Date(); 
        console.log(this.day);
        // TODO criar validacao para nao deixar buscar horarios caso o dia seja menor q o atual --- TESTAR

        console.log(parseInt(this.day) >= new Date().getDate());
        if(parseInt(this.day) >= new Date().getDate()){
            fetch(`http://localhost:8889/Schedule/getAvailableTimes/?day=${this.day}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data.morning.length);
                console.log(data.afternoon.length);
                this.container.innerHTML = '';
                this.legend.innerHTML = '';
                

                let timesHtml = document.querySelectorAll('.times');
                // timesHtml[0].classList.add('time-selected');
                console.log(timesHtml)

                if((data.morning.length != 0) || (data.afternoon.length != 0)){
                    this.legend.innerHTML = 'Horarios disponiveis';

                    if(this.day == now.getDate()){
                        data.morning = this.filterTimes(data.morning);
                        data.afternoon = this.filterTimes(data.afternoon);
                    }
        
                    let containerMorning = `<div class='w-full flex flex-col gap-2'>`;
                    let containerAfternoon = `<div class='w-full flex flex-col gap-2'>`;
                   

                    if(data.morning.length != 0){
                        containerMorning += `<h3>Manhã</h3>`;
                        containerMorning += `<div class="w-full flex gap-2 flex-wrap">`;
                        console.log(data.morning.length);
                        data.morning.forEach((time) => {
                            let timeHtml =  `
                                <label for='time${time}' class='times w-max bg-principal10 text-white font-Poppins p-2 rounded cursor-pointer'>${time}
                                    <input type='radio' name='time' value='${time}' id='time${time}' class='hidden'>
                                </label>
                            `;
                        containerMorning += timeHtml;
                        this.legend.innerHTML = 'Horarios disponiveis';
                        });
                        containerMorning += `</div>`;
                        containerMorning += `</div>`;
                    }
    
                    if(data.afternoon.length != 0){
                        containerAfternoon += `<h3>Tarde</h3>`;
                        containerAfternoon += `<div class="w-full flex gap-2 flex-wrap">`;
                        data.afternoon.forEach((time) => {
                            let timeHtml =  `
                                <label for='time${time}' class='times w-max bg-principal10 text-white font-Poppins p-2 rounded cursor-pointer'>${time}
                                    <input type='radio' name='time' value='${time}' id='time${time}' class='hidden'>
                                </label>
                            `;
                        containerAfternoon += timeHtml;
                        this.legend.innerHTML = 'Horarios disponiveis';
                        });
                        containerAfternoon += `</div>`;
                        containerAfternoon += `</div>`;
                    }

                    
                    this.container.innerHTML += containerMorning;
                    this.container.innerHTML += containerAfternoon;
                    console.log('Available times:', data);
                }else{
                    this.container.innerHTML = ` <div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                                              <i class='bx bxs-info-circle text-4xl'></i>
                                              <span class="font-Urbanist font-semibold text-xl">A empresa não tem dados suficientes para os teste4!</span>
                                          </div>`;
                }
    
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        }else{
            this.container.innerHTML = ` <div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                                      <i class='bx bxs-info-circle text-4xl'></i>
                                      <span class="font-Urbanist font-semibold text-xl">A empresa não tem dados suficientes para os graficos!</span>
                                  </div>`;
        }
    }

    init(){
        document.addEventListener('change', function(event) {
            let times = document.querySelectorAll('.times');
            if (event.target.name === 'time') {
                times.forEach(time => time.classList.remove('time-selected'));
                event.target.parentElement.classList.add('time-selected');
            }
        });

        document.querySelector('#times').addEventListener('click',(e)=>{
        console.log(times);

            e.stopPropagation();
        })
    }

    
}
