@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="card-text">{{ __('You are logged in!') }}</p>

                    <a href="{{ url('users') }}" class="btn btn-dark">User List</a>
                    <a href="{{ url('cars') }}" class="btn btn-light">Car List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
