@extends('app')

@section('title') {{ trans('Raportul de audit intern') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model(null, ['action' => ['InternalAuditReportsController@store', $internal_audit->id], 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header no-border col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('InternalAuditsController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <!-- Nav tabs -->
        <div class="col-xs-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#planning-container"  aria-controls="planning-container" role="tab" data-toggle="tab">{{ trans('Planificare') }}</a></li>
                <li role="presentation"><a href="#checking-documentation-container"  aria-controls="checking-documentation-container" role="tab" data-toggle="tab">{{ trans('Verificarea documentației') }}</a></li>
                <li role="presentation"><a href="#audit-container" aria-controls="audit-container" role="tab" data-toggle="tab">{{ trans('Audit') }}</a></li>
                <li role="presentation"><a href="#review-report-container" aria-controls="review-report-container" role="tab" data-toggle="tab">{{ trans('Revizuirea raportului') }}</a></li>
            </ul>
        </div>

        <div class="tab-content col-xs-12 marginT30">
            <div class="tab-pane active" id="planning-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    <div class="form-group">
                        {!! Form::label('audit_nr', trans('Audit'), ['class' => 'control-label']) !!}
                        {!! Form::text('audit_nr', $internal_audit->audit, ['class' => 'form-control', 'disabled']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('process_names', trans('Procese'), ['class' => 'control-label']) !!}
                        {!! Form::text('process_names', $internal_audit->get_process_names(), ['class' => 'form-control', 'disabled']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('auditor', trans('Auditor'), ['class' => 'control-label']) !!}
                        {!! Form::text('auditor', null, ['class' => 'form-control has-combobox required', 'data-autocomplete-src' => action('UsersController@get_users'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'name']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('audited_people', trans('Persoane auditate'), ['class' => 'control-label small-label']) !!}
                        {!! Form::text('audited_people', null, [
                            'class' => 'form-control token-input required',
                            'data-autocomplete-src' => action('InternalAuditReportsController@get_roles'),
                            'data-options' => '{
                                "hintText": "Introduceți termenul de căutare",
                                "minChars": 0,
                                "noResultsText": "Niciun rezultat",
                                "preventDuplicates": true,
                                "searchingText": "Căutare...",
                                "tokenValue": "id"
                            }'
                        ]) !!}
                    </div>
                    <h4>{{ trans('Criteriilor de standarde') }}</h4>
                    @foreach ($standards as $standard)
                        <div class="form-group">
                            {!! Form::label('chapter_container' . $standard->id, $standard->name, ['class' => 'control-label']) !!}
                            {!! Form::text('chapter_container' . $standard->id, $internal_audit->get_chapters_nrs($standard->id), ['class' => 'form-control', 'disabled']) !!}
                        </div>
                    @endforeach
                    <h4>Manualul sistemului de mgmt int.</h4>
                    <h4>{{ trans('Procedurele') }}</h4>
                    @foreach ($processes as $process)
                        <div class="form-group">
                            {!! Form::label('procedures_container' . $process->id, $process->name, ['class' => 'control-label']) !!}
                            {!! Form::text('procedures_container' . $process->id, $internal_audit->get_procedures($process->id), ['class' => 'form-control', 'disabled']) !!}
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane" id="checking-documentation-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    <div class="documentation-form-container marginB30">
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                {!! Form::label('documentation_question', trans('Întrebare') , ['class'=> 'control-label']) !!}
                                {!! Form::textarea('documentation_question[0]', null, ['class' => 'form-control required', 'rows' => 5]) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                {!! Form::label('documentation_yes_no', trans('Da sau nu'), ['class' => 'control-label']) !!}
                                {!! Form::select('documentation_yes_no[0]', Config::get('internal_audit_reports.status'), null, ['class' => 'form-control documentation-yes-no-input']) !!}
                                <a class="btn btn-default hidden documentation-yes-no-btn internal-audit-report-yes-no-btn marginT15">{{ trans('Adaugare la acțiuni corective si preventive') }}</a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                {!! Form::label('documentation_proof_or_note', trans('Dovada sau nota'), ['class' => 'control-label']) !!}
                                {!! Form::textarea('documentation_proof_or_note[0]', null, ['class' => 'form-control documentation-proof-or-note-input required', 'rows' => 5]) !!}
                            </div>
                        </div>
                        <a class="text-danger no-underline remove-row" data-target=".documentation-form-container"><span class="fa fa-minus-circle"></span> {{ trans('Șterge form') }}</a>
                    </div>
                    <a class="marginB15 no-underline clone" data-target=".documentation-form-container"><span class="fa fa-plus-circle"></span> {{ trans('Adaugă form nou') }}</a>
                    <div class="col-xs-12 marginT30">
                        <div class="form-group">
                            {!! Form::label('documentation_suggestions', trans('Indicați sugestiile de îmbunătățire a documentației'), ['class' => 'control-label']) !!}
                            {!! Form::textarea('documentation_suggestions', null, ['class' => 'form-control', 'rows' => 5]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="audit-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    <div class="audit-form-container marginB30">
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                {!! Form::label('audit_requirement', trans('Ref. cerință'), ['class' => 'control-label small-label']) !!}
                                {!! Form::text('audit_requirement[0]', null, [
                                    'class' => 'form-control token-input required',
                                    'data-autocomplete-src' => action('InternalAuditReportsController@get_chapters', $internal_audit->id),
                                    'data-options' => '{
                    		            "hintText": "Introduceți termenul de căutare",
                    		            "minChars": 0,
                    		            "noResultsText": "Niciun rezultat",
                    		            "preventDuplicates": true,
                    		            "searchingText": "Căutare...",
                    		            "tokenValue": "id"
                    		        }'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                {!! Form::label('audit_question', trans('Întrebare') , ['class'=> 'control-label']) !!}
                                {!! Form::textarea('audit_question[0]', null, ['class' => 'form-control required', 'rows' => 5]) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                {!! Form::label('audit_yes_no', trans('Da sau nu'), ['class' => 'control-label']) !!}
                                {!! Form::select('audit_yes_no[0]', Config::get('internal_audit_reports.status'), null, ['class' => 'form-control audit-yes-no-input']) !!}
                                <a class="btn btn-default hidden audit-yes-no-btn internal-audit-report-yes-no-btn marginT15">{{ trans('Adaugare la acțiuni corective si preventive') }}</a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                {!! Form::label('audit_proof_or_note', trans('Dovada sau nota'), ['class' => 'control-label']) !!}
                                {!! Form::textarea('audit_proof_or_note[0]', null, ['class' => 'form-control audit-proof-or-note-input required', 'rows' => 5]) !!}
                            </div>
                        </div>
                        <a class="text-danger no-underline remove-row" data-target=".audit-form-container"><span class="fa fa-minus-circle"></span> {{ trans('Șterge form') }}</a>
                    </div>
                    <a class="marginB15 no-underline clone" data-target=".audit-form-container"><span class="fa fa-plus-circle"></span> {{ trans('Adaugă form nou') }}</a>
                </div>
            </div>
            <div class="tab-pane" id="review-report-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    <div class="review-report-form-container marginB30">
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                {!! Form::label('review_report_question', trans('Întrebare') , ['class'=> 'control-label']) !!}
                                {!! Form::textarea('review_report_question[0]', null, ['class' => 'form-control required', 'rows' => 5]) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                {!! Form::label('review_report_yes_no', trans('Da sau nu'), ['class' => 'control-label']) !!}
                                {!! Form::select('review_report_yes_no[0]', Config::get('internal_audit_reports.status'), null, ['class' => 'form-control review-report-yes-no-input']) !!}
                                <a class="btn btn-default hidden review-report-yes-no-btn internal-audit-report-yes-no-btn marginT15">{{ trans('Adaugare la acțiuni corective si preventive') }}</a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                {!! Form::label('review_report_proof_or_note', trans('Dovada sau nota'), ['class' => 'control-label']) !!}
                                {!! Form::textarea('review_report_proof_or_note[0]', null, ['class' => 'form-control review-report-proof-or-note-input required', 'rows' => 5]) !!}
                            </div>
                        </div>
                        <a class="text-danger no-underline remove-row" data-target=".review-report-form-container"><span class="fa fa-minus-circle"></span> {{ trans('Șterge form') }}</a>
                    </div>
                    <a class="marginB15 no-underline clone" data-target=".review-report-form-container"><span class="fa fa-plus-circle"></span> {{ trans('Adaugă form nou') }}</a>
                    <div class="col-xs-12 marginT30">
                        <div class="form-group">
                            {!! Form::label('review_report_problems_discovered', trans('Probleme descoperite'), ['class' => 'control-label']) !!}
                            {!! Form::textarea('review_report_problems_discovered', null, ['class' => 'form-control', 'rows' => 5]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection


@section('css')
    <link href="{{ asset('css/token-input.css') }}?v={{ time() }}" rel="stylesheet" />
@endsection

@section('content-scripts')
    <script src="{{ asset('js/jquery.tokeninput.min.js') }}"></script>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#planning-container .token-input').tokenInput($('#planning-container .token-input').attr('data-autocomplete-src'), JSON.parse($('#planning-container .token-input').attr('data-options')));

        $('.audit-form-container .token-input').tokenInput($('.audit-form-container .token-input').attr('data-autocomplete-src'), JSON.parse($('.audit-form-container .token-input').attr('data-options')));

        $('.documentation-yes-no-input').change(function() {
            if ($(this).val() == 'no') {
                $(this).siblings('.documentation-yes-no-btn').removeClass('hidden');
            }
            else {
                $(this).siblings('.documentation-yes-no-btn').addClass('hidden');
            }
        });

        $('.documentation-yes-no-btn').click(function() {
            var documentation_proof_or_note = $(this).closest('.documentation-form-container').find('.documentation-proof-or-note-input');
            var btn = $(this).closest('.documentation-form-container').find('.documentation-yes-no-btn');

            documentation_proof_or_note.parent('.form-group').removeClass('has-error');
            documentation_proof_or_note.parent('.form-group').find('.help-block').remove();

            if (documentation_proof_or_note.val() == '') {
                documentation_proof_or_note.parent('.form-group').addClass('has-error');
                documentation_proof_or_note.parent('.form-group').append('<span class="help-block"><strong>{{ trans('Acest câmp este obligatoriu') }}</strong></span>');
            }
            else {
                $.ajax({
                    url: '{{ action('InternalAuditReportsController@to_capa') }}',
                    data: {
                        'proof' : documentation_proof_or_note.val(),
                        'audit_id': {{ $internal_audit->id }}
                    }
                }).done(function(res) {
                    btn.addClass('disabled');
                    btn.text('Adaugat la acțiuni corective si preventive');
                });
            }
        });

        $('.audit-yes-no-input').change(function() {
            if ($(this).val() == 'no') {
                $(this).siblings('.audit-yes-no-btn').removeClass('hidden');
            }
            else {
                $(this).siblings('.audit-yes-no-btn').addClass('hidden');
            }
        });

        $('.audit-yes-no-btn').click(function() {
            var documentation_proof_or_note = $(this).closest('.audit-form-container').find('.audit-proof-or-note-input');
            var btn = $(this).closest('.audit-form-container').find('.audit-yes-no-btn');

            documentation_proof_or_note.parent('.form-group').removeClass('has-error');
            documentation_proof_or_note.parent('.form-group').find('.help-block').remove();

            if (documentation_proof_or_note.val() == '') {
                documentation_proof_or_note.parent('.form-group').addClass('has-error');
                documentation_proof_or_note.parent('.form-group').append('<span class="help-block"><strong>{{ trans('Acest câmp este obligatoriu') }}</strong></span>');
            }
            else {
                $.ajax({
                    url: '{{ action('InternalAuditReportsController@to_capa') }}',
                    data: {
                        'proof' : documentation_proof_or_note.val(),
                        'audit_id': {{ $internal_audit->id }}
                    }
                }).done(function(res) {
                    btn.addClass('disabled');
                    btn.text('Adaugat la acțiuni corective si preventive');
                });
            }
        });

        $('.review-report-yes-no-input').change(function() {
            if ($(this).val() == 'no') {
                $(this).siblings('.review-report-yes-no-btn').removeClass('hidden');
            }
            else {
                $(this).siblings('.review-report-yes-no-btn').addClass('hidden');
            }
        });

        $('.review-report-yes-no-btn').click(function() {
            var documentation_proof_or_note = $(this).closest('.review-report-form-container').find('.review-report-proof-or-note-input');
            var btn = $(this).closest('.review-report-form-container').find('.review-report-yes-no-btn');

            documentation_proof_or_note.parent('.form-group').removeClass('has-error');
            documentation_proof_or_note.parent('.form-group').find('.help-block').remove();

            if (documentation_proof_or_note.val() == '') {
                documentation_proof_or_note.parent('.form-group').addClass('has-error');
                documentation_proof_or_note.parent('.form-group').append('<span class="help-block"><strong>{{ trans('Acest câmp este obligatoriu') }}</strong></span>');
            }
            else {
                $.ajax({
                    url: '{{ action('InternalAuditReportsController@to_capa') }}',
                    data: {
                        'proof': documentation_proof_or_note.val(),
                        'audit_id': {{ $internal_audit->id }}
                    }
                }).done(function(res) {
                    btn.addClass('disabled');
                    btn.text('Adaugat la acțiuni corective si preventive');
                });
            }
        });

        // Validation
        $('#saveForm').submit(function () {
            var valid = true;
            $('.required').each(function() {

                $(this).parent('.form-group').removeClass('has-error');
                $(this).parent('.form-group').find('.help-block').remove();

                if ($(this).val() == '') {
                    $(this).parent('.form-group').addClass('has-error');
                    $(this).parent('.form-group').append('<span class="help-block"><strong>{{ trans('Acest câmp este obligatoriu') }}</strong></span>');
                    valid = false;
                }
                else {
                    $(this).parent('.form-group').removeClass('has-error');
                    $(this).parent('.form-group').find('.help-block').remove();
                }
            });

            return valid;
        });
    });
    </script>
@endsection
