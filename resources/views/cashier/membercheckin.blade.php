@extends('dashboard.master')
@section('title', 'Member Check-In')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Member Check-In')
@section('page', 'Member Check-In')
@section('main')
    @include('cashier.main')

    <div class="container-fluid py-4">
        <div class="row">
        <div class="col-12">
            <div class="card my-4">
              <div class="card-header pb-0">
                <a href="{{route('qrcheckin.cashier')}}">   
                  <span class="badge badge-sm bg-gradient-primary mb-3 fs-6 ">
                    <i class="material-icons opacity-10">qr_code_scanner</i>
                  </span>
                </a>
                        <h6>Member Check-In</h6>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div id="alerts"></div>

                        <div class="table-responsive p-0 mt-4">
                            <table class="table align-items-center mb-0" id="datatable">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Member ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Image</th>
                                    </tr>
                                </thead>
                                <tbody id="checkin-list">
                                    @foreach ($membercheckin as $i => $dt)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    {{ $i + 1 . " . " }}
                                                </div>
                                            </td>
                                            <td>
                                                {{ $dt->members->member_id }}
                                            </td>
                                            <td style="color: {{ $dt->status === 'use' ? 'red' : 'green' }}">
                                            @if ($dt->image)
                                                <img src="{{ Storage::url($dt->image) }}" alt="Member Image" style="width: 50px; height: auto;">
                                            @else
                                                No Image
                                            @endif
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

    <script>
        document.getElementById('qr_token').addEventListener('change', function())
@endsection
