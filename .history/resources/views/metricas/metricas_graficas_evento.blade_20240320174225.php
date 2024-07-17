@extends('layouts.app')

@section('content')

<div class="card">

<body>
    <div class="card-">
        <h2>Total de personas por stand</h2>
        <ul>
            @foreach($totalUsersByStand as $stand => $totalUsers)
            <li>{{ $stand }}: {{ $totalUsers }}</li>
            @endforeach
        </ul>
    </div>
    <div id="barchart">

    </div>

    <div>
        <h2>Total de personas por género</h2>
        <ul>
            <li>Mujeres: {{ $totalUsersByGender['F'] }}</li>
            <li>Hombres: {{ $totalUsersByGender['M'] }}</li>
            <li>Null: {{ $totalUsersByGender['Null'] }}</li>
        </ul>
    </div>
    <div id="piechart">

    </div>

    <div>
        <h2>Top 5 de stands más visitados</h2>
        <ul>
            @foreach($top5Stands as $stand => $visits)
            <li>{{ $stand }}: {{ $visits }}</li>
            @endforeach
        </ul>
    </div>
    <div id="top5chart">

    </div>
    <div>
        <h2>Número de personas asistentes por día</h2>
        @foreach($attendeesByDay as $date => $attendees)
        <p>{{ $date }}: {{ $attendees }}</p>
        @endforeach
    </div>
    <div id="attendeesByDayChart">

    </div>
    <div>
        <h2>Total de personas asistentes por hora</h2>

    </div>
    <div id="attendeesByHourChart">

    </div>
</body>
</html>
 </div>

@endsection


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
                    width: "20%",
                    height: 380,
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
                stroke: {
                    width: 1,
                    colors: ["#fff"]
                },
                series: [{
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

            // Opciones del gráfico de dona para total de personas por género
            var optionsPie = {
                chart: {
                    width: "100%",
                    height: 380,
                    type: "donut"
                },
                series: totalUsuariosPorGenero,
                labels: generos,
                legend: {
                    position: "bottom"
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
            var chartPie = new ApexCharts(document.querySelector("#piechart"), optionsPie);
            chartPie.render();

            // Variables para almacenar los datos para graficar el top 5 de stands más visitados
            var topStandNames = Object.keys(topStands);
            var topStandVisits = Object.values(topStands);

            // Opciones del gráfico de barras para el top 5 de stands más visitados
            var optionsTop5 = {
                chart: {
                    width: "20%",
                    height: 380,
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
                stroke: {
                    width: 1,
                    colors: ["#fff"]
                },
                series: [{
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
                    width: "20%",
                    height: 380,
                    type: "bar"
                },
                plotOptions: {
                    bar: {
                        horizontal: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 1,
                    colors: ["#fff"]
                },
                series: [{
                    data: attendees
                }],
                xaxis: {
                    categories: dates
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
                    width: "40%",
                    height: 380,
                    type: "bar"
                },
                plotOptions: {
                    bar: {
                        horizontal: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 1,
                    colors: ["#fff"]
                },
                series: [{
                    name: 'Total de personas',
                    data: visitors
                }],
                xaxis: {
                    categories: hours
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