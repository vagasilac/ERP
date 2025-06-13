@extends('app')

@section('title') {{ trans('Raportul de audit intern') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model($internal_audit_report, ['id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header no-border col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
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
                        {!! Form::text('auditor', $internal_audit_report->auditor->name, ['class' => 'form-control', 'disabled']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('audited_people', trans('Persoane auditate'), ['class' => 'control-label small-label']) !!}
                        {!! Form::text('audited_people', $internal_audit_report->get_audited_people(), ['class' => 'form-control', 'disabled']) !!}
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
                    @foreach ($internal_audit_report->documentations as $documentation)
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                {!! Form::label('documentation_question', trans('Întrebare'), ['class' => 'control-label']) !!}
                                {!! Form::textarea('documentation_question', $documentation->documentation_question, ['class' => 'form-control', 'disabled', 'rows' => 5]) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                {!! Form::label('documentation_yes_no', trans('Da sau nu'), ['class' => 'control-label']) !!}
                                {!! Form::text('documentation_yes_no[0]', Config::get('internal_audit_reports.status.' . $documentation->documentation_yes_no), ['class' => 'form-control', 'disabled']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    {!! Form::label('documentation_proof_or_note', trans('Dovada sau nota'), ['class' => 'control-label']) !!}
                                    {!! Form::textarea('documentation_proof_or_note', $documentation->documentation_proof_or_note, ['class' => 'form-control', 'disabled', 'rows' => 5]) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-xs-12 marginT30">
                        <div class="form-group">
                            {!! Form::label('documentation_suggestions', trans('Indicați sugestiile de îmbunătățire a documentației'), ['class' => 'control-label']) !!}
                            {!! Form::textarea('documentation_suggestions', $internal_audit_report->documentation_suggestions, ['class' => 'form-control', 'disabled']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="audit-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    @foreach ($internal_audit_report->report_audits as $audit)
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                {!! Form::label('audit_requirement', trans('Ref. cerință'), ['class' => 'control-label small-label']) !!}
                                {!! Form::text('audit_requirement', $audit->requirements_name(), ['class' => 'form-control', 'disabled']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                {!! Form::label('audit_question', trans('Întrebare') , ['class'=> 'control-label']) !!}
                                {!! Form::textarea('audit_question', $audit->audit_question, ['class' => 'form-control', 'disabled', 'rows' => 5]) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                {!! Form::label('audit_yes_no', trans('Da sau nu'), ['class' => 'control-label']) !!}
                                {!! Form::text('audit_yes_no', Config::get('internal_audit_reports.status.' . $audit->audit_yes_no), ['class' => 'form-control', 'disabled']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                {!! Form::label('audit_proof_or_note', trans('Dovada sau nota'), ['class' => 'control-label']) !!}
                                {!! Form::textarea('audit_proof_or_note', $audit->audit_proof_or_note, ['class' => 'form-control', 'rows' => 5, 'disabled']) !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane" id="review-report-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    @foreach ($internal_audit_report->review_reports as $review_report)
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                {!! Form::label('review_report_question', trans('Întrebare') , ['class'=> 'control-label']) !!}
                                {!! Form::textarea('review_report_question', $review_report->review_report_question, ['class' => 'form-control', 'rows' => 5, 'disabled']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                {!! Form::label('review_report_yes_no', trans('Da sau nu'), ['class' => 'control-label']) !!}
                                {!! Form::text('review_report_yes_no', Config::get('internal_audit_reports.status.' . $review_report->review_report_yes_no), ['class' => 'form-control', 'disabled']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                {!! Form::label('review_report_proof_or_note', trans('Dovada sau nota'), ['class' => 'control-label']) !!}
                                {!! Form::textarea('review_report_proof_or_note', $review_report->review_report_proof_or_note, ['class' => 'form-control', 'rows' => 5, 'disabled']) !!}
                            </div>
                        </div>
                    @endforeach
                    <div class="col-xs-12 marginT30">
                        <div class="form-group">
                            {!! Form::label('review_report_problems_discovered', trans('Probleme descoperite'), ['class' => 'control-label']) !!}
                            {!! Form::textarea('review_report_problems_discovered', $internal_audit_report->review_report_problems_discovered, ['class' => 'form-control', 'rows' => 5, 'disabled']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
