@extends('layouts.app')
@section('title', 'Workers')

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h1>All workers</h1>
        </div>
    </div>

    {{-- TODO: Session flashes --}}
    @if ($users->count() > 0)
    <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-self-stretch float-lg-start">
        <table id="workersTable">
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Phone number</th>
            </tr>
            @foreach ($users as $user)
            
                
                    <tr>
                        <td>{{$user['name']}}</td>
                        @if ($positions->find($user['position_id']) != NULL)
                            <td>{{$positions->find($user['position_id'])['name']}}</td>
                        @else
                            <td>No position</td>
                        @endif
                        
                        <td>{{$user['phone_number']}}</td>
                        @if ($users->find(auth()->id())['admin'] == 1)
                            <td>
                                <a href="{{ route('workers.edit',$user->id) }}" class="btn btn-primary">
                                    <span>Edit user</span> <i class="fas fa-angle-right"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('workers.show',$user->id) }}" class="btn btn-primary">
                                    <span>View user</span> <i class="fas fa-angle-right"></i>
                                </a>
                            </td>
                        @endif
                    </tr>
            @endforeach
            @if ($users->find(auth()->id())['admin'] == 1)
            <tr>
                <td>
                    <a href="{{ route('workers.create') }}" class="btn btn-primary">
                        <span>Create user</span> <i class="fas fa-angle-right"></i>
                    </a>
                </td>
            </tr>
            @endif
        </table>
    </div>
    @else
    <div class="col-12">
        <div class="alert alert-warning" role="alert">
            No users found!
        </div>
    </div>
    @endif
    
</div>
<style>
    #workersTable {
        tr {
            border-bottom: 1px solid black;
        }
        tr:last-of-type {
            border: 0;
        }
        tr:hover {
            background-color: #cccccc;
        }
        tr:first-of-type:hover {
            background-color: white;
        }
        td {
            white-space: nowrap;
            text-align: center;
        }
        th {
            white-space: nowrap;
            text-align: center;
        }
    }
</style>
@endsection
