export default class dashboard{
    constructor(){
        this.charts = [];
    }

    addChart(id, type, labels, data, options) {
        var ctx = document.getElementById(id).getContext('2d');
        var chart = new Chart(ctx, {
          type: type,
          data: {
            labels: labels,
            datasets: data
          },
          options: options
        });
        this.charts.push(chart);
      }
    
    updateCharts() {
        this.charts.forEach(chart => {
          chart.update(); // Atualiza cada gráfico
        });
    }
    
}