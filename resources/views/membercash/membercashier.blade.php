@extends('cashier.master')
@section('title', $setting->app_name . ' - Membership' ?? 'Membership')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Membership')
@section('page', 'Membership')
@section('main')
    @include('cashier.main')
    
    <style>
        @media screen and (max-width: 768px) {
                .page {
                display: none;
            }

            .input-group {
                margin-right: 8px;
            }
        }
        
    </style>

    <div class="container-fluid py-4 mt-4">
        <div class="row">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'success',
                        text: '{{ session('success') }}',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6',
                    });
                </script>
            @endif
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header pb-0 py-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-2 page">Member</h6>
                            <div class="input-group" style="max-width: 300px;">
                                <form method="GET" action="{{ route('membercashier.membercash') }}" class="d-flex w-100 pt-2">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search Members" value="{{ request('search') }}"
                                        style="border-radius: 20px 0 0 20px; height: 38px; font-size: 14px;">
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color: #ff7e00; border-radius: 0 20px 20px 0; height: 38px; padding: 0 10px; font-size: 14px;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="d-flex align-items-center my-3">
                                    <form method="GET" action="{{ route('membercashier.membercash') }}" class="d-flex">
                                        <label for="per_page" class="form-label me-2 mt-2">Show:</label>
                                        <select name="per_page" id="per_page" class="form-select form-select-sm w-auto me-3" onchange="this.form.submit()">
                                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                        </select>
                                    </form>
                                </div>
                        </div>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $i => $member)
                                        <tr style="line-height: 1.2;">
                                            <td class="text-center">
                                                <div class="d-flex px-2 py-1" style="padding: 5px 0;">
                                                    {{ ($members->currentPage() - 1) * $members->perPage() + $i + 1 . ' . ' }}
                                                </div>
                                            </td>
                                            <td style="padding: 5px 8px; ">
                                                <a href="{{ route('cashier.member', $member->id) }}"
                                                style="color: {{ $member->status === 'expired' ? 'red' : ($member->status === 'active' ? 'green' : 'black') }};
                                                text-decoration: none;
                                                font-weight:bold; ">
                                                    {{ $member->customer->user->name }}
                                                </a>
                                            </td>
                                            <td style="padding: 5px 8px; color: {{ $member->status === 'expired' ? 'red' : ($member->status === 'active' ? 'blue' : 'black') }}">
                                                {{ \Carbon\Carbon::parse($member->start_date)->translatedFormat('d F Y') }}
                                            </td>
                                            <td style="padding: 5px 8px; color: {{ $member->status === 'expired' ? 'red' : ($member->status === 'active' ? 'green' : 'black') }}">
                                                {{ \Carbon\Carbon::parse($member->end_date)->translatedFormat('d F Y') }}
                                            </td>
                                            <td style="padding: 5px 8px; ">
                                                <span style="{{ $member->visit == 0 ? 'color: red;' : '' }}">
                                                    {{ $member->visit }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                {{ $members->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
