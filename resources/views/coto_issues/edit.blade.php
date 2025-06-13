@extends('app')

@section('title') {{ trans('Editare') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model($item, ['action' => ['CotoIssuesController@update', $item->id], 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header no-border col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('CotoIssuesController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 marginR15">
            <div class="form-group @if ($errors->has('interested_party')) has-error @endif">
                {!! Form::label('interested_party', trans('Partea interesată') , ['class'=> 'control-label']) !!}
                {!! Form::text('interested_party', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('CotoPartiesController@get_coto_parties'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'interested_party', 'data-autocomplete-default-value' => old('secondary_responsible')]) !!}
                @if ($errors->has('interested_party'))
                    <span class="help-block">{{ $errors->first('interested_party') }}</span>
                @endif
            </div>
            <div class="form-group @if ($errors->has('issues_concern')) has-error @endif">
                {!! Form::label('issues_concern', trans('Probleme de îngrijorare') , ['class'=> 'control-label']) !!}
                {!! Form::text('issues_concern', null, ['class' => 'form-control']) !!}
                @if ($errors->has('issues_concern'))
                    <span class="help-block">{{ $errors->first('issues_concern') }}</span>
                @endif
            </div>
            <div class="form-group">
                {!! Form::label('bias', trans('Părtinire') , ['class'=> 'control-label']) !!}
                {!! Form::select('bias', Config::get('coto.issues.bias'), $item->bias, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group @if ($errors->has('processes')) has-error @endif">
                {!! Form::label('processes', trans('Proces') , ['class'=> 'control-label']) !!}
                {!! Form::select('processes', App\Models\Process::lists('name', 'name'), null, ['class' => 'form-control']) !!}
                @if ($errors->has('processes'))
                    <span class="help-block">{{ $errors->first('processes') }}</span>
                @endif
            </div>
            <div class="form-group">
                {!! Form::label('priority', trans('Prioritate') , ['class'=> 'control-label']) !!}
                {!! Form::select('priority', Config::get('coto.issues.priority'), $item->priority, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('treatment_method', trans('Metoda de tratament') , ['class'=> 'control-label']) !!}
                {!! Form::select('treatment_method', Config::get('coto.issues.treatment_method'), $item->treatment_method, ['class' => 'form-control', 'id' => 'treatment-method']) !!}
            </div>
            <div id="other-treatment-method" class="form-group hidden">
                {!! Form::label('other_treatment_method', trans('Metoda de tratament text') , ['class'=> 'control-label']) !!}
                {!! Form::text('other_treatment_method', null, ['class' => 'form-control', 'id' => 'other-treatment-method-input']) !!}
            </div>
            <div class="form-group @if ($errors->has('record_reference')) has-error @endif">
                {!! Form::label('record_reference', trans('Înregistrare de referință') , ['class'=> 'control-label']) !!}
                {!! Form::text('record_reference', null, ['class' => 'form-control']) !!}
                @if ($errors->has('record_reference'))
                    <span class="help-block">{{ $errors->first('record_reference') }}</span>
                @endif
            </div>
            <div class="form-group">
                {!! Form::label('user', trans('Utilizator') , ['class'=> 'control-label label-req']) !!}
                {!! Form::text('user', !is_null($item->user) ? $item->user->name() : null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('UsersController@get_users'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'name', 'data-autocomplete-default-value' => old('secondary_responsible')]) !!}
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@endsection

@section('content-scripts')
    <script>
        jQuery(document).ready(function($) {
            if ("{{ $item->other_treatment_method }}" != '') {
                $('#other-treatment-method').removeClass('hidden');
                $('#other-treatment-method').val("{{ $item->other_treatment_method }}}");
            }
            $('#treatment-method').change(function() {
                var treatment_method = $('#treatment-method').val();
                if (treatment_method == 'other') {
                    $('#other-treatment-method').removeClass('hidden');
                }
                else {
                    $('#other-treatment-method-input').val('');
                    $('#other-treatment-method').addClass('hidden');
                }
            });
        });
    </script>
@endsection