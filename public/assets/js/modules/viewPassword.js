export default class ViewPassword{
    constructor(){
        this.fieldPassword = document.querySelector("#inputPassword");
        this.fieldConfirmPassword = document.querySelector("#inputConfirmPassword");
        this.btnViewPassword = document.querySelector("#btnViewPassword");
        this.btnNotViewPassword = document.querySelector("#btnNotViewPassword");
        this.btnViewConfirmPassword = document.querySelector("#btnViewConfirmPassword");
        this.btnNotViewConfirmPassword = document.querySelector("#btnNotViewConfirmPassword");
    }

    init(){
        this.btnViewPassword.addEventListener('click',(e)=>{
            this.fieldPassword.type="text";
            this.btnViewPassword.style.display="none";    
            this.btnNotViewPassword.style.display="block";
        })
        
        this.btnNotViewPassword.addEventListener('click',(e)=>{
            this.fieldPassword.type="password";
            this.btnViewPassword.style.display="block";    
            this.btnNotViewPassword.style.display="none";
        })
        
        // confirm password
        if(this.fieldConfirmPassword){
            this.btnViewConfirmPassword.addEventListener('click',(e)=>{
                this.fieldConfirmPassword.type="text";
                this.btnViewConfirmPassword.style.display="none";    
                this.btnNotViewConfirmPassword.style.display="block";
            })
            
            this.btnNotViewConfirmPassword.addEventListener('click',(e)=>{
                this.fieldConfirmPassword.type="password";
                this.btnViewConfirmPassword.style.display="block";    
                this.btnNotViewConfirmPassword.style.display="none";
            })
        }
        return this;
    }
}