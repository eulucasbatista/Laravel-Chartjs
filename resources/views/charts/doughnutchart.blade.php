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

        function getData() {
            $.ajax({
                url: '/doughnutchart-data',
                method: 'GET',
                dataType: 'json',
                data: {
                    'country': $("#country").val(),
                    'from': $("#from").val(),
                    'to': $("#to").val(),
                },
                success: function(data) {
                    const ctx = document.getElementById('doughnutChart').getContext('2d');
                    if (chart) {
                        chart.destroy();
                    }
                    chart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels:['Confirmed', 'Recovered', 'Active'], // Substitua pelo array de rótulos
                            datasets: [{
                                data: data.data, // Substitua pelo array de porcentagens
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.7)',
                                    'rgba(75, 192, 192, 0.7)',
                                    'rgba(54, 162, 235, 0.7)'
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
                                    color: '#fff',
                                    formatter: (value, context) => {
                                        return value.toFixed(2) + '%'; // Formata para duas casas decimais
                                    },
                                    font: {
                                        weight: 'bold',
                                    },
                                },
                            },
                        }
                    });
                },
                error: function(error) {
                    console.error('Error fetching doughnut chart data:', error);
                }
            });
        }
        $(document).ready(function() {
            getData();
        });
    </script>
@endsection
