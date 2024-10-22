@extends('dashboard.master')
@section('title', isset($setting) ? $setting->app_name . ' - Report' : 'Report')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'Report')
@section('page', 'Report')
@section('main')
    @include('dashboard.main')
    @if($message = session('success'))
    <div class="alert alert-success my-2" role="alert">{{ $message }}</div>
    @endif
    <div class="container" style="height: 100vh;">
        
            @csrf
            <div class="row">
                <div class="col-auto d-flex justify-content-center">
                    <form id="reportForm" method="POST" action="{{ route('report.send') }}">
                        @csrf
                    <input type="hidden" name="filter" value="{{ $filter }}">
                    <button type="submit" class="btn btn-primary me-3" id="sendTest">Kirim Report</button>
                    </form>
                    <form id="form" method="GET" action="{{ route('report.index') }}">
                        <select name="filter" id="filter" class="form-select w-auto " onchange="document.getElementById('form').submit();">
                            <option value="Hari" {{ $filter == 'Hari' ? 'selected' : '' }}>Hari</option>
                            <option value="Minggu" {{ $filter == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                            <option value="Bulan" {{ $filter == 'Bulan' ? 'selected' : '' }}>Bulan</option>
                        </select>
                    </form>
                </div>
            </div>
        <div style="width: 100%; margin: 0 auto;">
            <canvas id="myChart"></canvas>

    
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Prepare chart data from the controller
        const chartData = {!! $chartDataJson !!};

        // Create the chart
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, chartData);
    </script>
@endsection