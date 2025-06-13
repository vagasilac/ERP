@extends('app')

@section('title') {{ trans('Adăugare') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model(null, ['action' => 'EmergencyReportsController@store', 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('EmergencyReportsController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <div class="tab-content col-xs-12 marginT30">
            <div class="tab-pane active row" id="output-container" role="tabpanel">
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('description', trans('Descrierea accidentului produs/ poluării accidentale') , ['class'=> 'control-label']) !!}
                        {!! Form::select('description', Config::get('emergency_reports.description'), null, ['class' => 'form-control', 'id' => 'description'] ) !!}
                    </div>
                    <div id="other-description" class="form-group hidden">
                        {!! Form::label('other_description', trans('Alte descrierea accidentului produs/ poluării accidentale'), ['class'=> 'control-label']) !!}
                        {!! Form::text('other_description', null, ['class' => 'form-control', 'id' => 'other-description-input']) !!}
                    </div>
                    <div class="form-group @if ($errors->has('process_date')) has-error @endif">
                        {!! Form::label('process_date', trans('Data producerii  / ora'), ['class'=> 'control-label']) !!}
                        {!! Form::text('process_date', \Carbon\Carbon::now()->format('d-m-Y H:m') , ['class' => 'form-control has-datetimepicker']) !!}
                        @if ($errors->has('process_date'))
                            <span class="help-block">{{ $errors->first('process_date') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('location')) has-error @endif">
                        {!! Form::label('location', trans('Localizarea accidentului'), ['class'=> 'control-label']) !!}
                        {!! Form::text('location', null , ['class' => 'form-control']) !!}
                        @if ($errors->has('location'))
                            <span class="help-block">{{ $errors->first('location') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('cause')) has-error @endif">
                        {!! Form::label('cause', trans('Cauza'), ['class'=> 'control-label']) !!}
                        {!! Form::textarea('cause', null , ['class' => 'form-control', 'rows' => 3]) !!}
                        @if ($errors->has('cause'))
                            <span class="help-block">{{ $errors->first('cause') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('consequenc')) has-error @endif">
                        {!! Form::label('consequenc', trans('Urmările accidentului'), ['class'=> 'control-label']) !!}
                        {!! Form::textarea('consequenc', null , ['class' => 'form-control', 'rows' => 3]) !!}
                        @if ($errors->has('consequenc'))
                            <span class="help-block">{{ $errors->first('consequenc') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('plan')) has-error @endif">
                        {!! Form::label('plan', trans('Planul de urgenţă aplicat'), ['class'=> 'control-label']) !!}
                        {!! Form::textarea('plan', null , ['class' => 'form-control', 'rows' => 3]) !!}
                        @if ($errors->has('plan'))
                            <span class="help-block">{{ $errors->first('plan') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('take_action')) has-error @endif">
                        {!! Form::label('take_action', trans('Modul de desfăşurare a acţiunilor de intervenţie / Măsuri luate'), ['class'=> 'control-label']) !!}
                        {!! Form::textarea('take_action', null , ['class' => 'form-control', 'rows' => 3]) !!}
                        @if ($errors->has('take_action'))
                            <span class="help-block">{{ $errors->first('take_action') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('intervention_team_plan')) has-error @endif">
                        {!! Form::label('intervention_team_plan', trans('Evaluarea capacităţii de răspuns a echipei de intervenţie la aplicarea planului de urgenţă'), ['class'=> 'control-label']) !!}
                        {!! Form::textarea('intervention_team_plan', null , ['class' => 'form-control', 'rows' => 3]) !!}
                        @if ($errors->has('intervention_team_plan'))
                            <span class="help-block">{{ $errors->first('intervention_team_plan') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('requirements_for_intervention')) has-error @endif">
                        {!! Form::label('requirements_for_intervention', trans('Necesarul de materiale de intervenţie şi materiale de protecţie ce trebuie înlocuite'), ['class'=> 'control-label']) !!}
                        {!! Form::textarea('requirements_for_intervention', null , ['class' => 'form-control', 'rows' => 3]) !!}
                        @if ($errors->has('requirements_for_intervention'))
                            <span class="help-block">{{ $errors->first('requirements_for_intervention') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('required_measures')) has-error @endif">
                        {!! Form::label('required_measures', trans('Măsuri necesare'), ['class'=> 'control-label']) !!}
                        {!! Form::textarea('required_measures', null , ['class' => 'form-control', 'rows' => 3]) !!}
                        @if ($errors->has('required_measures'))
                            <span class="help-block">{{ $errors->first('required_measures') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('responsibility_user', trans('Responsabilităţi') , ['class'=> 'control-label label-req']) !!}
                        {!! Form::text('responsibility_user', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('UsersController@get_users'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'name', 'data-autocomplete-default-value' => old('secondary_responsible')]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('required_measures_deadlin', trans('Termene'), ['class'=> 'control-label input-with-icon']) !!}
                        {!! Form::text('required_measures_deadlin', \Carbon\Carbon::now()->format('d-m-Y'), ['class' => 'form-control has-datepicker']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('modify_the_emergency_plan', trans('Necesitatea modificării Planului de urgenţă') , ['class'=> 'control-label']) !!}
                        {!! Form::select('modify_the_emergency_plan', Config::get('emergency_reports.modify_the_emergency_plan'), null, ['class' => 'form-control'] ) !!}
                    </div>
                    <div class="form-group @if ($errors->has('revision_responsible_emergency_plan')) has-error @endif">
                        {!! Form::label('revision_responsible_emergency_plan', trans('Responsabil revizie Plan de urgenţă'), ['class'=> 'control-label']) !!}
                        {!! Form::textarea('revision_responsible_emergency_plan', null , ['class' => 'form-control', 'rows' => 3]) !!}
                        @if ($errors->has('revision_responsible_emergency_plan'))
                            <span class="help-block">{{ $errors->first('revision_responsible_emergency_plan') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('revision_responsible_emergency_plan_deadlin', trans('Termene'), ['class'=> 'control-label input-with-icon']) !!}
                        {!! Form::text('revision_responsible_emergency_plan_deadlin', \Carbon\Carbon::now()->format('d-m-Y'), ['class' => 'form-control has-datepicker']) !!}
                    </div>
                    <h4>{{ trans('Comisie de evaluare') }}</h4>
                    <div class="comision">
                        <div class="form-group">
                            {!! Form::label('member', trans('Membru de comisie') , ['class'=> 'control-label label-req']) !!}
                            {!! Form::text('member[0]', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('UsersController@get_users'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'name', 'data-autocomplete-default-value' => old('secondary_responsible'), "data-input-name" => "member_id[]"]) !!}
                        </div>
                        <a class="text-danger no-underline remove-row" data-target=".comision"><span class="fa fa-minus-circle"></span> {{ trans('Șterge membru de comisie') }}</a>
                    </div>
                    <a class="marginB15 no-underline clone" data-target=".comision"><span class="fa fa-plus-circle"></span> {{ trans('Adaugă membru de comisie nou') }}</a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/jquery-ui-timepicker-addon.css') }}">
@endsection

@section('content-scripts')
    <script src="{{ asset('js/jquery-ui-timepicker-addon.js') }}" charset="utf-8"></script>
    <script type="text/javascript">
    jQuery(document).ready(function($) {

        initDateTimePicker();
        verification();

        $('#description').change(function() {
            verification();
        });

        function verification () {
            var description = $('#description').val();

            if (description == 'other') {
                $('#other-description').removeClass('hidden');
            }
            else {
                $('#other-description').addClass('hidden');
                $('#other-description-input').val('');
            }
        }
    });
    </script>
@endsection
