@extends('dashboard.master')
@section('title', 'Membership Details')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Membership Detail')
@section('page', 'Membership Details')
@section('main')
    @include('cashier.main')

    <style>
        .navigation-links {
        display: flex;
        justify-content: space-between;
        }

        .navigation-links a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        .navigation-links a:hover {
            text-decoration: underline;
        }
        .change-display {
            margin-bottom: 1rem;
            text-align: right;
            font-weight: bold;
        }

        .change-display span {
            color: green;
        }
        .amount-input {
            margin-bottom: 1rem;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .amount-input input {
            width: 200px;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-left: 10px;
        }

        .amount-input label {
            font-weight: bold;
        }
    </style>



    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header pb-0 navigation-links">
                        <a href="{{ route('membercashier.membercash') }}">Back</a>
                    </div>
                    <div class="card-header pb-0">
                        <h6>Membership Details</h6>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <tr>
                                    <th>Customer Name</th>
                                    <td>{{ $member->customer->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $member->customer->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $member->customer->phone }}</td>
                                </tr>
                                @if ($member->status == 'inactive')
                                <tr>
                                    <th>Status</th>
                                    <td style="color: {{ $member->status === 'expired' ? 'red' : ($member->status === 'active' ? 'green' : 'black') }}">
                                        {{ $member->status }}
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <th>Start Date</th>
                                    <td style="color:blue">{{ \Carbon\Carbon::parse($member->start_date)->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Expired</th>
                                    <td style="color:{{ $member->status === 'expired' ? 'red' : ($member->status === 'active' ? 'green' : 'black') }}">
                                        {{ \Carbon\Carbon::parse($member->end_date)->translatedFormat('d F Y H:i') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Visit Left</th>
                                    <td style="color:{{ $member->status === 'expired' ? 'red' : ($member->status === 'active' ? 'green' : 'black') }}">
                                        {{$member->visit}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td style="color: {{ $member->status === 'expired' ? 'red' : ($member->status === 'active' ? 'green' : 'black') }}">
                                        {{ $member->status }}
                                    </td>
                                </tr>
                                @endif
                                
                                <tr>
                                    <td colspan="2">
                                        <form action="{{route('action.member', $member->id )}}" method="POST" class="text-end">
                                            @csrf
                                            @if ($member->status === 'active')
                                                <button type="submit" name="action" value="cancel" class="btn btn-danger">Cancel Membership</button>
                                            @elseif ($member->status === 'expired')
                                                <button type="submit" name="action" value="cancel" class="btn btn-danger">Cancel Membership</button>
                                                <button type="submit" name="action" value="process" class="btn btn-success">Procces Membership</button>
                                            @else
                                            <button type="submit" name="action" value="process" class="btn btn-success">Procces Membership</button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
