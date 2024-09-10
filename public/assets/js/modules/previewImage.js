export default class PreviewImage {
    constructor(preview, input, icon, span, spanError) {
        this.preview = document.querySelector(preview);
        this.input = document.querySelector(input);
        this.icon = document.querySelector(icon);
        this.span = document.querySelector(span);
        this.spanError = document.querySelector(spanError);
        this.iconError = "<i class='bx bxs-info-circle' style='color:#fd837c'  ></i>";
    }

    checkType(file){
        console.log('aqui')
        const fileType = file.type;
        if(fileType === 'image/jpeg' || fileType === 'image/png' || fileType === 'image/jpg'){
            this.spanError.innerHTML = '';
            return true
        }else{
            this.spanError.innerHTML = this.iconError+'Formato invalido!, envie uma imagem nos formatos JPEG, PNG ou JPG.';
            this.input.value = '';
            return false;
        }
    }

    initializaPreview(){
        if(this.preview && this.preview.hasAttribute('src') && this.preview.getAttribute('src').trim() !== ''){
            console.log(this.preview && this.preview.hasAttribute('src') && this.preview.getAttribute('src').trim() !== '')
            this.icon.classList.remove('bx');
            this.icon.classList.add('hidden');
            this.span.classList.add('hidden');
        }else{
            this.preview.classList.add('hidden');
        }
    }

    init() {
        console.log(this.preview);
        this.initializaPreview();

        document.addEventListener('DOMContentLoaded', () => {
            this.input.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    if(this.checkType(file)){
                        const reader = new FileReader();
                        reader.onload = (e) => {
                        this.preview.classList.remove('hidden');
                        this.icon.classList.remove('bx');
                        this.icon.classList.add('hidden');
                        this.span.classList.add('hidden');
                        this.preview.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                } 
            });
        });
    }
}
