// const btnReset 
const form = document.querySelector('#formReports');
const btnGenerate = document.querySelector('#btnGenerate');
const btnReset = document.querySelector('#btnReset');
const inputFilter = document.querySelector('#inputFilter');
const inputStartDate = document.querySelector('#inputStartDate');
const inputEndDate = document.querySelector('#inputEndDate');
const inputStatus = document.querySelector('#inputStatus');
const inputCollaborator = document.querySelector('#inputCollaborator');
const inputService = document.querySelector('#inputService');
const iconError = "<i class='bx bxs-info-circle' style='color:#fd837c'  ></i>";
const spanError = document.querySelector('#spanError');


inputCollaborator.disabled = true;
inputService.disabled = true;
inputFilter.addEventListener('change',(e)=>{
    if(e.target.value == 'pagamentos'){
        inputService.disabled = true;
        inputCollaborator.disabled = false;
        inputStatus.disabled = true;
    }else if(e.target.value == 'recebimentos'){
        inputCollaborator.disabled = true;
        inputService.disabled = true;
        inputStatus.disabled = true;
    }else{
        inputCollaborator.disabled = true;
        inputService.disabled = true;
        inputStatus.disabled = false;
    }
});

btnReset.addEventListener('click',(e)=>{
    inputCollaborator.disabled = true;
    inputService.disabled = true;
    inputStatus.disabled = false;
})

form.addEventListener('submit',(e)=>{
    e.preventDefault();


});

btnGenerate.addEventListener('click', function () {
    if(inputEndDate.value == '' || inputStartDate.value == ''){
        spanError.innerHTML = iconError+'Os campos data são obrigatorios!'
    }else if(new Date(inputEndDate.value) < new Date(inputStartDate.value)){
        spanError.innerHTML = iconError+'A data final deve ser maior que a inicial!'
    }else{
        const formData = new FormData();
        formData.append('filter', inputFilter.value); 
        formData.append('status', inputStatus.value);
        formData.append('startDate', inputStartDate.value);
        formData.append('endDate', inputEndDate.value);
        formData.append('service', inputService.value);
        formData.append('collaborator', inputCollaborator.value);
    
        fetch('http://localhost:8889/admin/report/store', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.pdf_url) {
                window.open(data.pdf_url, '_blank');
            }
        })
        .catch(error => console.error('Erro:', error));
    }
   
});