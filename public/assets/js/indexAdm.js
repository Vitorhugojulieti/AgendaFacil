import dashboard from "./modules/dashboard.js";

const managementDashboard = new dashboard();
managementDashboard.addChart('chart1', 'line', ['January', 'February', 'March'], [
    {
      label: 'Dataset 1',
      data: [65, 59, 80],
      backgroundColor: 'rgba(75, 192, 192, 0.2)',
      borderColor: 'rgba(75, 192, 192, 1)',
      borderWidth: 1
    }
  ], {});

  managementDashboard.addChart('chart2', 'pie', ['Red', 'Blue', 'Yellow'], [
    {
      label: 'Dataset 2',
      data: [12, 19, 3],
      backgroundColor: 'rgba(255, 99, 132, 0.2)',
      borderColor: 'rgba(255, 99, 132, 1)',
      borderWidth: 1
    }
  ], {});