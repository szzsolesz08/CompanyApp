@extends('layouts.app')
@section('title', 'Edit position')

@section('content')
<div class="container">
    <h1>Edit position</h1>
    @if ($users->find(auth()->id())['admin'] == 1)
        <p>You are admin</p>            
        <div class="mb-4">
            {{-- link ok --}}
            <a href="/"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
        </div>

        <form method="POST" action="{{ route('positions.update', $position->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group row mb-3">

                <label for="name" class="col-sm-2 col-form-label">Name*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $position->name) }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

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
