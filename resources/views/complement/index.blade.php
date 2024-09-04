@extends('dashboard.master')
@section('title', 'comlement')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'comlement')
@section('page', 'comlement')
@section('main')
    @include('dashboard.main')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header pb-0">
                        <a href="{{route('complement.create')}}">
                            <span class="btn btn-sm bg-gradient-primary mb-3 fs-6 ">add new item</span>
                        </a>
                        <h6>Complement</h6>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="datatable">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">category</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">description</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">price</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">stok</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">image</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-capitalize">
                                    @foreach ($complement as $i => $dt)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    {{ $i + 1 . ' . ' }}
                                                </div>
                                            </td>
                                            <td>
                                                {{ $dt->name }}
                                            </td>
                                            <td>
                                                {{ $dt->category }}
                                            </td>
                                            @if ( strlen($dt->description) > 5)
                                                <td data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" data-bs-title="{{ $dt->description }}" style="cursor: help;">
                                                {{ substr($dt->description, 0, 5) . '...'}}
                                                </td>
                                            @else
                                                <td>{{ $dt->description }}</td>
                                            @endif
                                            <td>
                                                Rp {{ number_format($dt->price) }}
                                            </td>
                                            <td>
                                                {{ $dt->stok }}
                                            </td>
                                            <td>
                                                <img src="storage/{{ $dt->image }}" class="img-thumbnail" alt="" style="max-width: 100px; max-height: 100px;">
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <a href="{{ route('complement.edit', $dt->id) }}">
                                                    <span class="btn bg-gradient-success btn-sm">edit</span>
                                                </a>
                                                <form action="{{route('complement.destroy', $dt->id)}}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn bg-gradient-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this category?')">delete</button>
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