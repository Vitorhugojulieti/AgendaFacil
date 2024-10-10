import generateDashboard from "./modules/generateDashboard.js";

const generateDashboardManager = new generateDashboard('#donut-chart','#line-chart','#column-chart');
const containerLineChart = document.querySelector('#line-chart');
const containerChart = document.querySelector('#containerChart');

async function getData(){
    const path = window.location.pathname;
    const parts = path.split('/');
    const id = parts[parts.length - 1];
    try {
        const response = await fetch(`http://localhost:8889/admin/collaborator/getDataForDashboard?idCollaborator=${id}`);
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();
        return data;
      } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
      }
}

getData().then(data => {
    console.log(data);
    if(data != 0){
        generateDashboardManager.generateLineChart(containerLineChart,data);
    }else{
        containerChart.innerHTML =`<div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                        <i class='bx bxs-info-circle text-4xl'></i>
                        <span class="font-Urbanist font-semibold text-xl">O colaborador não tem agendamentos realizados!</span>
                    </div>`;
    }
})
.catch(error => {
    // Ocorreu um erro durante a requisição
    console.error('Erro ao buscar agendamentos:', error);
});