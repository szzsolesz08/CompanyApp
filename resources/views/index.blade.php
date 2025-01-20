@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="text-align: center;">{{ __('Server Side Laravel Project') }}</div>

                <div class="card-body" style="text-align: center;">
                    This project is about administration and monitoring system for an organization's simple access control system.
                </div>

                <div class="card-body">
                    Number of workers: {{$users_count}} <br>
                    Number of rooms: {{$rooms_count}}
                </div>

                <div class="card-body" style="text-align: right;">
                    This Project was created by: <br>
                    Zsolt Szabó <br>
                    GAQ4IS
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
