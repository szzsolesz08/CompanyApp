@extends('layouts.app')
@section('title', 'Workers')

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h1>All positions</h1>
        </div>
    </div>

    {{-- TODO: Session flashes --}}
    @if ($positions->count() > 0)
    <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-self-stretch float-lg-start">
        <table id="positionsTable">
            <tr>
                <th style="text-align: center">Name</th>
                <th style="text-align: center">Number of workers</th>
                <th style="text-align: center">Rooms</th>
            </tr>
            @foreach ($positions as $position)
                    <tr>
                        <td>{{$position['name']}}</td>
                        <td>{{$positions_number[$position['id']]}}</td>
                        <td>
                            @if (count($room_to_positions[$position['id']]) > 0)
                                @foreach ($room_to_positions[$position['id']] as $room_id)
                                    <span class="rooms">{{$rooms->find($room_id)['name']}}</span><br>
                                @endforeach
                            @else
                                <span>No room for this position</span>
                            @endif
                        </td>
                        @if ($users->find(auth()->id())['admin'] == 1)
                            <td>
                                <a href="{{ route('positions.edit',$position->id) }}" class="btn btn-primary">
                                    <span>Edit position</span> <i class="fas fa-angle-right"></i>
                                </a>
                            </td>
                        @endif
                        <td>
                            <a href="{{ route('positions.show',$position->id) }}" class="btn btn-primary">
                                <span>Show position</span> <i class="fas fa-angle-right"></i>
                            </a>
                        </td>
                    </tr>
            @endforeach
            @if ($users->find(auth()->id())['admin'] == 1)
            <tr>
                <td>
                    <a href="{{ route('positions.create') }}" class="btn btn-primary">
                        <span>Create position</span> <i class="fas fa-angle-right"></i>
                    </a>
                </td>
            </tr>
            @endif
        </table>
    </div>
    @else
    <div class="col-12">
        <div class="alert alert-warning" role="alert">
            No position found!
        </div>
    </div>
    @endif
    
</div>
<style>
    #positionsTable {
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

    .rooms {
        border-bottom: 1px solid  black;
        white-space: nowrap;
    }
</style>
@endsection
