import dashboard from "./modules/dashboard.js";
import LineChartGenerator from './modules/lineChart.js';
import DonutChartGenerator from './modules/donutChart.js';

// const managementDashboard = new dashboard();
// managementDashboard.addChart('chart1', 'line', ['January', 'February', 'March'], [
//     {
//       label: 'Dataset 1',
//       data: [65, 59, 80],
//       backgroundColor: 'rgba(75, 192, 192, 0.2)',
//       borderColor: 'rgba(75, 192, 192, 1)',
//       borderWidth: 1
//     }
//   ], {});

//   managementDashboard.addChart('chart2', 'pie', ['Red', 'Blue', 'Yellow'], [
//     {
//       label: 'Dataset 2',
//       data: [12, 19, 3],
//       backgroundColor: 'rgba(255, 99, 132, 0.2)',
//       borderColor: 'rgba(255, 99, 132, 1)',
//       borderWidth: 1
//     }
//   ], {});

  const lineChart = new LineChartGenerator('#line-chart', [
    {
        name: "Day Time",
        data: [10, 20, 30, 40, 50, 60, 70]
    },
    {
        name: "Night Time",
        data: [5, 15, 25, 35, 45, 55, 65]
    }
], 'Customers', '168,215');
lineChart.generateLineChart();

const donutChart = new DonutChartGenerator('#donut-chart', [21, 23, 19, 14, 6], ['Clothing', 'Food Products', 'Electronics', 'Kitchen Utility', 'Gardening'], 'SERVIÇOS AGENDADOS');
donutChart.generateDonutChart();

fetch('http://localhost:8889/admin/Api/getDataForView', {
  method: 'GET',
})
.then(response => {
  if (!response.ok) {
      throw new Error('Network response was not ok ' + response.statusText);
  }
  return response.json();
})
.then(data => {
  console.log(data);
})
.catch(error => console.error('Erro ao buscar dados:', error));