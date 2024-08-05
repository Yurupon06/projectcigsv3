<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Gym Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    {{-- <style>
        body {
            background-color: #1a1a1a;
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
        }

        .container-fluid {
            padding-top: 2rem;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(255, 75, 43, 0.3);
            background-color: #404040;
            color: #ffffff;
        }

        .card-header {
            position: relative;
            padding: 1rem 1.5rem;
            border-radius: 10px 10px 0 0;
        }

        .card-footer {
            padding: 1rem 1.5rem;
        }

        .bg-gradient-dark {
            background: linear-gradient(45deg, #000000, #3c3c3c);
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, #ff4b2b, #ff1c1c);
        }

        .bg-gradient-success {
            background: linear-gradient(45deg, #28a745, #218838);
        }

        .bg-gradient-info {
            background: linear-gradient(45deg, #17a2b8, #117a8b);
        }

        .text-success {
            color: #28a745 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .icon {
            font-size: 2rem;
            color: #ffffff;
            border-radius: 50%;
            padding: 0.5rem;
            margin-top: -1.5rem;
        }

        .shadow-dark {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .shadow-primary {
            box-shadow: 0 4px 10px rgba(255, 75, 43, 0.2);
        }

        .shadow-success {
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
        }

        .shadow-info {
            box-shadow: 0 4px 10px rgba(23, 162, 184, 0.2);
        }

        .border-radius-xl {
            border-radius: 0.5rem;
        }

        .chart-canvas {
            background-color: #404040;
            border-radius: 10px;
        }

        .bg-gradient-lightblue {
    background: linear-gradient(to right, #a2c2e0, #d1e6f1);
    }

    .bg-gradient-lightgreen {
        background: linear-gradient(to right, #a2e0a2, #d1f1d1);
    }

    .bg-gradient-lightcoral {
        background: linear-gradient(to right, #f7a2a2, #f1d1d1);
    }

    .shadow-lightblue {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .shadow-lightgreen {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .shadow-lightcoral {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    </style> --}}
</head>

<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">weekend</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Today's Money</p>
                            <h4 class="mb-0">$53k</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Today's Users</p>
                            <h4 class="mb-0">2,300</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than last month</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">New Clients</p>
                            <h4 class="mb-0">3,462</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> than yesterday</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">weekend</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Sales</p>
                            <h4 class="mb-0">$103,430</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>than yesterday</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
    <div class="col-lg-4 col-md-6 mt-4 mb-4">
        <div class="card z-index-2">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                <div class="bg-gradient-lightblue shadow-lightblue border-radius-lg py-3 pe-1">
                    <div class="chart">
                        <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                    </div>
                </div>
            </div>
                <div class="card-body">
                    <h6 class="mb-0">Website Views</h6>
                    <p class="text-sm">Last Campaign Performance</p>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm"> campaign sent 2 days ago </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-lightgreen shadow-lightgreen border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0">Daily Sales</h6>
                    <p class="text-sm">(<span class="font-weight-bolder">+15%</span>) increase in today sales.</p>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm"> updated 4 min ago </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-4 mb-3">
            <div class="card z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-lightcoral shadow-lightcoral border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0">Completed Tasks</h6>
                    <p class="text-sm">Last Campaign Performance</p>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">just updated</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFyC8IW3BswlCnpnF4wJcgk5/MPjFp4xX1pP5Vdff8Q7RxL1STeYtTcJQ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx1 = document.getElementById('chart-bars').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
                datasets: [{
                    label: 'Website Views',
                    data: [50, 20, 10, 22, 50, 10, 40],
                    backgroundColor: 'rgb(36, 111, 154)'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx2 = document.getElementById('chart-line').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Daily Sales',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx3 = document.getElementById('chart-line-tasks').getContext('2d');
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Completed Tasks',
                    data: [20, 60, 50, 80, 90, 70, 50],
                    backgroundColor: 'rgba(255, 145, 10, 0.4)',
                    borderColor: 'rgba(255, 99, 71, 0.6)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
