@section('dashboard-style')
<style>
    .custom-select {
        appearance: none;
        box-sizing: border-box;
        cursor: pointer;
        z-index: 1;
    }

    .custom-select:focus {
        outline: none;
        background-color: #fff
    }

    @media screen and (max-width: 768px) {
        .mmbr {
            margin-top: 20px;
            margin-bottom: 20px;
        }
    }
    </style>
@endsection
<div class="container-fluid mt-2">
    <div class="row">
        <div class="d-flex justify-content-end mb-2 me-4">
            <form method="GET" action="{{ route('dashboard.index') }}" id="filter-form"
                class="select-form position-relative d-flex align-items-center me-3 py-1">
                <select id="filter-select" class="custom-select border-0 bg-transparent w-100 text-sm text-end px-4"
                    name="range" onchange="this.form.submit()">
                    <option selected value="7" {{ request('range') == '7' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30" {{ request('range') == '30' ? 'selected' : '' }}>Last 30 Days</option>
                </select>
                <div class="select-icon position-absolute end-0" id="filter-icon">
                    <i class="bi bi-funnel-fill"></i>
                </div>
            </form>
        </div>
        <hr class="mb-4">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">weekend</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">{{ request('range') == '30' ? 'Monthly' : 'Weekly' }}
                            Money</p>
                        <h4 class="mb-0">Rp. {{ number_format($amountsMoney, 0, ',', '.') }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">
                        @if ($comparisonMoney <= 0)
                            <span
                                class="text-success text-sm font-weight-bolder">{{ round($amountsMoneyComparison, 2) }}%</span>
                            than {{ request('range') == '30' ? 'last month' : 'last week' }}
                        @else
                            @if ($amountsMoneyComparison < 0)
                                <span class="text-danger text-sm font-weight-bolder">
                                    {{ round($amountsMoneyComparison, 2) }}%
                                </span>
                            @elseif ($amountsMoneyComparison > 0)
                                <span class="text-success text-sm font-weight-bolder">
                                    +{{ round($amountsMoneyComparison, 2) }}%
                                </span>
                            @else
                                <span class="text-sm font-weight-bolder">No change</span>
                            @endif
                            than {{ request('range') == '30' ? 'last month' : 'last week' }}
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
                        <p class="text-sm mb-0 text-capitalize">{{ request('range') == '30' ? 'Monthly' : 'Weekly' }}
                            Users</p>
                        <h4 class="mb-0">{{ number_format($amountsUsers, 0, ',', '.') }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">
                        @if ($comparisonUser <= 0)
                            <span
                                class="text-success text-sm font-weight-bolder">{{ round($amountsUserComparison, 2) }}%</span>
                            than {{ request('range') == '30' ? 'last month' : 'last week' }}
                        @else
                            @if ($amountsUserComparison < 0)
                                <span class="text-danger text-sm font-weight-bolder">
                                    {{ round($amountsUserComparison, 2) }}%
                                </span>
                            @elseif ($amountsUserComparison > 0)
                                <span class="text-success text-sm font-weight-bolder">
                                    +{{ round($amountsUserComparison, 2) }}%
                                </span>
                            @else
                                <span class="text-sm font-weight-bolder">No change</span>
                            @endif
                            than {{ request('range') == '30' ? 'last month' : 'last week' }}
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
                        <p class="text-sm mb-0 text-capitalize">{{ request('range') == '30' ? 'Monthly' : 'Weekly' }}
                            Members</p>
                        <h4 class="mb-0">{{ number_format($amountsMembers, 0, ',', '.') }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">
                        @if ($comparisonMember <= 0)
                            <span
                                class="text-success text-sm font-weight-bolder">{{ round($amountsMemberComparison, 2) }}%</span>
                            than {{ request('range') == '30' ? 'last month' : 'last week' }}
                        @else
                            @if ($amountsMemberComparison < 0)
                                <span class="text-danger text-sm font-weight-bolder">
                                    {{ round($amountsMemberComparison, 2) }}%
                                </span>
                            @elseif ($amountsMemberComparison > 0)
                                <span class="text-success text-sm font-weight-bolder">
                                    +{{ round($amountsMemberComparison, 2) }}%
                                </span>
                            @else
                                <span class="text-sm font-weight-bolder">No change</span>
                            @endif
                            than {{ request('range') == '30' ? 'last month' : 'last week' }}
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
                        @if ($comparisonSales <= 0)
                            <span
                                class="text-success text-sm font-weight-bolder">{{ round($amountsSalesComparison, 2) }}%</span>
                            than {{ request('range') == '30' ? 'last month' : 'last week' }}
                        @else
                            @if ($amountsSalesComparison < 0)
                                <span class="text-danger text-sm font-weight-bolder">
                                    {{ round($amountsSalesComparison, 2) }}%
                                </span>
                            @elseif ($amountsSalesComparison > 0)
                                <span class="text-success text-sm font-weight-bolder">
                                    +{{ round($amountsSalesComparison, 2) }}%
                                </span>
                            @else
                                <span class="text-sm font-weight-bolder">No change</span>
                            @endif
                            than {{ request('range') == '30' ? 'last month' : 'last week' }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-4 col-md-6">
            <div class="card z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-lightblue shadow-lightblue border-radius-lg py-3 pe-1">
                        <div class="chart mt-3">
                            <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0">Orders This {{ request('range') == '30' ? 'Month' : 'Week' }}</h6>
                    <p class="text-sm">Count of orders for the last {{ $range }} days</p>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">Updated {{ $orderUpdateTime ? $orderUpdateTime->diffForHumans() : 'recently' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-lightgreen shadow-lightgreen border-radius-lg py-3 pe-1">
                        <div class="chart mt-3">
                            <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0">Payments This {{ request('range') == '30' ? 'Month' : 'Week' }}</h6>
                    <p class="text-sm">Count of payments for the last {{ $range }} days</p>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">Updated {{ $paymentUpdateTime ? $paymentUpdateTime->diffForHumans() : 'recently' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mmbr z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-lightcoral shadow-lightcoral border-radius-lg py-3 pe-1">
                        <div class="chart mt-3">
                            <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <h6 class="mb-0">Members This {{ request('range') == '30' ? 'Month' : 'Week' }}</h6>
                    <p class="text-sm">Count of members for the last {{ $range }} days</p>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">Updated {{ $memberUpdateTime ? $memberUpdateTime->diffForHumans() : 'recently' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('dashboard-script')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx1 = document.getElementById('chart-bars').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: {!! json_encode($dates) !!},
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
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const ctx2 = document.getElementById('chart-line').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: {!! json_encode($dates) !!},
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
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const ctx3 = document.getElementById('chart-line-tasks').getContext('2d');
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: {!! json_encode($dates) !!},
                datasets: [{
                    label: 'Members',
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
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
    @endsection
