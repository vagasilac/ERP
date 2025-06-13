@extends('app')

@section('title') {{ trans('Adaugă standard') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model(null, ['action' => ['SettingsController@standards_store'], 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>{{ trans('Date standard') }}</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('SettingsController@standards') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>

        </div>
        <div class="col-md-10">
            <div class="col-xs-12 col-sm-6 marginR15">
                <div class="row">
                    <div class="form-group @if ($errors->has('EN')) has-error @endif">
                        {!! Form::label('EN', 'EN' , ['class'=> 'control-label']) !!}
                        {!! Form::text('EN', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('EN'))
                            <span class="help-block">{{ $errors->first('EN') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('DIN_SEW', 'DIN/SEW', ['class'=> 'control-label']) !!}
                        {!! Form::text('DIN_SEW', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('number', trans('Număr material'), ['class'=> 'control-label']) !!}
                        {!! Form::text('number', null , ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
