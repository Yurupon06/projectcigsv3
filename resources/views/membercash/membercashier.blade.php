@extends('dashboard.master')
@section('title', 'order')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'order')
@section('page', 'order')
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
                                            $startDate = \Carbon\Carbon::parse($member->order_date); 
                                            $cycle = 30; 
                                            $endDate = $startDate->copy()->addDays($cycle);
                                            $formattedStartDate = $startDate->translatedFormat('d F Y H:i');
                                            $formattedEndDate = $endDate->translatedFormat('d F Y H:i');
                                        @endphp
                                        <tr>
                                            <td class="text-center">
                                                <div class="d-flex px-2 py-1">
                                                    {{ $i + 1 }}
                                                </div>
                                            </td>
                                            <td>{{ $member->customer ? $member->customer->user->name : ''}}</td>
                                            <td>{{ $formattedStartDate }}</td>
                                            <td>{{ $formattedEndDate }}</td>
                                            <td style="color: {{ $member->status === 'unpaid' ? 'red' : ($member->status === 'paid' ? 'green' : 'black') }}">
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
