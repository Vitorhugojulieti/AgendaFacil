import activeLoader from "./modules/activeLoader.js";

export default class CepSearch {
    constructor() {
        this.cep = document.querySelector('#inputCep');
        this.road = document.querySelector('#inputRoad');
        this.number = document.querySelector('#inputNumber');
        this.district = document.querySelector('#inputDistrict');
        this.city = document.querySelector('#inputCity');
        this.state = document.querySelector('#inputState');
        this.loader = new activeLoader();
        this.spanCep = document.querySelector('#msgCepError');
        this.iconError = "<i class='bx bxs-info-circle' style='color:#fd837c'  ></i>";
    }

    async fetchAddress() {
        this.spanCep.innerHTML = '';
        const cep = this.cep.value.replace(/[^\d]+/g, '');

        if(cep !== ''){
            this.loader.setEnabled();

            const url = `https://viacep.com.br/ws/${cep}/json/`;
            try {
                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error('CEP não encontrado');
                }
                const data = await response.json();
                if (data.erro) {
                    throw new Error('CEP não encontrado');
                }
                this.fillFields(data);
                this.loader.setDisabled();
            } catch (error) {
                this.spanCep.innerHTML = this.iconError+'Cep não encontrado!';
                this.loader.setDisabled();
            }
        }
    }

    fillFields(data) {
        this.road.value = data.logradouro || '';
        this.district.value = data.bairro || '';
        this.city.value = data.localidade || '';
        this.state.value = data.uf;
    }

}