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
                <a href="{{route('order.create')}}"><span class="badge badge-sm bg-gradient-primary mb-3 fs-6 ">add new item</span></a>
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
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
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
                            {{$dt->order_date}}
                          </td>
                          <td>
                            {{$dt->total_amount}}
                          </td>
                          <td>
                            {{$dt->status}}
                          </td>
                        
                          <td class="align-middle text-center text-sm">
                            <a href="{{ route('order.edit', $dt->id) }}"><span class="badge badge-sm bg-gradient-success">edit</span></a>
                            <form action="{{ route('order.destroy', $dt->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="badge badge-sm bg-gradient-danger" onclick="return confirm('Are you sure you want to delete this category?')">delete</button>
                            </form>
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