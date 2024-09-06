<div class="container-fluid py-4">
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">weekend</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Today's Money</p>
                        <h4 class="mb-0">Rp. {{ number_format($todaysMoney, 0, ',', '.') }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">
                        @if ($yesterdaysMoney <= 0)
                            <span class="text-success text-sm font-weight-bolder">{{ round($todaysMoney, 2) }}%</span>
                            than yesterday
                        @else
                            @if ($todaysMoneyComparison < 0)
                                <span class="text-danger text-sm font-weight-bolder">
                                    {{ round($todaysMoneyComparison, 2) }}%
                                </span>
                            @elseif ($todaysMoneyComparison > 0)
                                <span class="text-success text-sm font-weight-bolder">
                                    +{{ round($todaysMoneyComparison, 2) }}%
                                </span>
                            @else
                                <span class="text-sm font-weight-bolder">No change</span>
                            @endif
                            than yesterday
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Today's Users</p>
                        <h4 class="mb-0">{{ number_format($todaysUsers, 0, ',', '.') }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">
                        @if ($todaysUsers <= 0)
                            <span class="text-danger text-sm font-weight-bolder">{{ round($todaysUsers, 2) }}%</span>
                            than yesterday
                        @else
                            @if ($todaysUsersComparison < 0)
                                <span class="text-danger text-sm font-weight-bolder">
                                    {{ round($todaysUsersComparison, 2) }}%
                                </span>
                            @elseif ($todaysUsersComparison > 0)
                                <span class="text-success text-sm font-weight-bolder">
                                    +{{ round($todaysUsersComparison, 2) }}%
                                </span>
                            @else
                                <span class="text-sm font-weight-bolder">No change</span>
                            @endif
                            than yesterday
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">New Members</p>
                        <h4 class="mb-0">{{ number_format($newMembers, 0, ',', '.') }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">
                        @if ($todaysUsers <= 0)
                            <span class="text-danger text-sm font-weight-bolder">{{ round($todaysUsers, 2) }}%</span>
                            than yesterday
                        @else
                            @if ($todaysUsersComparison < 0)
                                <span class="text-danger text-sm font-weight-bolder">
                                    {{ round($todaysUsersComparison, 2) }}%
                                </span>
                            @elseif ($todaysUsersComparison > 0)
                                <span class="text-success text-sm font-weight-bolder">
                                    +{{ round($todaysUsersComparison, 2) }}%
                                </span>
                            @else
                                <span class="text-sm font-weight-bolder">No change</span>
                            @endif
                            than yesterday
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">weekend</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Total Sales</p>
                        <h4 class="mb-0">Rp. {{ number_format($totalSales, 0, ',', '.') }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">
                        @if ($yesterdaysSales <= 0)
                            <span class="text-success text-sm font-weight-bolder">{{ round($todaysSales, 2) }}%</span>
                            than yesterday
                        @else
                            @if ($salesComparison < 0)
                                <span class="text-danger text-sm font-weight-bolder">
                                    {{ round($salesComparison, 2) }}%
                                </span>
                            @elseif ($salesComparison > 0)
                                <span class="text-success text-sm font-weight-bolder">
                                    +{{ round($salesComparison, 2) }}%
                                </span>
                            @else
                                <span class="text-sm font-weight-bolder">No change</span>
                            @endif
                            than yesterday
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-lightblue shadow-lightblue border-radius-lg py-3 pe-1">
                        <div class="chart mt-3">
                            <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0">Orders This Week</h6>
                    <p class="text-sm">Count of orders for the last 7 days</p>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">Updated daily</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-lightgreen shadow-lightgreen border-radius-lg py-3 pe-1">
                        <div class="chart mt-3">
                            <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0">Payments This Week</h6>
                    <p class="text-sm">Count of payments for the last 7 days</p>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">Updated daily</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-4 mb-3">
            <div class="card z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-lightcoral shadow-lightcoral border-radius-lg py-3 pe-1">
                        <div class="chart mt-3">
                            <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0">New Members This Week</h6>
                    <p class="text-sm">Count of new members for the last 7 days</p>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">Updated daily</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFyC8IW3BswlCnpnF4wJcgk5/MPjFp4xX1pP5Vdff8Q7RxL1STeYtTcJQ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx1 = document.getElementById('chart-bars').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: {!! json_encode($datesWeekly) !!},
                datasets: [{
                    label: 'Orders',
                    data: {!! json_encode($ordersData) !!},
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
                labels: {!! json_encode($datesWeekly) !!},
                datasets: [{
                    label: 'Payments',
                    data: {!! json_encode($paymentsData) !!},
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
                labels: {!! json_encode($datesWeekly) !!},
                datasets: [{
                    label: 'New Members',
                    data: {!! json_encode($membersData) !!},
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
