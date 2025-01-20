@extends('layouts.app')
@section('title', 'Logs')

@section('content')
<div class="container">
    <div class="row justify-content-between">
        <div class="col-12 col-md-8">
            <h1>My logs</h1>
            <h2>{{$position['name']}}</h2>
        </div>
    </div>

    {{-- TODO: Session flashes --}}
    <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-self-stretch float-lg-start">
        <table id="workersTable">
            <tr>
                <th>Date</th>
                <th>Room</th>
                <th>Successful</th>
            </tr>
            @foreach ($entries as $entry)
                @if ($user['id'] == $entry['user_id'])
                <tr>
                    <td>{{$entry['created_at']}}</td>
                    <td>{{$rooms->find($entry['room_id'])['name']}}</td>
                    <td>{{$entry['successful']}}</td>
                </tr>
                @endif
            @endforeach
        </table>
    </div>
    {{$entries->links()}}
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
