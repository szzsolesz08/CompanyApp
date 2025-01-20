@extends('layouts.app')
{{-- TODO: Post title --}}
@section('title', 'View room: ')

@section('content')
<div class="container">
    @if ($users->find(auth()->id())['admin'] == 1)
        <div class="row justify-content-between">
            <div class="col-12 col-md-8">
                {{-- TODO: Title --}}
                <h1>{{$room->name}}</h1>

                {{-- TODO: Link --}}
                <a href="/"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
            </div>
        
            <div class="col-12 col-md-4">
                <div class="float-lg-end">

                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-confirm-modal"><i class="far fa-trash-alt">
                        <span></i> Delete room</span>
                    </button>

                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="delete-confirm-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Confirm delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- TODO: Title --}}
                        Are you sure you want to delete room?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button
                            type="button"
                            class="btn btn-danger"
                            onclick="document.getElementById('delete-post-form').submit();"
                        >
                            Yes, delete this room
                        </button>

                        
                        <form id="delete-post-form" action="{{route('rooms.destroy',$room->id)}}" method="POST" class="d-none">
                            @method('DELETE')
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-self-stretch float-lg-start">
            <table id="entriesTable">
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Position</th>
                    <th>Successful</th>
                </tr>
                @foreach ($entries as $entry)
                    <tr>
                        <td>{{$entry['created_at']}}</td>
                        <td>{{$users->find($entry['user_id'])['name']}}</td>
                        <td>{{$users->find($entry['user_id'])['phone_number']}}</td>
                        <td>{{$positions->find($users->find($entry['user_id'])['position_id'])['name']}}</td>
                        <td>{{$entry['successful']}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        </div>
    @else
        <p>You are not admin, you cannot see workers.</p> 
    @endif
</div>
<style>
    #entriesTable {
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

    .positions {
        border-bottom: 1px solid  black;
        white-space: nowrap;
    }
</style>
@endsection
