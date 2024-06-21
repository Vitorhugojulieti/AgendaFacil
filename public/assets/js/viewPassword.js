const fieldPassword = document.querySelector("#inputPassword");
const fieldConfirmPassword = document.querySelector("#inputConfirmPassword");

const btnViewPassword = document.querySelector("#btnViewPassword");
const btnNotViewPassword = document.querySelector("#btnNotViewPassword");

const btnViewConfirmPassword = document.querySelector("#btnViewConfirmPassword");
const btnNotViewConfirmPassword = document.querySelector("#btnNotViewConfirmPassword");

btnViewPassword.addEventListener('click',(e)=>{
    fieldPassword.type="text";
    btnViewPassword.style.display="none";    
    btnNotViewPassword.style.display="block";
})

btnNotViewPassword.addEventListener('click',(e)=>{
    fieldPassword.type="password";
    btnViewPassword.style.display="block";    
    btnNotViewPassword.style.display="none";
})

// confirmar sehha
if(fieldConfirmPassword){
    btnViewConfirmPassword.addEventListener('click',(e)=>{
        fieldConfirmPassword.type="text";
        btnViewConfirmPassword.style.display="none";    
        btnNotViewConfirmPassword.style.display="block";
    })
    
    btnNotViewConfirmPassword.addEventListener('click',(e)=>{
        fieldConfirmPassword.type="password";
        btnViewConfirmPassword.style.display="block";    
        btnNotViewConfirmPassword.style.display="none";
    })
}