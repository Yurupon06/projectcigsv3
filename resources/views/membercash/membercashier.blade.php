@extends('dashboard.master')
@section('title', 'Membership')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Membership')
@section('page', 'Membership')
@section('main')
    @include('cashier.main')

    <div class="container-fluid py-4">
        <div class="row">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
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
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Visit</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($member as $i => $member)
                                        <tr>
                                            <td class="text-center">
                                                <div class="d-flex px-2 py-1">
                                                    {{ $i + 1 . " . " }}
                                                </div>
                                            </td>
                                            <td>{{ $member->customer->user->name}}</td>
                                            <td style="color:{{ $member->status === 'inactive' ? 'red' : ($member->status === 'active' ? 'blue' : 'black') }}">
                                                {{ \Carbon\Carbon::parse($member->start_date)->translatedFormat('d F Y') }}
                                            </td>
                                            <td style="color:{{ $member->status === 'expired' ? 'red' : ($member->status === 'active' ? 'green' : 'red') }}">
                                                {{ \Carbon\Carbon::parse($member->end_date)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>{{$member->visit}}</td>
                                            <td style="color: {{ $member->status === 'expired' ? 'red' : ($member->status === 'active' ? 'green' : 'black') }}">
                                                {{ $member->status }}
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <a href="{{ route('cashier.member', $member->id) }}">
                                                <span class="btn bg-gradient-info ws-15 my-4 mb-2 btn-sm">Detail</span>
                                                </a>
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
