export default class maskInput{
    constructor(inputPhone = null, inputCpf = null, inputCep = null,inputCnpj = null){
        this.inputPhone = document.querySelector(inputPhone);
        this.inputCpf = document.querySelector(inputCpf);
        this.inputCep = document.querySelector(inputCep);
        this.inputCnpj = document.querySelector(inputCnpj);
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

    formatCnpj() {
        // Remove tudo o que não é dígito
        let cnpj = this.inputCnpj.value.replace(/\D/g, '');
        
        // Verifica se o CNPJ tem no máximo 14 dígitos
        if (cnpj.length <= 14) {
            // Aplica a máscara de CNPJ
            cnpj = cnpj.replace(/^(\d{2})(\d)/, "$1.$2");
            cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
            cnpj = cnpj.replace(/\.(\d{3})(\d)/, ".$1/$2");
            cnpj = cnpj.replace(/(\d{4})(\d)/, "$1-$2");
        }
    
        // Atualiza o valor do campo de entrada
        this.inputCnpj.value = cnpj;
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

    formatCep(){
        let cep = this.inputCep.value.replace(/\D/g, ''); 
    
        if (cep.length > 5) {
            cep = cep.replace(/^(\d{5})(\d)/, '$1-$2');
        } else {
            cep = cep.replace(/^(\d{0,5})/, '$1');
        }
    
        this.inputCep.value = cep;
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

        if(this.inputCep != null){
            this.inputCep.addEventListener('input',(e)=>{
                this.formatCep();
            })
        }

        if(this.inputCnpj != null){
            this.inputCnpj.addEventListener('input',(e)=>{
                this.formatCnpj();
            })
        }
    }
       
} 

   

