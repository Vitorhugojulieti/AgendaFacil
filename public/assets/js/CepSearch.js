export default class CepSearch {
    constructor() {
        this.cep = document.querySelector('#inputCep');
        this.road = document.querySelector('#inputRoad');
        this.number = document.querySelector('#inputNumber');
        this.district = document.querySelector('#inputDistrict');
        this.city = document.querySelector('#inputCity');
        this.state = document.querySelector('#inputState');
    }

    async fetchAddress() {
        const cep = this.cep.value.replace(/[^\d]+/g, '');

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
        } catch (error) {
            this.showError(error.message);
        }
    }

    fillFields(data) {
        this.number.value = data.logradouro || '';
        // this.fields.bairro.value = data.bairro || '';
        this.city.value = data.localidade || '';
        this.state.value = data.uf || '';
        // this.errorSpan.textContent = '';
    }

    showError(message) {
        this.errorSpan.textContent = message;
    }
}