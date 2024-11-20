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

    generateDonutChart(container, data) {
      console.log(data);
      var options = {
          chart: {
              type: 'donut',
              background: '#FFFF',
              height: 650, // Define a altura igual para ambos os gráficos
              dropShadow: {
                  enabled: false,  // Habilita a sombra
               
              },
              width: '100%'
          },
          title: {
              text: 'Serviços agendados',
              align: 'center',
              style: {
                  fontSize: '20px',
                  fontWeight: 'normal',
                  color: '#223249'
              }
          },
          dataLabels: {
              enabled: false
          },
          plotOptions: {
              pie: {
                  customScale: 0.9,
                  donut: {
                      size: '70%',
                  },
                  offsetY: 20
              },
              stroke: {
                  colors: undefined
              }
          },
          colors: ['#00D8B6', '#008FFB', '#FEB019', '#FF4560', '#775DD0'],
          series: data.series,
          labels: data.labels,
          legend: {
              position: 'right',
              offsetY: 80,
              fontSize: '16px',
          }
      };
  
      console.log(data.services);
      var chart = new ApexCharts(container, options);
      chart.render();
  }

    generateLineChart(container, data) {
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
          background: '#F8F8FF', // Fundo branco
          dropShadow: {
            enabled: false // Desabilita completamente a sombra
          },
          zoom: {
            enabled: false
          },
          toolbar: {
            show: false
          }
        },
        title: {
            text: 'Agendamentos e cancelamentos', 
            align: 'center', 
            style: {
                fontSize: '20px',
                fontWeight:'normal',
                color: '#223249'
            }
        },
        colors: ['#77B6EA', '#545454'],
        dataLabels: {
          enabled: true,
        },
        stroke: {
          curve: 'smooth'
        },
  
   
        markers: {
          size: 1
        },
        xaxis: {
          categories: [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
          ],
          title: {
            text: '',
            style: {
              color: '#333'
            }
          },
          labels: {
            style: {
              colors: '#333'
            }
          }
        },
        yaxis: {
          title: {
            text: '',
            style: {
              color: '#333'
            }
          },
          labels: {
            style: {
              colors: '#333'
            }
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
          offsetX: -5,
          fontSize: '14px',
          labels: {
            colors: '#333'
          }
        }
      };
    
      var chart = new ApexCharts(container, options);
      chart.render();
    }

    generateCombinedChart(container, data) {
      const allMonths = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
  
      function fillData(seriesData) {
          return allMonths.map(month => {
              const dataForMonth = seriesData.find(item => Object.keys(item)[0] === month);
              return dataForMonth ? Object.values(dataForMonth)[0] : 0;
          });
      }
  
      const dataSeries = [
          {
              name: 'Agendamentos',
              type: 'column',
              data: fillData(data.schedules)
          },
          {
              name: 'Cancelamentos',
              type: 'column',
              data: fillData(data.cancellations)
          }
      ];
  
      var options = {
          series: dataSeries,
          chart: {
              height: 450, // Define a altura igual para ambos os gráficos
              type: 'line',
              stacked: false,
              background: '#FFFF',
              zoom: { enabled: false },
              toolbar: { show: false },
              dropShadow: {
                  enabled: false,  // Habilita a sombra
                 
              }
          },
          title: {
              text: 'Análise de Agendamentos e Cancelamentos',
              align: 'center',
              style: {
                  fontSize: '20px',
                  fontWeight: 'normal',
                  color: '#223249'
              }
          },
          colors: ['#77B6EA', '#545454'],
          dataLabels: {
              enabled: false,
          },
          stroke: {
              width: [1, 1],
              curve: 'smooth'
          },
          xaxis: {
              categories: allMonths,
              labels: { style: { colors: '#333' } }
          },
          yaxis: [
              {
                  seriesName: 'Agendamentos',
                  axisTicks: { show: true },
                  axisBorder: {
                      show: true,
                      color: '#77B6EA'
                  },
                  labels: {
                      style: { colors: '#77B6EA' }
                  },
                  title: {
                      text: "",
                      style: { color: '#77B6EA' },
                  }
              },
              {
                  seriesName: 'Cancelamentos',
                  opposite: true,
                  axisTicks: { show: true },
                  axisBorder: {
                      show: true,
                      color: '#545454'
                  },
                  labels: {
                      style: { colors: '#545454' }
                  },
                  title: {
                      text: "",
                      style: { color: '#545454' }
                  }
              }
          ],
          tooltip: {
              fixed: {
                  enabled: true,
                  position: 'topLeft',
                  offsetY: 30,
                  offsetX: 60
              }
          },
          legend: {
              horizontalAlign: 'left',
              offsetX: 40,
              fontSize: '14px',
              labels: {
                  colors: '#333'
              }
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
        background: '#ffffff',
        dropShadow: {
          enabled: true // Desabilita a sombra
        },
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
              this.generateCombinedChart(this.containerLineChart,data.lineChart);
              // this.generateLineChart(this.containerLineChart,data.lineChart);
              // this.generateColumnChart(this.containerColumnChart,data.columnChart);
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