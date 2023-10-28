@extends('layout.layout')

@section('content')
    <div class="container">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
        <x-filters :showContries='true'/>
        <div class="card">
            <div class="card-body">
                <canvas id="doughnutChart" width="800" height="400"></canvas>
            </div>
        </div>
    </div>

    <!-- Bar Chart Script -->
    <script>
        let chart;

        // Coloque os valores das porcentagens aqui
        const percentages = @json($percentages);

        function getData() {
            const ctx = document.getElementById('doughnutChart').getContext('2d');
            if (chart) {
                chart.destroy();
            }
            chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Confirmed', 'Deaths', 'Recovered', 'Active'],
                    datasets: [{
                        data: Object.values(percentages), // Use as porcentagens aqui
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'right',
                        },
                        datalabels: {
                            display: true, // Exibe os rótulos
                            color: '#fff', // Cor dos rótulos
                           // align: 'end', // Alinha os rótulos no final da fatia
                        //    anchor: 'end', // Ancora os rótulos na extremidade da fatia
                            offset: 0, // Define o deslocamento dos rótulos em relação à fatia
                            formatter: (value, context) => {
                                return value.toFixed(2) + '%';
                            },
                            font: {
                                weight: 'bold',
                            },
                        },
                    },
                }
            });
        }
        $(document).ready(function() {
            getData();
        });
    </script>
@endsection
