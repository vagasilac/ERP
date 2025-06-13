@extends('app')

@section('title') {{ trans('Adăugare') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model(null, ['action' => 'InternalAuditsController@store', 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('InternalAuditsController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <div class="tab-content col-xs-12 marginT30">
            <div class="tab-pane active row" id="output-container" role="tabpanel">
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group participants-container">
                        {!! Form::label('process_id', trans('Procesul audit'), ['class' => 'control-label small-label']) !!}
                        {!! Form::text('process_id', null, ['class' => 'form-control token-input participants-input']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('date_scheduled', trans('Data programată'), ['class' => 'control-label input-with-icon']) !!}
                        {!! Form::text('date_scheduled', \Carbon\Carbon::now()->format('d-m-Y'), ['class' => 'form-control has-datepicker']) !!}
                    </div>
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

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.token-input').tokenInput('{{ action('InternalAuditsController@get_processes') }}', {
            hintText : '{{ trans( 'Introduceți termenul de căutare') }}',
            minChars : 0,
            noResultsText : '{{ trans( 'Niciun rezultat') }}',
            preventDuplicates: true,
            searchingText: '{{ trans( 'Căutare') }}...',
            tokenValue: 'id'
        });
    });
    </script>
@endsection
