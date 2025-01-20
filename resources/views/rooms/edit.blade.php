@extends('layouts.app')
@section('title', 'Edit room')

@section('content')
<div class="container">
    <h1>Edit room</h1>
    @if ($users->find(auth()->id())['admin'] == 1)
        <p>You are admin</p>            
        <div class="mb-4">
            {{-- link ok --}}
            <a href="/"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
        </div>

        <form method="POST" action="{{ route('rooms.update', $room->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Name*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $room->name) }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control  @error('description') is-invalid @enderror" id="description"
                        name="description" value="{{ old('description', $room->description) }}">
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="room_image" class="col-sm-2 col-form-label">Room image</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <input type="file" class="form-control-file @error('room_image') is-invalid @enderror" id="room_image" name="room_image">
                                @error('room_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                            <div id="room_preview" class="col-12 d-none">
                                <p>Room preview:</p>
                                <img id="room_preview_image" src="#" alt="Room preview" width="300px">
                            </div>
                        </div>
                    </div>
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
<script>
    const roomImageInput = document.querySelector('input#room_image');
    const roomPreviewContainer = document.querySelector('#room_preview');
    const roomPreviewImage = document.querySelector('img#room_preview_image');

    roomImageInput.onchange = event => {
        const [file] = roomImageInput.files;
        if (file) {
            roomPreviewContainer.classList.remove('d-none');
            roomPreviewImage.src = URL.createObjectURL(file);
        } else {
            roomPreviewContainer.classList.add('d-none');
        }
    }
</script>
@endsection
