export default class sender{
    constructor(inputsData){
        this.inputs = inputsData;
        this.data = [];
    }

    initializeInputs(){
        let inputsHtml = [];
        this.inputs.forEach(input => {
            inputsHtml.push(document.querySelector(input));
        });
        return inputsHtml;
    }

    getData(inputs){
        inputs.forEach(input => {
            let attributeName = input.getAttribute('name');
            let value = input.value;
            this.data.push({name: attributeName, value: value})
        });
    }


    sendInputs(){
        this.init();
        console.log(this.data)
        $.ajax({
            url: "http://localhost:8889/admin/voucher/saveDataVoucher/", // Arquivo PHP que processará os dados
            method: "POST",
            data: JSON.stringify(this.data),
            contentType: "application/json",
            success: function(data){
                console.log(data);
            }
        });
    }

    init(){
        this.getData(this.initializeInputs());
    }
}