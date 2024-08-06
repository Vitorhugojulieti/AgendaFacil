export default class generateTimes{
    constructor(){
        this.legend = document.querySelector('#legendTimes');
    }
    setDay(day){
        this.day = day;
    }

    generateTimesElements(){
        console.log(this.day);
        fetch(`http://localhost:8889/Schedule/getAvailableTimes/?day=${this.day}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const container = document.querySelector('#containerTimes');
            container.innerHTML = '';
            this.legend.innerHTML = '';

            data.forEach((time) => {
                let timeHtml =  `<div class='times w-12 bg-principal10 text-white font-Poppins p-2 rounded'>
                    <label for='time${time}' class='hover:cursor-pointer'>${time}</label>
                    <input type='radio' name='time' value='${time}' id='time${time}' class='hidden'>
                </div>`;
            container.innerHTML += timeHtml;
            this.legend.innerHTML = 'Horarios disponiveis';
            });
            console.log('Available times:', data);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }

    init(){
        document.addEventListener('change', function(event) {
            if (event.target.name === 'time') {
                const times = document.querySelectorAll('.times');
                times.forEach(time => time.classList.remove('time-selected'));
                event.target.parentElement.classList.add('time-selected');
            }
        });
    }

    
}