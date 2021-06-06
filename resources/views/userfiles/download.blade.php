@extends('layouts.app')
@section('title', $title)
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">{{ $uuid->filename }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <label><strong>Created Date:</strong> {{\Carbon\Carbon::parse($uuid->created_at)->format('d M, Y H:i A')}}</label>
                        </div>
                        <div class="col-md-12">
                            <label><strong>Size:</strong> {{formatBytes($uuid->size)}}</label>
                        </div>
                        <div class="col-md-12">
                            <label><strong>Downloads:</strong> {{$uuid->download}}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{route('userfiles.download', [$uuid->uuid])}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Download</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection