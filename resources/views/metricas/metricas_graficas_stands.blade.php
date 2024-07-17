@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="content">
        <div class="card-body">
            <div class="caja-admin-grafica">
                <div class="container-titulo">
                    <h2 id="titlegraphic">Visitas al Stand</h2>
                    <h2 id="subtitlegraphic">
                        por rango de edad</h2>
                </div>
                <br>
            
                <div id="barchart" class="barchart">

                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="caja-admin-grafica">            
                <div class="container-titulo">
                <h2 id="titlegraphic">Visitas al Stand</h2>
                    <h2 id="subtitlegraphic">Día a Día</h2>
                <br>
                </div>
                <div id="barchart2" class="barchart2">
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="caja-admin-grafica">
                    <div class="container-titulo">
                        <h2 id="titlegraphic">Visitas al Stand</h2>
                            <h2 id="subtitlegraphic">por horas</h2>
                <br>

                        </div>
                    <div id="barchart3" class="barchart3">
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="caja-admin-grafica">
                <div class="container-titulo">
                    <h2 id="titlegraphic">Resultado</h2>
                        <h2 id="subtitlegraphic">de percepción del Stand</h2>
                <br>

                    </div>
                <div id="chart" class="barchart"></div>
            </div>

        </div>
    </div>
    <div class="card-body">
      <div class="caja-admin-grafica">
            <div class="container-titulo">
                <h2 id="titlegraphic">Visitas al Stand</h2>
                    <h2 id="subtitlegraphic"> por genero</h2>
                <br>

                </div>
                
    <div id="container-donutcharts">
                <div>
                <div id="donutchart"></div>
                </div>
                <div>
                <div id="donutchart2"></div>
                </div>
                <div>
                <div id="donutchart3"></div>
            </div>
    </div>
    </div>
    </div>

    </div>
</body>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof ApexCharts !== 'undefined') {
                var usersCountByAgeGroup = {!! json_encode($usersCountByAgeGroup) !!};

                var series = Object.values(usersCountByAgeGroup);
                var labels = Object.keys(usersCountByAgeGroup);
                console.log('usersCountByAgeGroup: ', usersCountByAgeGroup);
                var options = {
                    series: [{
                        name: 'Personas',
                        data: series

                    }],
                    colors: ['#8e2339'],
                    chart: {
                        width: '100%',
                        height: '300px', // Reducir la altura de la gráfica
                        type: 'bar',
                    },
                    grid: {
                        show: false
                    },
                    plotOptions: {
                        bar: {
                        },

                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: 'pattern',
                        pattern: {
                            style: 'horizontalLines', // string or array of strings
                            width: 5,
                            height: 20,
                            strokeWidth: 30
                        }
                    },
                    labels: labels,
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                initPieChart("#barchart", options);
            } else {
                console.error('ApexCharts no está definido. Asegúrate de que se haya cargado correctamente.');
            }
        });

        function initPieChart(selector, options) {
            var chart = new ApexCharts(document.querySelector(selector), options);
            chart.render();
        }
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Verifica si ApexCharts está definido
        if (typeof ApexCharts !== 'undefined') {
            var classifiedCount = {!! json_encode($classifiedCount) !!};
            console.log('classifiedCount', classifiedCount);

            // Opciones del gráfico
            var options = {
                chart: {
                    width: "100%",
                    height: 300,
                    type: "donut",
                },
                labels: ['Mujeres', 'Total'],
                dataLabels: {
                    enabled: false
                },
                plotOptions: {


                },
                grid: {
                    show: false
                },

                colors: ['#8e2339', '#dfdede'],
                states: {
                            hover: {
                            filter: {
                                type: 'none'
                              }
                            }
                        },
                series: [classifiedCount['F'],
                    classifiedCount['total']
                ],
                xaxis: {
                    axisBorder: {
                        show: true
                    },
                    axisTicks: {
                        show: true,
                    },
                    labels: {
                        show: true
                    },
                },
                legend: {
                    show: false,
                },

                responsive: [{
                    breakpoint: 1000,
                    options: {
                        plotOptions: {
                          
                        },

                    }
                }]
            };


            // Inicialización del gráfico de ApexCharts
            var chart = new ApexCharts(document.querySelector("#donutchart"), options);

            chart.render()
        } else {
            // Manejar el caso en el que ApexCharts no está definido
            console.error('ApexCharts no está definido. Asegúrate de que se haya cargado correctamente.');
        }
    });
</script>  


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Verifica si ApexCharts está definido
        if (typeof ApexCharts !== 'undefined') {
            var classifiedCount = {!! json_encode($classifiedCount) !!};
            console.log('classifiedCount', classifiedCount);

            // Opciones del gráfico
            var options = {
                chart: {
                    width: "100%",
                    height: 300,
                    type: "donut",
                },
                labels: ['Hombres', 'Total'],
                dataLabels: {
                    enabled: false
                },
                plotOptions: {


                },
                grid: {
                    show: false
                },

                colors: ['#8e2339', '#dfdede'],
                states: {
                            hover: {
                            filter: {
                                type: 'none'
                              }
                            }
                        },
                series: [classifiedCount['M'],
                    classifiedCount['total']
                ],
                xaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false
                    },
                },
                legend: {
                    show: false,
                },

                responsive: [{
                    breakpoint: 1000,
                    options: {
                        plotOptions: {
                            bar: {
                                horizontal: false
                            }
                        },

                    }
                }]
            };


            // Inicialización del gráfico de ApexCharts
            var chart = new ApexCharts(document.querySelector("#donutchart2"), options);

            chart.render()
        } else {
            // Manejar el caso en el que ApexCharts no está definido
            console.error('ApexCharts no está definido. Asegúrate de que se haya cargado correctamente.');
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Verifica si ApexCharts está definido
        if (typeof ApexCharts !== 'undefined') {
            var classifiedCount = {!! json_encode($classifiedCount) !!};
            console.log('classifiedCount', classifiedCount);

            // Opciones del gráfico
            var options = {
                chart: {
                    width: "100%",
                    height: 300,
                    type: "donut",
                },
                labels: ['No específico', 'Total'],
                dataLabels: {
                    enabled: false
                },
                plotOptions: {


                },
                grid: {
                    show: false
                },

                colors: ['#8e2339', '#dfdede'],
                states: {
                            hover: {
                            filter: {
                                type: 'none'
                              }
                            }
                        },
                series: [classifiedCount['Null'],
                    classifiedCount['total']
                ],
                xaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false
                    },
                },
                legend: {
                    show: false,
                },

                responsive: [{
                    breakpoint: 1000,
                    options: {
                        plotOptions: {
                            bar: {
                                horizontal: false
                            }
                        },

                    }
                }]
            };


            // Inicialización del gráfico de ApexCharts
            var chart = new ApexCharts(document.querySelector("#donutchart3"), options);

            chart.render()
        } else {
            // Manejar el caso en el que ApexCharts no está definido
            console.error('ApexCharts no está definido. Asegúrate de que se haya cargado correctamente.');
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Verifica si ApexCharts está definido
        if (typeof ApexCharts !== 'undefined') {

            var usersCountByDate = {!! json_encode($usersCountByDate) !!};

            var labels = Object.keys(usersCountByDate); 
            var series = Object.values(usersCountByDate); 
            
            // Convertir los datos en una matriz de objetos
            var data = [{
                name: "Visitas",
                data: labels.map((label, index) => ({ x: label, y: series[index] }))
            }];

            console.log('usersCountByDate: ',usersCountByDate);

            // Opciones del gráfico
            var options = {
                series: data,
                chart: {
                    width: "100%",
                    height: 380,
                    type: "bar",
                },
                dataLabels: {
                    enabled: false
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 25,
                        colors: {
                            backgroundBarColors: ['#F2F4F6'],
                            backgroundBarRadius: 30,
                        },
                    },                
                },
                title: {
                    text: ""
                },
                grid: {
                    show: false
                },
                colors: ['#8e2339'],
                stroke: {
                    width: 1,
                    colors: ["#fff"]
                },
                yaxis:{
                    opposite: false,
                    
                },
                
                xaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: true,
                    },
                    labels: {
                        show: true,
                        
                    },
                },
                responsive: [
                    {
                        breakpoint: 1000,
                        options: {
                            plotOptions: {
                                bar: {
                                    horizontal: false
                                }
                            },
                            legend: {
                                position: "bottom",
                                text:"Número de Personas"
                            }
                        }
                    }
                ]
            };

            var chart = new ApexCharts(document.querySelector("#barchart2"), options);
            chart.render();
        } else {
            // Manejar el caso en el que ApexCharts no está definido
            console.error('ApexCharts no está definido. Asegúrate de que se haya cargado correctamente.');
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Verifica si ApexCharts está definido
        if (typeof ApexCharts !== 'undefined') {
            var usersCountByTimeInterval = {!! json_encode($usersCountByTimeInterval) !!};

            // Convertir los datos en un array de objetos con 'x' (hora) y 'y' (conteo)
            var data = [];
            for (var intervalo in usersCountByTimeInterval) {
                if (usersCountByTimeInterval.hasOwnProperty(intervalo)) {
                    data.push({ x: intervalo, y: usersCountByTimeInterval[intervalo] });
                }
            }

            // Configuración del gráfico
            var options = {
                series: [{
                    name: "Visitas",
                    data: data
                }],
                chart: {
                    width: "100%",
                    height: 380,
                    type: "bar",
                },
                dataLabels: {
                    enabled: false
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 15,
                        colors: {
                            backgroundBarColors: ['#F2F4F6'],
                            backgroundBarRadius: 15,
                        },
                    },                
                },
                title: {
                    text: ""
                },
                grid: {
                    show: false
                },
                colors: ['#8e2339'],
                stroke: {
                    width: 1,
                    colors: ["#fff"]
                },
                yaxis: {
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: true,
                        style: {
                            fontSize: '14px',
                            fontFamily: 'Monserrat, Arial, sans-serif',
                            fontWeight: 400,
                            cssClass: 'apexcharts-xaxis-label',
                        }
                    },
                },
                xaxis: {
                    axisBorder: {
                        show: false,
                        offsetX: -10,
                        offsetY: 30
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: true,
                        style: {
                            fontSize: '14px',
                            fontFamily: 'Monserrat, Arial, sans-serif',
                            fontWeight: 400,
                            cssClass: 'apexcharts-xaxis-label',
                        }
                    },
                },
                responsive: [
                    {
                        breakpoint: 1000,
                        options: {
                            plotOptions: {
                                bar: {
                                    horizontal: false
                                }
                            },
                            legend: {
                                position: "bottom"
                            }
                        }
                    }
                ]
            };

            // Inicializar el gráfico con las opciones
            var chart = new ApexCharts(document.querySelector("#barchart3"), options);
            chart.render();
        } else {
            // Manejar el caso en el que ApexCharts no está definido
            console.error('ApexCharts no está definido. Asegúrate de que se haya cargado correctamente.');
        }
    });
</script>




<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Verifica si ApexCharts está definido
        if (typeof ApexCharts !== 'undefined') {
            // Define los datos para la gráfica
            var data = [{
                name: "Rango",
                data: [
                    @foreach ($evaluaciones as $evaluacion)
                        {
                            x: '{{ $evaluacion->criterio->name }}',
                            y: {{ $evaluacion->promedio_rank }}
                        },
                    @endforeach
                ]

            }];

            // Define las opciones de la gráfica
            var options = {
                series: data,
                chart: {
                    type: 'bar',
                    height: 380
                },
                dataLabels: {
                    enabled: true
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 45,
                        colors: {
                            backgroundBarColors: ['#F2F4F6'],
                            backgroundBarRadius: 45,
                        },

                    },

                },
                grid: {
                    show: false
                },

                colors: ['#8e2339'],

                stroke: {
                    width: 1,
                    colors: ["#fff"]
                },
                
                xaxis: {
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: true, // Esto oculta los labels del eje X
                    },
                },
                legend: {
                    show: false,
                },
                title: {
                    text:"" 
                }
            };

            // Inicialización del gráfico de ApexCharts
            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render().then(() => {
    var seriesData = chart.w.config.series[0].data;

    seriesData.forEach(function(datapoint) {
        // Verifica si el valor de y es mayor que cero antes de agregar la anotación
        if (datapoint.y > 0) {
            chart.addPointAnnotation({
                x: datapoint.y - 100,
                y: datapoint.x,
                marker: {
                    size: 35,
                    fillColor: '#FFFFFF',
                },
                label: {
                    text: '430',
                    offsetY: 45,
                    borderColor: '#FFFFFF',
                }
            });
        }
    });
});

        } else {
            // Manejar el caso en el que ApexCharts no está definido
            console.error('ApexCharts no está definido. Asegúrate de que se haya cargado correctamente.');
        }
    });
</script>
</div>
</div>
</div>

</html>
@endsection