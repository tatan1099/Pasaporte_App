@extends('layouts.app')

@section('content')

<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="card-body">
        <div class="caja-admin-graficasSTands">
            <div class="container-titulo">
                <h2 id="titlegraphic">Total de personas</h2>
                    <h2 id="subtitlegraphic"> por stand</h2>
                <br>
                </div>
            <div id="barchart"></div>

        </div>
    </div>

    <div class="card-body">
        <div class="caja-admin-graficasSTands">
            <div class="container-titulo">
                <h2 id="titlegraphic">Visitas al Evento</h2>
                    <h2 id="subtitlegraphic"> por genero</h2>
                <br>

                </div>
                <div id="container-donutcharts">
          
                    <div id="donutchart"></div>
                    <div id="donutchart2"></div>
                    <div id="donutchart3"></div>
         </div>
    </div>
  

    <div class="card-body">
        <div class="caja-admin-graficasSTands">
            <div class="container-titulo">
                <h2 id="titlegraphic">Top 5 de stands </h2>
                    <h2 id="subtitlegraphic"> más visitados</h2>
                <br>

                </div>
            <div id="top5chart"></div>

        </div>
    </div>

    <div class="card-body">
        <div class="caja-admin-graficasSTands">
            <div class="container-titulo">
                <h2 id="titlegraphic">Número de personas asistentes </h2>
                    <h2 id="subtitlegraphic"> por día</h2>
                <br>

                </div>
            <div id="attendeesByDayChart"></div>
        </div>
    </div>
    
    <div class="card-body">
        <div class="caja-admin-graficasSTands">
            <div class="container-titulo">
                <h2 id="titlegraphic">Total de personas asistentes</h2>
                    <h2 id="subtitlegraphic">por hora</h2>
                <br>
                </div>
            <div id="attendeesByHourChart"></div>
        </div>
    </div>

</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Verifica si ApexCharts está definido
        if (typeof ApexCharts !== 'undefined') {
            // Se obtienen los datos proporcionados por el controlador desde la vista de Blade
            var totalUsersByStand = {!! json_encode($totalUsersByStand) !!};
            var totalUsersByGender = {!! json_encode($totalUsersByGender) !!};
            var topStands = {!! json_encode($top5Stands) !!};
            var attendeesByDay = {!! json_encode($attendeesByDay) !!};
            var hours = {!! json_encode(array_keys($attendeesByHour)) !!};
            var visitors = {!! json_encode(array_values($attendeesByHour)) !!};

            // Variables para almacenar los nombres de los stands y el total de usuarios
            var nombresStands = Object.keys(totalUsersByStand);
            var totalUsuariosPorStand = Object.values(totalUsersByStand);

            // Opciones del gráfico de barras para total de personas por stand
            var optionsBar = {
                chart: {
                    width: '100%',
                    height: '300px',
                    type: "bar"
                },
                colors: ['#8e2339'],
                plotOptions: {
                    bar: {
                    }
                },
                grid: {
                        show: false
                    },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 1,
                    colors: ["#fff"]
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
                series: [{
                    name:'Personas',
                    data: totalUsuariosPorStand
                }],
                xaxis: {
                    categories: nombresStands
                },
                legend: {
                    show: false
                },
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        plotOptions: {
                            bar: {
                                horizontal: false
                            }
                        },
                        legend: {
                            show: true,
                            position: "bottom"
                        }
                    }
                }]
            };

            // Inicialización del gráfico de barras para total de personas por stand
            var chartBar = new ApexCharts(document.querySelector("#barchart"), optionsBar);
            chartBar.render();

            // Variables para almacenar los datos para graficar el total de personas por género
            var generos = Object.keys(totalUsersByGender);
            var totalUsuariosPorGenero = Object.values(totalUsersByGender);
            console.log('totalUsersByGender', totalUsersByGender);


            // Opciones del gráfico de dona para total de personas por género
            var optionsdonutchart = {
                chart: {
                    width: "100%",
                    height: 300,
                    type: "donut"
                },
                series: [totalUsersByGender['F'],totalUsersByGender['total']],
                labels: ['Mujeres', 'Total'],
                colors: ['#8e2339', '#dfdede'],
                dataLabels: {
                    enabled: false
                },
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
                states: {
                            hover: {
                            filter: {
                                type: 'none'
                              }
                            }
                        },
             
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        legend: {
                            position: "bottom"
                        }
                    }
                }]
            };

            // Inicialización del gráfico de dona para total de personas por género
            var donutchart = new ApexCharts(document.querySelector("#donutchart"), optionsdonutchart);
            donutchart.render();



            // Variables para almacenar los datos para graficar el total de personas por género
            var generos = Object.keys(totalUsersByGender);
            var totalUsuariosPorGenero = Object.values(totalUsersByGender);

            // Opciones del gráfico de dona para total de personas por género
            var optionsdonutchart2 = {
                chart: {
                    width: "100%",
                    height: 300,
                    type: "donut"
                },
                dataLabels: {
                    enabled: false
                },
                series: [totalUsersByGender['M'],totalUsersByGender['total']],
                labels: ['Hombres', 'Total'],
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
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        legend: {
                            position: "bottom"
                        }
                    }
                }]
            };

            // Inicialización del gráfico de dona para total de personas por género
            var donutchart1 = new ApexCharts(document.querySelector("#donutchart2"), optionsdonutchart2);
            donutchart1.render();


            // Variables para almacenar los datos para graficar el total de personas por género
            var generos = Object.keys(totalUsersByGender);
            var totalUsuariosPorGenero = Object.values(totalUsersByGender);

            // Opciones del gráfico de dona para total de personas por género
            var optionsdonutchart3 = {
                chart: {
                    width: "100%",
                    height: 300,
                    type: "donut"
                },
                series: [totalUsersByGender['Null'],totalUsersByGender['total']],
                labels: ['No especifico', 'Total'],
                dataLabels: {
                    enabled: false
                },
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
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        legend: {
                            position: "bottom"
                        }
                    }
                }]
            };

            // Inicialización del gráfico de dona para total de personas por género
            var donutchart2 = new ApexCharts(document.querySelector("#donutchart3"), optionsdonutchart3);
            donutchart2.render();

            // Variables para almacenar los datos para graficar el top 5 de stands más visitados
            var topStandNames = Object.keys(topStands);
            var topStandVisits = Object.values(topStands);
            console.log('topStands:',topStands);

            // Opciones del gráfico de barras para el top 5 de stands más visitados
            var optionsTop5 = {
                chart: {
                    width: '100%',
                     height: '300px',
                    type: "bar"
                },
                plotOptions: {
                    bar: {
                        vertical: true
                    }
                },
                dataLabels: {
                    enabled: false
                },
                colors: ['#8e2339'],
                series: [{
                    name:'Visitas',
                    data: topStandVisits
                }],
                xaxis: {
                    categories: topStandNames
                },
                legend: {
                    show: false
                },
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        plotOptions: {
                            bar: {
                                horizontal: false
                            }
                        },
                        legend: {
                            show: true,
                            position: "bottom"
                        }
                    }
                }]
            };

            // Inicialización del gráfico de barras para el top 5 de stands más visitados
            var chartTop5 = new ApexCharts(document.querySelector("#top5chart"), optionsTop5);
            chartTop5.render();

            // Variables para almacenar los datos para graficar el número de personas asistentes por día
            var dates = Object.keys(attendeesByDay);
            var attendees = Object.values(attendeesByDay);

            // Opciones del gráfico de barras para el número de personas asistentes por día
            var optionsAttendeesByDay = {
                chart: {
                    width: '100%',
                     height: '300px',
                    type: "bar"
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 12,
                        colors: {
                            backgroundBarColors: ['#F2F4F6'],
                            backgroundBarRadius: 20,
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
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 1,
                    colors: ["#fff"]
                },
                series: [{
                    name:'Asistentes',
                    data: attendees
                }],
                xaxis: {
                    categories: dates,
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
                legend: {
                    show: false
                },
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        plotOptions: {
                            bar: {
                                horizontal: true
                            }
                        },
                        legend: {
                            show: true,
                            position: "bottom"
                        }
                    }
                }]
            };

            // Inicialización del gráfico de barras para el número de personas asistentes por día
            var chartAttendeesByDay = new ApexCharts(document.querySelector("#attendeesByDayChart"), optionsAttendeesByDay);
            chartAttendeesByDay.render();

            // Opciones del gráfico de barras para el total de personas asistentes por hora
            var optionsAttendeesByHour = {
                chart: {
                    width: '100%',
                     height: '300px',
                    type: "bar"
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 12,
                        colors: {
                            backgroundBarColors: ['#F2F4F6'],
                            backgroundBarRadius: 15,
                        },
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 1,
                    colors: ["#fff"]
                },
                grid: {
                    show: false
                },
                colors: ['#8e2339'],
                stroke: {
                    width: 1,
                    colors: ["#fff"]
                },
                series: [{
                    name: 'Total de personas',
                    data: visitors
                }],
              
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
                    categories: hours,
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
                legend: {
                    show: false
                },
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        plotOptions: {
                            bar: {
                                horizontal: true
                            }
                        },
                        legend: {
                            show: true,
                            position: "bottom"
                        }
                    }
                }]
            };

            // Inicialización del gráfico de barras para el total de personas asistentes por hora
            var chartAttendeesByHour = new ApexCharts(document.querySelector("#attendeesByHourChart"), optionsAttendeesByHour);
            chartAttendeesByHour.render();
        } else {
            // Manejar el caso en el que ApexCharts no está definido
            console.error('ApexCharts no está definido. Asegúrate de que se haya cargado correctamente.');
        }
    });
</script>

@endsection

