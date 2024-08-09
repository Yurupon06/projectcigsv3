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
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">name</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">start</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">end</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">status</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($member as $i => $dt)
                              
                        
                        <tr>
                          <td>
                            <div class="d-flex px-2 py-1">
                                {{ $i + 1 . " . " }}
                            </div>
                          </td>
                          <td>{{ $dt->customer->user->name }}</td>
                          <td>
                            {{$dt->start_date}}
                          </td>
                          <td>
                            {{$dt->end_date}}
                          </td>
                          <td>
                            {{$dt->status}}
                          </td>
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