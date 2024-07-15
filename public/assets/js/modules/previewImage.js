export default class PreviewImage {
    constructor(preview, input) {
        this.preview = document.querySelector(preview);
        this.input = document.querySelector(input);
    }

    init() {
        console.log(this.preview);
        console.log(this.input);

        document.addEventListener('DOMContentLoaded', () => {
            this.input.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                } 
            });
        });
    }
}
