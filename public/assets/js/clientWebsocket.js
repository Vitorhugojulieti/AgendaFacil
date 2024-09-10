import io from 'socket.io-client';
export default class clientWebsocket{
    constructor(){

    }

    async getUserId() {
        try {
            const response = await fetch('http://localhost:8889/admin/Api/getDataForView');
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Erro ao obter ID do usuário:', error);
            return null;
        }
    }

 
    async initWebsocket(){
        const userId = await this.getUserId();
        if (!userId) {
            console.error('ID do usuário não disponível');
            return;
        }
    
        const socket = io('http://localhost:8080');
    
        socket.on('connect', () => {
            console.log('Conectado ao servidor WebSocket');
            socket.emit('subscribe', userId);
        });
    
        socket.on('notifications', notifications => {
            const notificationsList = document.getElementById('notifications');
            notifications.forEach(notification => {
                const listItem = document.createElement('li');
                listItem.textContent = notification.message;
                notificationsList.appendChild(listItem);
            });
        });
    
        socket.on('disconnect', () => {
            console.log('Desconectado do servidor WebSocket');
        });
    
        socket.on('error', error => {
            console.error('Erro WebSocket:', error);
        });
    }

    init(){
        window.onload = this.initWebsocket();
    }
}