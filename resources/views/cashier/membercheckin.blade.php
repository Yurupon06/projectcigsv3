@extends('cashier.master')
@section('title', 'Member Check-In')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Member Check-In')
@section('page', 'Member Check-In')
@section('main')
    @include('cashier.main')

    <div class="container-fluid py-4 mt-4">
        <div class="row">
            <div class="col-md-12 d-flex">
                <div class="col-md-12 me-2" style="overflow: hidden;">
                    <div class="card my-4">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-2">Member</h6>
                                <div class="input-group mb-2" style="max-width: 300px;">
                                    <form method="GET" action="{{ route('cashier.membercheckin') }}" class="d-flex w-100">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Search Member Checkin" value="{{ request('search') }}"
                                            style="border-radius: 20px 0 0 20px; height: 38px;">
                                        <button type="submit" class="btn btn-primary"
                                            style="background-color: #ff7e00; border-radius: 0 20px 20px 0; height: 38px; padding: 0 15px;">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-1">
                            <div id="alerts"></div>
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Image</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody id="checkin-list">
                                        @forelse ($membercheckins as $i => $dt)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        {{ $i + 1 . ' . ' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $dt->member->customer->user->name }}
                                                </td>
                                                <td>
                                                    {{ substr($dt->member->customer->phone, 0, 2) . '******' . substr($dt->member->customer->phone, -4) }}
                                                </td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $dt->image) }}" class="img-thumbnail" alt="Member Image" style="max-width: 100px; max-height: 100px;">

                                                </td>
                                                
                                                <td style="color: rgb(0, 223, 0)">
                                                    {{ $dt->created_at->setTimezone('Asia/Jakarta') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    No members found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    {{ $membercheckins->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
