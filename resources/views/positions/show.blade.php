@extends('layouts.app')
{{-- TODO: Post title --}}
@section('title', 'View position: ')

@section('content')
<div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-md-8">
                {{-- TODO: Title --}}
                <h1>{{$position->name}}</h1>

                {{-- TODO: Link --}}
                <a href="/"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
            </div>
        
            <div class="col-12 col-md-4">
                <div class="float-lg-end">

                @if ($users->find(auth()->id())['admin'] == 1)
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-confirm-modal"><i class="far fa-trash-alt">
                        <span></i> Delete position</span>
                    </button>
                @endif
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
                        Are you sure you want to delete position?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button
                            type="button"
                            class="btn btn-danger"
                            onclick="document.getElementById('delete-post-form').submit();"
                        >
                            Yes, delete this position
                        </button>

                        
                        <form id="delete-post-form" action="{{route('positions.destroy',$position->id)}}" method="POST" class="d-none">
                            @method('DELETE')
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex align-self-stretch float-lg-start">
            <table id="positionsTable">
                <tr>
                    <th>Name</th>
                    <th>Phone number</th>
                </tr>
                @foreach ($users as $user)
                    @if ($user['position_id'] == $position['id'])
                        <tr>
                            <td>{{$user['name']}}</td>
                            <td>{{$user['phone_number']}}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
        </div>
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
</style>
@endsection
