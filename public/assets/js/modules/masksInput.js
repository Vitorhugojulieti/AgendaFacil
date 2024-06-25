export default class maskInput{
    constructor(inputPhone = null, inputCpf = null){
        this.inputPhone = document.querySelector(inputPhone);
        this.inputCpf = document.querySelector(inputCpf);
    }

    formatCpf(){
         // Remove tudo o que não é dígito
         let cpf = this.inputCpf.value.replace(/\D/g, '');
                
         // Verifica se o CPF tem 11 dígitos
         if (cpf.length <= 11) {
             // Aplica a máscara de CPF
             cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
             cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
             cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
         }

         // Atualiza o valor do campo de entrada
         this.inputCpf.value = cpf;
    }

    formatPhone(){
        // Remove tudo o que não é dígito
        let telefone = this.inputPhone.value.replace(/\D/g, '');
                
        // Verifica se o telefone tem 11 dígitos
        if (telefone.length <= 11) {
            // Aplica a máscara de telefone
            telefone = telefone.replace(/(\d{2})(\d)/, '($1) $2');
            telefone = telefone.replace(/(\d{5})(\d)/, '$1-$2');
        }

        // Atualiza o valor do campo de entrada
        this.inputPhone.value = telefone;
    }

    init(){
        if(this.inputCpf != null){
            this.inputCpf.addEventListener('input',(e)=>{
                this.formatCpf();
            })
        }

        if(this.inputPhone != null){
            this.inputPhone.addEventListener('input',(e)=>{
                this.formatPhone();
            })
        }
    }
       
} 

   

