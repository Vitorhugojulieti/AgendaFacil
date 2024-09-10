import generateDashboard from "./modules/generateDashboard.js";

const generateDashboardManager = new generateDashboard('#donut-chart','#line-chart','#column-chart');
generateDashboardManager.init();