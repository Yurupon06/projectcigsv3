@extends('dashboard.master')
@section('title', 'order')
@section('sidebar')
    @include('dashboard.sidebar')
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
                <a href="{{route('scanner')}}">
                  
                  <span class="btn btn-sm bg-gradient-primary mb-3 fs-6 ">
                    <i class="material-icons opacity-10">qr_code_scanner</i>
                  </span>
                </a>
                <h6>Order</h6>
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