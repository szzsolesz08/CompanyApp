@extends('layouts.app')
@section('title', 'Create simulation')

@section('content')
<div class="container">
    <h1>Create simulation</h1>
    @if ($users->find(auth()->id())['admin'] == 1)
        <p>You are admin</p>            
        <div class="mb-4">
            {{-- link ok --}}
            <a href="/"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
        </div>

        @if (Session::has('simulation_created'))
            <div class="alert alert-success">Simulation created successfully</div>
        @endif

        <form method="POST" action="{{ route('simulation.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row mb-3">
                <label for="user" class="col-sm-2 col-form-label">Worker*</label>
                <div class="col-sm-10">
                    @foreach ($users as $user)
                        @if ($user['card_number'] !== NULL)
                            <div>
                                <label class="form-check-label">
                                    <input type="radio" name="user" value="{{$user['id']}}" class="form-check-input" required> {{$user['name']}}
                                </label>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="room" class="col-sm-2 col-form-label">Room*</label>
                <div class="col-sm-10">
                    @foreach ($rooms as $room)
                        <div>
                            <label class="form-check-label">
                                <input type="radio" name="room" value="{{$room['id']}}" class="form-check-input" required> {{$room['name']}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Store</button>
            </div>
        </form>
    @else
        <p>You are not admin, you cannot create simulation.</p>  
    @endif          
                  
@endsection

@section('scripts')
<script></script>
@endsection