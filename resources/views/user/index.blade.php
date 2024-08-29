@extends('dashboard.master')
@section('title', 'User')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'User')
@section('page', 'User')
@section('main')
    @include('dashboard.main')

      <div class="container-fluid py-4">
        <div class="row">
          <div class="col-12">
            <div class="card my-4">
              <div class="card-header pb-0">
                <h6>User</h6>
              </div>
                <div class="card-body px-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="datatable">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">name</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">email</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">phonr</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">role</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($user as $i => $dt)
                              
                          
                        
                        <tr>
                          <td>
                            <div class="d-flex px-2 py-1">
                                {{ $i + 1 . " . " }}
                            </div>
                          </td>
                          <td>
                            {{$dt->name}}
                          </td>
                          <td>
                            {{$dt->email}}
                          </td>
                          <td>
                            {{$dt->phone}}
                          </td>
                          <td>
                            {{$dt->role}}
                          </td>
                        
                          <td class="align-middle text-center text-sm">
                            <a href="{{ route('user.edit', $dt->id) }}"><span class="btn btn-sm bg-gradient-success">edit</span></a>
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