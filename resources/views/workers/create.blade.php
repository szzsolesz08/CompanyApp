@extends('layouts.app')
@section('title', 'Create worker')

@section('content')
<div class="container">
    <h1>Create worker</h1>
    @if ($users->find(auth()->id())['admin'] == 1)
        <p>You are admin</p>            
        <div class="mb-4">
            {{-- link ok --}}
            <a href="/"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
        </div>

        @if (Session::has('worker_created'))
            <div class="alert alert-success">Worker created successfully with the following data:
                <ul>
                    <li>Title: {{ session('title') }}</li>
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('workers.store') }}" enctype="multipart/form-data">
            @csrf


            {{-- title - ok --}}
            <div class="form-group row mb-3">

                <label for="name" class="col-sm-2 col-form-label">Name*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="email" class="col-sm-2 col-form-label">Email*</label>

                <div class="col-sm-10">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="password" class="col-sm-2 col-form-label">Password*</label>

                <div class="col-sm-10">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="admin" class="col-sm-2 col-form-label py-0">Admin*</label>
                <div class="col-sm-10">

                    <div>
                        <label class="form-check-label">
                            <input type="radio" name="admin" value="1" class="form-check-input" required> Is Admin
                        </label>
                    </div>
                    <div>
                        <label class="form-check-label">
                            <input type="radio" name="admin" value="0" class="form-check-input"> Not Admin
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="phone_number" class="col-sm-2 col-form-label">Phone number*</label>

                <div class="col-sm-10">
                    <input id="phone_number" type="tel" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number">

                    @error('phone_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">

                <label for="card_number" class="col-sm-2 col-form-label">Card number*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control  @error('card_number') is-invalid @enderror" id="card_number"
                        name="card_number" value="{{ old('card_number') }}">
                    @error('card_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="position" class="col-sm-2 col-form-label py-0">Position</label>
                <div class="col-sm-10">

                    @error('position')
                        <div>
                            <ul>
                                @foreach ($errors->get('position') as $errormsg)
                                    <li>{{ $errormsg[0] }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @enderror

                    @forelse ($positions as $position)
                        <div>
                            <label class="form-check-label">
                                <input type="radio" name="position" value="{{ $position->id }}" class="form-check-input" required> {{$position->name}}
                            </label>
                        </div>
                    @empty
                        <p>No positions found</p>
                    @endforelse
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Store</button>
            </div>
        </form>
    @else
        <p>You are not admin, you cannot create new workers.</p>  
    @endif          
                  
@endsection

@section('scripts')
<script></script>
@endsection
