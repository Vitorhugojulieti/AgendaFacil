export default class generateDashboard{
    constructor(containerDonutChart,containerLineChart,containerColumnChart,container = null){
        this.containerDonutChart = document.querySelector(containerDonutChart);
        this.containerLineChart = document.querySelector(containerLineChart);
        this.containerColumnChart = document.querySelector(containerColumnChart);
        this.container = document.querySelector(container);
    }

    async getData(){
        try {
            const response = await fetch(`http://localhost:8889/admin/home/getDataForDashboard`);
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            const data = await response.json();
            return data;
          } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
          }
    }

    generateDonutChart(container,data){
        console.log(data);
        var options = {
            chart: {
                type: 'donut',
                width: '100%',
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
            series: data.series,
            labels: data.labels,
            legend: {
                position: 'left',
                offsetY: 80
            }
        };

        console.log(data.services);
        var chart = new ApexCharts(container, options);
        chart.render();
    }

    generateLineChart(container,data){
      const dataLine = [
        {
          name: 'Agendamentos',
          data: data.schedules.map(month => Object.values(month)[0])
        },
        {
          name: 'Cancelamentos',
          data: data.cancellations.map(month => Object.values(month)[0])
        }
      ];
  
        var options = {
            series: dataLine,
            chart: {
            height: 350,
            type: 'line',
            dropShadow: {
              enabled: true,
              color: '#000',
              top: 18,
              left: 7,
              blur: 10,
              opacity: 0.2
            },
            zoom: {
              enabled: false
            },
            toolbar: {
              show: false
            }
          },
          colors: ['#77B6EA', '#545454'],
          dataLabels: {
            enabled: true,
          },
          stroke: {
            curve: 'smooth'
          },
          title: {
            text: 'Agendamentos',
            align: 'left',
            fontSize: '18px',
            fontFamily: 'Urbanist, sans-serif', // Definindo a fonte para os rótulos de dados
            fontWeight: 300, // Definindo o peso da fonte
          },
          grid: {
            borderColor: '#e7e7e7',
            row: {
              colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
              opacity: 0.5
            },
          },
          markers: {
            size: 1
          },
          xaxis: {
            categories: [
              'Janeiro',
              'Fevereiro',
              'Março',
              'Abril',
              'Maio',
              'Junho',
              'Julho',
              'Agosto',
              'Setembro',
              'Outubro',
              'Novembro',
              'Dezembro'
            ],
            title: {
              text: 'Mêses'
            }
          },
          yaxis: {
            title: {
              text: 'Agendamentos'
            },
            min: 0,
            max: 200,
            tickAmount: 10
          },
          legend: {
            position: 'top',
            horizontalAlign: 'right',
            floating: true,
            offsetY: -25,
            offsetX: -5
          }
          };
  
          var chart = new ApexCharts(container, options);
          chart.render();
    }

    generateRandomColor() {
      return '#' + Math.floor(Math.random() * 16777215).toString(16);
    }

    generateColumnChart(container,data){
      const colors = data.map(() => this.generateRandomColor());
      var options = {
        series: [{
        data: data
      }],
        chart: {
        height: 350,
        type: 'bar',
        events: {
          click: function(chart, w, e) {
            // console.log(chart, w, e)
          }
        },
        toolbar: {
          show: false
        }
      },
      colors: colors,
      plotOptions: {
        bar: {
          columnWidth: '45%',
          distributed: true,
        }
      },
      dataLabels: {
        enabled: false
      },
      legend: {
        show: false
      },
      xaxis: {
        categories: data.map(item => (typeof item === 'object' ? item.x : item)),
        labels: {
          style: {
            colors: colors,
            fontSize: '12px'
          }
        }
      }
      };

      var chart = new ApexCharts(container, options);
      chart.render();
    }

    init(){
        this.getData().then(data => {
            console.log(data);
            if(data != 0){
              this.generateDonutChart(this.containerDonutChart,data.donutChart);
              this.generateLineChart(this.containerLineChart,data.lineChart);
              this.generateColumnChart(this.containerColumnChart,data.columnChart);
            }else{
              this.container.innerHTML =` <div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                                              <i class='bx bxs-info-circle text-4xl'></i>
                                              <span class="font-Urbanist font-semibold text-xl">A empresa não tem dados suficientes para os graficos!</span>
                                          </div>`;
            }
         

        })
        .catch(error => {
            // Ocorreu um erro durante a requisição
            console.error('Erro ao buscar agendamentos:', error);
        });
    }
}