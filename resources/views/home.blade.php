@extends('layouts.app')
@section('title', $title)
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Home') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="form-group row mb-0 text-center">
                        <div class="col-md-12">
                            <p>This is the simple login register application with Laravel.</p>
                        </div>
                        <div class="col-md-12">
                            <a href="{{route('login')}}" class="btn btn-primary">Login</a>
                            <a href="{{route('register')}}" class="btn btn-primary">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection