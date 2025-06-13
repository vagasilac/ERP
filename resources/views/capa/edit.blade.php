@extends('app')

@section('title') {{ trans('Editare') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model($general, ['action' => ['CapasController@update', $general->id], 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header no-border col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('CapasController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <!-- Nav tabs -->
        <div class="col-xs-12">
            <ul class="nav nav-tabs" role="tablist">
                <li id="general" role="presentation" class="active"><a href="#general-container"  aria-controls="general-container" role="tab" data-toggle="tab">{{ trans('Informații generale') }}</a></li>
                @if ($general->supplier_id == null)
                    <li id="assignment" role="presentation"><a href="#assignment-container"  aria-controls="assignment-container" role="tab" data-toggle="tab">{{ trans('Atribuire') }}</a></li>
                    @if ($completed_tabs['assignment'])<li id="plan" role="presentation"><a href="#plan-container" aria-controls="plan-container" role="tab" data-toggle="tab">{{ trans('Plan') }}</a></li>@endif
                @endif
                @if ($completed_tabs['plan'])<li id="result" role="presentation"><a href="#result-container"  aria-controls="result-container" role="tab" data-toggle="tab">{{ trans('Rezultat') }}</a></li>@endif
            </ul>
        </div>

        <div class="tab-content col-xs-12 marginT30">
            <div class="tab-pane active" id="general-container" role="tabpanel">
                <div class="form-group">
                    {!! Form::label('type', trans('Tip') , ['class'=> 'control-label']) !!}
                    {!! Form::select('type', Config::get('capa.capa_form.capa_create.type'), $general->type, ['class' => 'form-control', $general->supplier_id != null ? 'disabled' : '']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('source', trans('Sursă') , ['class'=> 'control-label']) !!}
                    {!! Form::select('source', Config::get('capa.capa_form.capa_create.source'), $general->source, ['class' => 'form-control']) !!}
                </div>
                <div id="other-source" class="form-group hidden">
                    {!! Form::label('other_source', trans('Alte surse'), ['class' => 'control-label']) !!}
                    {!! Form::text('other_source', $general->other_source, ['class' => 'form-control', 'id' => 'other-source-input']) !!}
                </div>
                @if ($general->supplier_id == null)
                    <div class="form-group">
                        {!! Form::label('process_id', trans('Proces') , ['class'=> 'control-label']) !!}
                        {!! Form::select('process_id', $processes, ($general->other_process != null) ? '-1' : null, ['class' => 'form-control', 'id' => 'process']) !!}
                    </div>
                    <div id="other-process" class="form-group hidden">
                        {!! Form::label('other_process', trans('Alte proces'), ['class' => 'control-label']) !!}
                        {!! Form::text('other_process', $general->other_process, ['class' => 'form-control', 'id' => 'other-process-input']) !!}
                    </div>
                @endif
                <div class="form-group">
                    {!! Form::label('priority', trans('Prioritate') , ['class'=> 'control-label']) !!}
                    {!! Form::select('priority', Config::get('capa.capa_form.capa_create.priority'), $general->priority, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group @if ($errors->has('description')) has-error @endif">
                    {!! Form::label('description', trans('Descrieți problema sau problema în detaliu'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', $general->description, ['class' => 'form-control', 'size' => '50x3']) !!}
                    @if ($errors->has('description'))
                        <span class="help-block">{{ $errors->first('description') }}</span>
                    @endif
                </div>
            </div>
            <div class="tab-pane" id="assignment-container" role="tabpanel">
                <div class="form-group">
                    {!! Form::label('user', trans('Utilizator') , ['class' => 'control-label label-req']) !!}
                    {!! Form::text('user', !is_null($assignment->user_id) ? $assignment->user->name() : '', ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('UsersController@get_users'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'name', 'data-autocomplete-default-value' => old('secondary_responsible')]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('respond', trans('Termen limita'), ['class' => 'control-label']) !!}
                    {!! Form::text('respond', Carbon\Carbon::parse($assignment->respond)->format('d-m-Y'), ['class' => 'form-control has-datepicker']) !!}
                </div>
            </div>
            @if ($completed_tabs['assignment'])
            <div class="tab-pane" id="plan-container" role="tabpanel">
                <div class="form-group @if ($errors->has('root_cause_of_problem')) has-error @endif">
                    {!! Form::label('root_cause_of_problem', trans('Cauza principală a problemei'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('root_cause_of_problem', $plan->root_cause_of_problem, ['class' => 'form-control', 'size' => '50x3']) !!}
                    @if ($errors->has('root_cause_of_problem'))
                        <span class="help-block">{{ $errors->first('root_cause_of_problem') }}</span>
                    @endif
                </div>
                <div class="form-group @if ($errors->has('action_plan')) has-error @endif">
                    {!! Form::label('action_plan', trans('Plan de acțiune'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('action_plan', $plan->action_plan, ['class' => 'form-control', 'size' => '50x3']) !!}
                    @if ($errors->has('action_plan'))
                        <span class="help-block">{{ $errors->first('action_plan') }}</span>
                    @endif
                </div>
            </div>
            @endif
            @if ($completed_tabs['plan'])
            <div class="tab-pane" id="result-container" role="tabpanel">
                <div class="form-group">
                    {!! Form::label('result', trans('Rezultat') , ['class'=> 'control-label']) !!}
                    {!! Form::select('result', Config::get('capa.capa_form.capa_plan.result'), $result->result, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('notes_and_justification', trans('Note și justificare'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('notes_and_justification', $result->notes_and_justification, ['class' => 'form-control', 'size' => '50x3']) !!}
                </div>
            </div>
            @endif
        </div>

        {!! Form::close() !!}
    </div>
@endsection

@section('content-scripts')
    <script>
        jQuery(document).ready(function($) {
            $('#source option[value="supplier_feedback"]').addClass('hidden');
            if ("{{ $general->other_source }}" != '') {
                $('#other-source').removeClass('hidden');
            }
            if ("{{ $general->other_process }}" != '') {
                $('#other-process').removeClass('hidden');
            }
            $('#source').change(function() {
                var source = $('#source').val();
                if (source == 'other') {
                    $('#other-source').removeClass('hidden');
                }
                else {
                    $('#other-source-input').val('');
                    $('#other-source').addClass('hidden');
                }
            });
            $('#process').change(function() {
                var process = $('#process').val();
                console.log(process);
                if (process == '-1') {
                    $('#other-process').removeClass('hidden');
                }
                else {
                    $('#other-process-input').val('');
                    $('#other-process').addClass('hidden');
                }
            });
        });
    </script>
@endsection
