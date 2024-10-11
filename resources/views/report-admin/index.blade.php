@extends('dashboard.master')
@section('title', isset($setting) ? $setting->app_name . ' - Report' : 'Report')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'Report')
@section('page', 'Report')
@section('main')
    @include('dashboard.main')
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <form id="form" method="POST" action="{{route('report.send')}}">
            @csrf
            <div class="row">
                <div class="col-auto d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary me-3" id="sendTest">Kirim Report</button>
                    <select name="filter" id="filter" class="form-select w-auto">
                        <option value="Hari" {{ $filter == 'Hari' ? 'selected' : '' }}>Hari</option>
                        <option value="Minggu" {{ $filter == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                        <option value="Bulan" {{ $filter == 'Bulan' ? 'selected' : '' }}>Bulan</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

@endsection