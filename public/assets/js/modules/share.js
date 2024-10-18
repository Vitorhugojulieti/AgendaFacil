export default class share{
    constructor(button,modalObject){
        this.button = document.querySelector(button);
        this.modalObject = modalObject;
        this.shareData = {
            title: 'Título do link',
            text: 'Texto que descreve o link',
            url: 'https://www.exemplo.com'
          };
    }

    init(){
        this.button.addEventListener('click', async () => {
            if (navigator.share) {
              try {
                await navigator.share(this.shareData);
                console.log('Link compartilhado com sucesso');
              } catch (err) {
                console.error('Erro ao compartilhar:', err);
              }
            } else {
                console.log('pc')
                this.modalObject.openModal();
            }
          });
    }
}
