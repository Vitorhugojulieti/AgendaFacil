export default class notifications {
    constructor(display,container){
        this.display = document.querySelector(display);
        this.container = document.querySelector(container);
    }

    searchNotifications(){
        fetch('http://localhost:8889/admin/Api/getNotifications', {
          method: 'GET',
        })
        .then(response => {
          if (!response.ok) {
              throw new Error('Network response was not ok ' + response.statusText);
          }
          return response.json();
        })
        .then(data => {
          console.log(data);
          return data;
        })
        .catch(error => console.error('Erro ao buscar dados:', error));
    }

    generateNotification(data){
        const totalNotifications = 0;
        data.forEach(notification => {
            const intervalTime = this.calculateIntervalTime(notification.time);
            const notificationHtml = `<div class='w-full bg-grayNotification flex gap-4 items-center p-2 border-b border-b-grayInput'>
                            <div class='circle-notification'>
                                <i class='bx bxs-message text-2xl' style='color:#ffff'  ></i>
                            </div>
                            <div class='bodyNotification flex flex-col items-start gap-1'>
                                <span class='text-base text-black font-semibold font-Urbanist'>${notification.message}</span>
                                <span class='text-sm'>Há ${intervalTime}</span>
                                <a href='${notification.link}' class='text-sm hover:underline'>Ver detalhes</a>
                            </div>
                        </div>`;
                        
        this.container.innerHTML = notificationHtml;
        if(notification.notified === false){ totalNotifications += 1 };
        });
        this.display.innerHTML = totalNotifications;
    }

    calculateIntervalTime(){
        
        return interval;
    }

    init(){
        setInterval(()=>{
            let notifications = this.searchNotifications();
            this.generateNotification(notifications);
        },10000)
    }
}