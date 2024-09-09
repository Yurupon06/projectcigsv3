@extends('landing.master')
@section('title', 'History')
@section('main')
    @include('landing.header')
  
<style>
    .text-xxs {
        font-size: 11px;
    }
</style>
    <div class="card-body px-0 pb-1">
        <div id="alert"></div>
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0"  id="datatable">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Qr Token</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Image</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Time</th>
                    </tr>
                </thead>
                <tbody id="checkin-list">
                    @foreach ($memberckin as $i => $dt)
                        <tr>
                          <td style="vertical-align: middle">
                              <div class="d-flex px-2 py-1">
                                  {{ $i + 1 . ' . '}}
                              </div>
                          </td>
                          <td style="vertical-align: middle">{{ $dt->member->customer->user->name }}</td>
                          <td style="vertical-align: middle">{{ $dt->member->customer->phone }}</td>
                          <td style="vertical-align: middle">{!! QrCode::size(50)->generate($dt->qr_token) !!} ({{ $dt->qr_token}})</td>
                          <td style="vertical-align: middle"><img src="{{ asset('storage/' . $dt->image) }}" class="img-thumbnail" alt="Member Image" style="max-width: 100px; max-height: 100px;"></td>
                          <td style="color: rgb(0, 223, 0); vertical-align: middle">{{ $dt->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y, H:i')  }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
