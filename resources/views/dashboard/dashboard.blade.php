@extends('layouts.app')
@section('title', $title)
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="form-group row mb-0 text-center">
                        <div class="col-md-12">
                            <h1>Welcome To User ERP</h1>
                        </div>
                        <div class="col-md-12">
                            <a href="{{route('userfiles.create')}}" class="btn btn-primary">Upload File</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection