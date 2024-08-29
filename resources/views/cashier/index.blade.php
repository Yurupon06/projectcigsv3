@extends('dashboard.master')
@section('title', 'Cashier')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Cashier')
@section('page', 'Cashier')
@section('main')
    @include('cashier.main')



      <div class="container-fluid py-4">
        <div class="row">
          <div class="col-12">
            <div class="card my-4">
              <div class="card-header pb-0">
                <a href="{{ route('scanner.cashier') }}" class="d-flex align-items-center justify-content-left text-decoration-none text-white">
                  <span class="badge badge-sm bg-gradient-primary mb-3 fs-6 d-flex align-items-center justify-content-center" style="width: 120px; height: 40px;">
                    <i class="material-icons opacity-10" style="font-size: 20px; margin-right: 8px;">qr_code_scanner</i>
                    <span style="font-size: 16px;">Scanner</span>
                  </span>
                </a>
                <h6>Cashier</h6>
              </div>
                <div class="card-body px-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="datatable">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">name</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">product</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">order date</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">total amount</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">status</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($order as $i => $dt)
                              
                          
                        
                        <tr>
                          <td>
                            <div class="d-flex px-2 py-1">
                                {{ $i + 1 . " . " }}
                            </div>
                          </td>
                          <td>
                            {{ $dt->customer->user->name }}
                          </td>
                          <td>
                            {{ $dt->product->product_name }}
                          </td>
                          <td>
                            {{ \Carbon\Carbon::parse($dt->order_date)->translatedFormat('d F Y H:i') }}
                          </td>
                          <td>
                            Rp {{ number_format($dt->total_amount) }}
                          </td>
                          <td style="color: {{ $dt->status === 'unpaid' ? 'red' : ($dt->status === 'paid' ? 'green' : 'black') }}">
                            {{ $dt->status }}
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