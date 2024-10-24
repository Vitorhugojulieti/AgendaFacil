export default class formValidate{
    constructor(){
        this.emailRegex = /^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[A-Za-z]+$/;
        this.cpfRegex = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
        this.phoneRegex = /^\(\d{2}\) \d{5}-\d{4}$/;
        this.passwordRegex = /^(?=.*[!@#$%^&*(),.?":{}|<>])(?=.*\d).{8,}$/;
        this.cepRegex = /^[0-9]{5}-?[0-9]{3}$/;
    }

    isEmailValid(value){
        return this.emailRegex.test(value);
    }

    isCpfValid(value){
        return this.cpfRegex.test(value);
    }

    isPhoneValid(value){
        return this.phoneRegex.test(value);
    }

    isEmpty(value){
        return value.trim() === "";
    }

    isEqualValues(value1,value2){
        return value1 == value2;
    }

    isPasswordValid(value){
        return this.passwordRegex.test(value);
    }

    filesIsNotEmpty(input){
        return input.files.length > 0;
    }

    isCepValid(value){
        return this.cepRegex.test(value);
    }

    isCnpjValid(cnpj) {
        // Regex to validate CNPJ format (99.999.999/9999-99)
        const regex = /^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/;
        
        // First, validate the format with punctuation
        if (!regex.test(cnpj)) {
            return false;
        }
    
        // Remove non-numeric characters for further validation
        cnpj = cnpj.replace(/[^\d]+/g,'');
    
        if (cnpj.length != 14)
            return false;
    
        // Eliminate known invalid CNPJs
        if (["00000000000000", "11111111111111", "22222222222222", "33333333333333", 
             "44444444444444", "55555555555555", "66666666666666", "77777777777777", 
             "88888888888888", "99999999999999"].includes(cnpj)) {
            return false;
        }
    
        // Validate check digits
        var size = cnpj.length - 2;
        var numbers = cnpj.substring(0, size);
        var digits = cnpj.substring(size);
        var sum = 0;
        var pos = size - 7;
        for (var i = size; i >= 1; i--) {
            sum += numbers.charAt(size - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        var result = sum % 11 < 2 ? 0 : 11 - sum % 11;
        if (result != digits.charAt(0))
            return false;
    
        size = size + 1;
        numbers = cnpj.substring(0, size);
        sum = 0;
        pos = size - 7;
        for (var i = size; i >= 1; i--) {
            sum += numbers.charAt(size - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        result = sum % 11 < 2 ? 0 : 11 - sum % 11;
        if (result != digits.charAt(1))
            return false;
    
        return true;
    }
}