@extends('layouts.app')
@section('title', 'Rooms')

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h1>All rooms</h1>
        </div>
    </div>

    {{-- TODO: Session flashes --}}
    @if ($rooms->count() > 0)
    <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-self-stretch float-lg-start">
        <table id="roomsTable">
            <tr>
                <th style="text-align: center">Name</th>
                <th style="text-align: center">Positions</th>
            </tr>
            @foreach ($rooms as $room)
                    <tr>
                        <td style="text-align: center">{{$room['name']}}</td>
                        <td>
                            @if (count($position_to_rooms[$room['id']]) > 0)
                                @foreach ($position_to_rooms[$room['id']] as $position_id)
                                    <span class="positions">{{$positions->find($position_id)['name']}}</span><br>
                                @endforeach
                            @else
                                <span>No position for this room</span>
                            @endif

                        </td>
                        @if ($users->find(auth()->id())['admin'] == 1)
                            <td>
                                <a href="{{ route('rooms.edit',$room->id) }}" class="btn btn-primary">
                                    <span>Edit room</span> <i class="fas fa-angle-right"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('rooms.show',$room->id) }}" class="btn btn-primary">
                                    <span>Show room</span> <i class="fas fa-angle-right"></i>
                                </a>
                            </td>
                        @endif
                    </tr>
            @endforeach
            @if ($users->find(auth()->id())['admin'] == 1)
            <tr>
                <td>
                    <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                        <span>Create room</span> <i class="fas fa-angle-right"></i>
                    </a>
                </td>
            </tr>
            @endif
        </table>
    </div>
    @else
    <div class="col-12">
        <div class="alert alert-warning" role="alert">
            No room found!
        </div>
    </div>
    @endif
    
</div>
<style>
    #roomsTable {
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
    }

    .positions {
        border-bottom: 1px solid  black;
        white-space: nowrap;
    }
</style>
@endsection
