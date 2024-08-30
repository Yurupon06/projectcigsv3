@extends('dashboard.master')
@section('title', 'Member')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'Member')
@section('page', 'Member')
@section('main')
    @include('dashboard.main')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header pb-0">
                        <h6>Member</h6>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="datatable">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Start</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">End</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $i => $member)
                                        @php
                                            $startDate = \Carbon\Carbon::now();
                                            $cycle = 30;
                                            $endDate = $startDate->copy()->addDays($cycle);
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    {{ $i + 1 . ' . ' }}
                                                </div>
                                            </td>
                                            <td>
                                                {{ $member->customer ? $member->customer->user->name : '' }}
                                            </td>
                                            <td>
                                                {{ $startDate->toDateString() }}
                                            </td>
                                            <td>
                                                {{ $endDate->toDateString() }}
                                            </td>
                                            <td style="color: {{ $member->status === 'expired' ? 'red' : ($member->status === 'active' ? 'green' : 'black') }}">
                                                {{ $member->status }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
