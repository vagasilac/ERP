@extends('app')

@section('title') {{ trans('Adăugare') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model(null, ['action' => 'ContractRegisterController@store', 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('ContractRegisterController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <div class="col-xs-12 marginT30">
            <div class="form-group @if ($errors->has('nr_date_of_contract')) has-error @endif">
                {!! Form::label('nr_date_of_contract', trans('Nr. și data contractului'), ['class' => 'control-label']) !!}
                {!! Form::text('nr_date_of_contract', null, ['class' => 'form-control']) !!}
                @if ($errors->has('nr_date_of_contract'))
                    <span class="help-block">{{ $errors->first('nr_date_of_contract') }}</span>
                @endif
            </div>
            <div class="form-group @if ($errors->has('partner')) has-error @endif">
                {!! Form::label('partner', trans('Partener'), ['class' => 'control-label']) !!}
                {!! Form::text('partner', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('ContractRegisterController@get_receivers'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'receiver_id', 'data-autocomplete-value' => 'name']) !!}
                @if ($errors->has('partner'))
                    <span class="help-block">{{ $errors->first('partner') }}</span>
                @endif
            </div>
            <div class="form-group @if ($errors->has('content')) has-error @endif">
                {!! Form::label('content', trans('Conținut'), ['class' => 'control-label']) !!}
                {!! Form::text('content', null, ['class' => 'form-control']) !!}
                @if ($errors->has('content'))
                    <span class="help-block">{{ $errors->first('content') }}</span>
                @endif
            </div>

        </div>
        {!! Form::close() !!}
    </div>
@endsection
