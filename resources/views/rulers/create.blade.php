@extends('app')

@section('title') {{ trans('Adăugare') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model(null, ['action' => 'RulersController@store', 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('RulersController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <div class="tab-content col-xs-12 marginT30">
            <div class="tab-pane active row" id="output-container" role="tabpanel">
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('Name', trans('Denumire') , ['class'=> 'control-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('inventory_number', trans('Identificare'), ['class'=> 'control-label']) !!}
                        {!! Form::text('inventory_number', null , ['class' => 'form-control']) !!}
                        @if ($errors->has('inventory_number'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('measuring_range', trans('Domeniu de măsurare'), ['class'=> 'control-label']) !!}
                        {!! Form::text('measuring_range', null , ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('user', trans('Utilizator') , ['class'=> 'control-label label-req']) !!}
                        {!! Form::text('user', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('UsersController@get_users'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'name', 'data-autocomplete-default-value' => old('secondary_responsible')]) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <h4 class="marginT0">{{ trans('Photo') }}</h4>
                        {!! Form::file('photo', ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
