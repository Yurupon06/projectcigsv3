@extends('landing.master')
@section('title', 'History')
@section('main')
    @include('landing.header')
  
<style>
    .text-xxs {
        font-size: 11px; /* atau ukuran lain yang diinginkan */
    }
</style>
    <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Image</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Time</th>
                    </tr>
                </thead>
                <tbody id="checkin-list">
                    @foreach ($memberckin as $i => $dt)
                        <tr>
                          <td>
                              <div class="d-flex px-2 py-1">
                                  {{ $i + 1 }}.
                              </div>
                          </td>
                          <td>{{ $dt->member->customer->user->name }}</td>
                          <td>{{ $dt->member->customer->phone }}</td>
                          <td><img src="{{ asset('storage/' . $dt->image) }}" class="img-thumbnail" alt="Member Image" style="max-width: 100px; max-height: 100px;"></td>
                          <td style="color: rgb(0, 223, 0)">{{ $dt->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y, H:i')  }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
