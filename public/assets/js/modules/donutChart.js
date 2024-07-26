export default class DonutChartGenerator {
    constructor(containerId, seriesData, labels, titleText) {
        this.containerId = containerId;
        this.seriesData = seriesData;
        this.labels = labels;
        this.titleText = titleText;
    }

    generateDonutChart() {
        var options = {
            chart: {
                type: 'donut',
                width: '70%',
                height: 400
            },
            dataLabels: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    customScale: 0.8,
                    donut: {
                        size: '75%',
                    },
                    offsetY: 20
                },
                stroke: {
                    colors: undefined
                }
            },
            colors: ['#00D8B6', '#008FFB', '#FEB019', '#FF4560', '#775DD0'], // Customize as needed
            title: {
                text: this.titleText,
                style: {
                    fontSize: '18px',
                    fontFamily: 'Urbanist, sans-serif', // Definindo a fonte para os rótulos de dados
                    fontWeight: 500, // Definindo o peso da fonte
                }
            },
            series: this.seriesData,
            labels: this.labels,
            legend: {
                position: 'left',
                offsetY: 80
            }
        };

        var chart = new ApexCharts(document.querySelector(this.containerId), options);
        chart.render();
    }
}