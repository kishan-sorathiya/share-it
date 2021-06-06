@extends('layouts.app')
@section('title', $title)
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('File Upload') }}</div>

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
                    {!! Form::open(array('route' => 'userfiles.store','class'=>'','role'=>"form", 'files' => true)) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('userfiles') ? 'text-danger' : ''}}">
                                    {!! Html::decode(Form::label('userfiles', 'Upload Product File:<span class="has-stik">*</span>', ['class' => 'control-label'])) !!}
                                    {!! Form::file('userfiles', ['class' => 'form-control', 'required'=>false, 'id'=>'userfiles']) !!}
                                    {!! $errors->first('userfiles', '<p class="text-danger">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" onclick="location.reload()" class="btn btn-primary">Reset</button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection