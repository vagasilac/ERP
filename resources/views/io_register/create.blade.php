@extends('app')

@section('title') {{ trans('Adăugare') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model(null, ['action' => 'InputsOutputsRegisterController@store', 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('InputsOutputsRegisterController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <!-- Nav tabs -->
        <div class="col-xs-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#output-container"  aria-controls="coutput-container" role="tab" data-toggle="tab">{{ trans('Ieșire') }}</a></li>
                <li role="presentation"><a href="#input-container"  aria-controls="input-container" role="tab" data-toggle="tab">{{ trans('Rezolvare') }}</a></li>
            </ul>
        </div>

        <div class="tab-content col-xs-12 marginT30">
            <div class="tab-pane active" id="output-container" role="tabpanel">
                <h4>{{ trans('Ieșire') }}</h4>
                <div class="form-group @if ($errors->has('description')) has-error @endif">
                    {!! Form::label('description', trans('Denumire/Conținut') , ['class'=> 'control-label']) !!}
                    {!! Form::text('description', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('description'))
                        <span class="help-block">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::label('date', trans('Data ieșirii'), ['class'=> 'control-label input-with-icon']) !!}
                    {!! Form::text('date', \Carbon\Carbon::now()->format('d-m-Y'), ['class' => 'form-control has-datepicker']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('receiver', trans('Destinatar'), ['class'=> 'control-label']) !!}
                    {!! Form::text('receiver', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('InputsOutputsRegisterController@get_receivers'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'name']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('target', trans('Proiect(e) aferent(e)'), ['class'=> 'control-label small-label']) !!}
                    {!! Form::text('target', null , ['class' => 'form-control token-input']) !!}
                </div>
            </div>
            <div class="tab-pane" id="input-container" role="tabpanel">
                <h4>{{ trans('Rezolvare') }}</h4>
                <div class="form-group">
                    {!! Form::label('received_date', trans('Data rezolvării'), ['class'=> 'control-label input-with-icon']) !!}
                    {!! Form::text('received_date', null , ['class' => 'form-control has-datepicker']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('invoice_number', trans('Nr. factură'), ['class'=> 'control-label']) !!}
                    {!! Form::text('invoice_number', null , ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('notice_number', trans('Nr. aviz'), ['class'=> 'control-label']) !!}
                    {!! Form::text('notice_number', null , ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('css')
    <link href="{{ asset('css/token-input.css') }}?v={{ time() }}" rel="stylesheet" />
@endsection
@section('content-scripts')
    <script src="{{ asset('js/jquery.tokeninput.min.js') }}"></script>
    <script>
        jQuery(document).ready(function($) {
            $('.token-input').tokenInput('{{ action('InputsOutputsRegisterController@get_projects') }}', {
                hintText : '{{ trans( 'Introduceți termenul de căutare') }}',
                minChars : 0,
                noResultsText : '{{ trans( 'Niciun rezultat') }}',
                @if (!is_null(old('target')) && old('target') != '' && count($targets = explode(',', old('target'))) > 0)
                prePopulate: [
                        @foreach ($targets as $target)
                        {name: "{{ $target }}"},
                    @endforeach
                ],
                @endif
                preventDuplicates: true,
                searchingText: '{{ trans( 'Căutare') }}...',
                tokenValue: 'name'
            });
        });
    </script>
@endsection

