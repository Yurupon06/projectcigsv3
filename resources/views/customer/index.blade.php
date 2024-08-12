@extends('dashboard.master')
@section('title', 'customer')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'Profile')
@section('page', 'customer')
@section('main')
    @include('dashboard.main')

      <div class="container-fluid py-4">
        <div class="row">
          <div class="col-12">
            <div class="card my-4">
              <div class="card-header pb-0">
                <h6>Profile</h6>
              </div>
                <div class="card-body px-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="datatable">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">name</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">phone</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">born</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">gender</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($customer as $i => $dt)
                              
                          
                        
                        <tr>
                          <td>
                            <div class="d-flex px-2 py-1">
                                {{ $i + 1 . " . " }}
                            </div>
                          </td>
                          <td>{{ $dt->user->name }}</td>
                          <td>
                            {{$dt->phone}}
                          </td>
                          <td>
                            {{$dt->born}}
                          </td>
                          <td>
                            {{$dt->gender}}
                          </td>
                        
                          <td class="align-middle text-center text-sm">
                            <a href="{{ route('customer.edit', $dt->id) }}"><span class="badge badge-sm bg-gradient-success">edit</span></a>
                            <form action="{{ route('customer.destroy', $dt->id) }}" method="POST" class="d-inline">
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