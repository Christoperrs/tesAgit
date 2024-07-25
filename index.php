<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Summary Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .chart-container {
            display: flex;
            justify-content: space-between;
        }
        .chart {
            width: 45%;
        }
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 400px;
            font-size: 20px;
        }
        .loading img {
            width: 50px; 
            height: 50px; 
        }
    </style>
</head>
<body>
    <div class="loading" id="loading">
        <img src="https://cdn.iconscout.com/icon/free/png-256/loading-275-458018.png" alt="Loading"> Loading...
    </div>
    <div class="chart-container">
        <div class="chart">
            <canvas id="myChart1" width="400" height="400"></canvas>
        </div>
        <div class="chart">
            <canvas id="myChart2" width="400" height="400"></canvas>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "sales_summary.php",
                type: 'POST',
                dataType: 'json', 
                success: function (response) {
                  
                    $('#loading').hide();
                    
                    if (response.status === "OK") {
                        // Chart 1
                        var ctx1 = document.getElementById("myChart1").getContext("2d");
                        var myChart1 = new Chart(ctx1, {
                            type: 'line',
                            data: {
                                labels: [],
                                datasets: [{
                                    label: "Revenue By Item Group",
                                    fill: false,
                                    lineTension: 0.1,
                                    backgroundColor: "rgba(75,192,192,0.4)",
                                    borderColor: "rgba(75,192,192,1)",
                                    borderCapStyle: 'butt',
                                    borderDash: [],
                                    borderDashOffset: 0.0,
                                    borderJoinStyle: 'miter',
                                    pointBorderColor: "rgba(75,192,192,1)",
                                    pointBackgroundColor: "#fff",
                                    pointBorderWidth: 1,
                                    pointHoverRadius: 5,
                                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                                    pointHoverBorderColor: "rgba(220,220,220,1)",
                                    pointHoverBorderWidth: 2,
                                    pointRadius: 1,
                                    pointHitRadius: 10,
                                    data: [], 
                                    spanGaps: false,
                                }]
                            },
                            options: {
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Item Type'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Revenue'
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'top',
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                return tooltipItem.label + ': ' + tooltipItem.raw;
                                            }
                                        }
                                    }
                                }
                            }
                        });

                        // Chart 2
                        var ctx2 = document.getElementById("myChart2").getContext("2d");
                        var myChart2 = new Chart(ctx2, {
                            type: 'line',
                            data: {
                                labels: [],
                                datasets: [{
                                    label: "Revenue By Country",
                                    fill: false,
                                    lineTension: 0.1,
                                    backgroundColor: "rgba(153,102,255,0.4)",
                                    borderColor: "rgba(153,102,255,1)",
                                    borderCapStyle: 'butt',
                                    borderDash: [],
                                    borderDashOffset: 0.0,
                                    borderJoinStyle: 'miter',
                                    pointBorderColor: "rgba(153,102,255,1)",
                                    pointBackgroundColor: "#fff",
                                    pointBorderWidth: 1,
                                    pointHoverRadius: 5,
                                    pointHoverBackgroundColor: "rgba(153,102,255,1)",
                                    pointHoverBorderColor: "rgba(220,220,220,1)",
                                    pointHoverBorderWidth: 2,
                                    pointRadius: 1,
                                    pointHitRadius: 10,
                                    data: [], 
                                    spanGaps: false,
                                }]
                            },
                            options: {
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Country'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Revenue'
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'top',
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                return tooltipItem.label + ': ' + tooltipItem.raw;
                                            }
                                        }
                                    }
                                }
                            }
                        });

                        var labels1 = [];
                        var values1 = [];
                        var labels2 = [];
                        var values2 = [];

                        $.each(response.items, function (i, item) {
                            labels1.push(item.item); 
                            values1.push(item.revenue); 

                            if (labels2.indexOf(item.country) === -1) {
                                labels2.push(item.country); 
                                values2.push(item.revenue); 
                            } else {
                                var index = labels2.indexOf(item.country);
                                values2[index] += item.revenue;
                            }
                        });

                        myChart1.data.labels = labels1;
                        myChart1.data.datasets[0].data = values1;
                        myChart1.update();

                        myChart2.data.labels = labels2;
                        myChart2.data.datasets[0].data = values2;
                        myChart2.update();

                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    alert('AJAX Error: ' + status + ' - ' + error);
                }
            });
        });
    </script>
</body>
</html>
