@extends('landing.master')
@section('title',  $setting->app_name . ' - History' ?? 'History')
@section('main')

<style>
    .text-xxs {
        font-size: 11px;
    }

    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        padding-top: 100px;
    }

    .card-item {
        width: 200px;
        margin: 10px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .card-item img {
        max-width: 100%;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card-body {
        padding: 10px;
    }

    .time-text {
        color: rgb(0, 223, 0);
        font-size: 12px;
    }
</style>

<div class="card-container">
    @foreach ($memberckin as $dt)
        <div class="card-item">
            <img src="{{ asset('storage/' . $dt->image) }}" class="img-thumbnail" alt="Member Image">
            <div class="card-body">
                <p class="time-text">{{ $dt->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y, H:i') }}</p>
            </div>
        </div>
    @endforeach
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            {{ $memberckin->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection
