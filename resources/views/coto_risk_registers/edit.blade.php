@extends('app')

@section('title') {{ trans('Editare') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model($item, ['action' => ['CotoRiskRegistersController@update', $item->id], 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header no-border col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('CotoRiskRegistersController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 marginR15">
            <div class="form-group">
                {!! Form::label('processes', trans('Proces') , ['class'=> 'control-label']) !!}
                {!!Form::text('processes', $item->processes, ['readonly','class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('risk', trans('Risc') , ['class'=> 'control-label']) !!}
                {!!Form::text('risk', $item->risk, ['readonly','class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">

            <h4>{{ trans('Înainte de planul de atenuare') }}</h4>
            <div class="form-group">
                {!! Form::label('risk_likelihood', trans('Probabilitate') , ['class'=> 'control-label']) !!}
                {!! Form::select('risk_likelihood', Config::get('coto.risk_registers.risk_likelihood'), $registers->risk_likelihood, ['class' => 'form-control', 'id' => 'risk_likelihood']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('risk_occurrences', trans('Apariţie') , ['class'=> 'control-label']) !!}
                {!! Form::select('risk_occurrences', Config::get('coto.risk_registers.risk_occurrences'), $registers->risk_occurrences, ['class' => 'form-control', 'id' => 'risk_occurrences']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('risk_prob_rating', trans('Nota de probabilitate') , ['class'=> 'control-label']) !!}
                {!!Form::text('risk_prob_rating', '0', ['readonly','class' => 'form-control', 'id' => 'risk_prob_rating']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('risk_potential_loss_of_contracts', trans('Eventuala pierdere a contractelor') , ['class'=> 'control-label']) !!}
                {!! Form::select('risk_potential_loss_of_contracts', Config::get('coto.risk_registers.risk_potential_loss_of_contracts'), $registers->risk_potential_loss_of_contracts, ['class' => 'form-control', 'id' => 'risk_potential_loss_of_contracts']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('risk_potential_risk_to_human_health', trans('Risc potențial pentru sănătatea umană') , ['class'=> 'control-label']) !!}
                {!! Form::select('risk_potential_risk_to_human_health', Config::get('coto.risk_registers.risk_potential_risk_to_human_health'), $registers->risk_potential_risk_to_human_health, ['class' => 'form-control', 'id' => 'risk_potential_risk_to_human_health']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('risk_inability_to_meet_contract_terms', trans('Incapacitatea de a îndeplini condițiile contractuale') , ['class'=> 'control-label']) !!}
                {!! Form::select('risk_inability_to_meet_contract_terms', Config::get('coto.risk_registers.risk_inability_to_meet_contract_terms'), $registers->risk_inability_to_meet_contract_terms, ['class' => 'form-control', 'id' => 'risk_inability_to_meet_contract_terms']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('risk_potential_violation_of_regulations', trans('Încălcarea potențială a reglementărilor') , ['class'=> 'control-label']) !!}
                {!! Form::select('risk_potential_violation_of_regulations', Config::get('coto.risk_registers.risk_potential_violation_of_regulations'), $registers->risk_potential_violation_of_regulations, ['class' => 'form-control', 'id' => 'risk_potential_violation_of_regulations']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('risk_impact_on_company_reputation', trans('Impact asupra reputației companiei') , ['class'=> 'control-label']) !!}
                {!! Form::select('risk_impact_on_company_reputation', Config::get('coto.risk_registers.risk_impact_on_company_reputation'), $registers->risk_impact_on_company_reputation, ['class' => 'form-control', 'id' => 'risk_impact_on_company_reputation']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('risk_est_cost_of_correction', trans('Costul corecției') , ['class'=> 'control-label']) !!}
                {!! Form::select('risk_est_cost_of_correction', Config::get('coto.risk_registers.risk_est_cost_of_correction'), $registers->risk_est_cost_of_correction, ['class' => 'form-control', 'id' => 'risk_est_cost_of_correction']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('risk_cons_rating', trans('Nota de cons') , ['class'=> 'control-label']) !!}
                {!!Form::text('risk_cons_rating', '0', ['readonly','class' => 'form-control', 'id' => 'risk_cons_rating']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('before_risk_factor', trans('Factor de risc') , ['class'=> 'control-label']) !!}
                {!!Form::text('before_risk_factor', '0', ['readonly','class' => 'form-control', 'id' => 'before_risk_factor']) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <h4>{{ trans('După planul de atenuare') }}</h4>
            <div class="form-group">
                {!! Form::label('mitigation_likelihood', trans('Probabilitate') , ['class'=> 'control-label']) !!}
                {!! Form::select('mitigation_likelihood', Config::get('coto.risk_registers.mitigation_likelihood'), $registers->mitigation_likelihood, ['class' => 'form-control', 'id' => 'mitigation_likelihood']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('mitigation_occurrences', trans('Apariţie') , ['class'=> 'control-label']) !!}
                {!! Form::select('mitigation_occurrences', Config::get('coto.risk_registers.mitigation_occurrences'), $registers->mitigation_occurrences, ['class' => 'form-control', 'id' => 'mitigation_occurrences']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('mitigation_prob_rating', trans('Nota de probabilitate') , ['class'=> 'control-label']) !!}
                {!!Form::text('mitigation_prob_rating', '0', ['readonly','class' => 'form-control', 'id' => 'mitigation_prob_rating']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('mitigation_potential_loss_of_contracts', trans('Eventuala pierdere a contractelor') , ['class'=> 'control-label']) !!}
                {!! Form::select('mitigation_potential_loss_of_contracts', Config::get('coto.risk_registers.mitigation_potential_loss_of_contracts'), $registers->mitigation_potential_loss_of_contracts, ['class' => 'form-control', 'id' => 'mitigation_potential_loss_of_contracts']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('mitigation_potential_risk_to_human_health', trans('Risc potențial pentru sănătatea umană') , ['class'=> 'control-label']) !!}
                {!! Form::select('mitigation_potential_risk_to_human_health', Config::get('coto.risk_registers.mitigation_potential_risk_to_human_health'), $registers->mitigation_potential_risk_to_human_health, ['class' => 'form-control', 'id' => 'mitigation_potential_risk_to_human_health']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('mitigation_inability_to_meet_contract_terms', trans('Incapacitatea de a îndeplini condițiile contractuale') , ['class'=> 'control-label']) !!}
                {!! Form::select('mitigation_inability_to_meet_contract_terms', Config::get('coto.risk_registers.mitigation_inability_to_meet_contract_terms'), $registers->mitigation_inability_to_meet_contract_terms, ['class' => 'form-control', 'id' => 'mitigation_inability_to_meet_contract_terms']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('mitigation_potential_violation_of_regulations', trans('Încălcarea potențială a reglementărilor') , ['class'=> 'control-label']) !!}
                {!! Form::select('mitigation_potential_violation_of_regulations', Config::get('coto.risk_registers.mitigation_potential_violation_of_regulations'), $registers->mitigation_potential_violation_of_regulations, ['class' => 'form-control', 'id' => 'mitigation_potential_violation_of_regulations']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('mitigation_impact_on_company_reputation', trans('Impact asupra reputației companiei') , ['class'=> 'control-label']) !!}
                {!! Form::select('mitigation_impact_on_company_reputation', Config::get('coto.risk_registers.mitigation_impact_on_company_reputation'), $registers->mitigation_impact_on_company_reputation, ['class' => 'form-control', 'id' => 'mitigation_impact_on_company_reputation']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('mitigation_est_cost_of_correction', trans('Costul corecției') , ['class'=> 'control-label']) !!}
                {!! Form::select('mitigation_est_cost_of_correction', Config::get('coto.risk_registers.mitigation_est_cost_of_correction'), $registers->mitigation_est_cost_of_correction, ['class' => 'form-control', 'id' => 'mitigation_est_cost_of_correction']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('mitigation_cons_rating', trans('Nota de cons') , ['class'=> 'control-label']) !!}
                {!!Form::text('mitigation_cons_rating', '0', ['readonly','class' => 'form-control', 'id' => 'mitigation_cons_rating']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('after_risk_factor', trans('Factor de risc') , ['class'=> 'control-label']) !!}
                {!!Form::text('after_risk_factor', '0', ['readonly','class' => 'form-control', 'id' => 'after_risk_factor']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('mitigation_plan', trans('plan de atenuare') , ['class'=> 'control-label']) !!}
                {!! Form::textarea('mitigation_plan', $registers->mitigation_plan, ['class' => 'form-control', 'size' => '50x3']) !!}
            </div>
            <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#files-table">
                <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                    <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                    <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                </div>
            </div>
            <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>
            <div class="table-responsive">
                @include('coto_risk_registers._documents_list', ['documents' => $documents])
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@endsection

@section('content-modals')
    <div class="modal fade" id="upload-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Încărcare fișiere') }}</h4>
                </div>
                <div class="modal-body dropzone-upload">
                    <div class="dz-drag-message">{{ trans('Drag & drop fișierele sau directoarele pe care doriți să le încărcați') }}</div>
                    {!! Form::hidden('_token', csrf_token()) !!}
                    {!! Form::hidden('type', null) !!}
                    <div class="files" id="dropzone-previews">

                        <div id="dropzone-template" class="file-row">
                            <!-- This is used as the file preview template -->
                            <div class="preview-container">
                                <span class="preview"><img data-dz-thumbnail src="{{ asset('img/doc-placeholder.png') }}"/></span>
                            </div>
                            <div>
                                <p class="name" data-dz-name></p>
                                <strong class="error text-danger" data-dz-errormessage></strong>
                            </div>
                            <div>
                                <p class="size" data-dz-size></p>
                            </div>
                            <div class="progress-container">
                                <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                </div>
                            </div>
                            <div class="actions-container">
                                <button type="submit" class="btn btn-primary start">
                                    <i class="glyphicon glyphicon-upload"></i>
                                    <span>{{ trans("Pornește încărcarea") }}</span>
                                </button>
                                <button type="reset" class="btn btn-warning cancel">
                                    <i class="glyphicon glyphicon-ban-circle"></i>
                                    <span>{{ trans("Anulează încărcarea") }}</span>
                                </button>
                                <button data-dz-remove class="btn btn-danger delete" title="{{ trans("Ștergere") }}">
                                    <i class="material-icons">&#xE872;</i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer" id="actions">
                    <span class="fileupload-process hidden">
                      <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                          <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                      </div>
                    </span>
                    <span class="btn btn-primary fileinput-button">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>{{ trans("Adaugă fișiere") }}...</span>
                    </span>
                    <button type="submit" class="btn btn-success start">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>{{ trans("Pornește încărcarea") }}</span>
                    </button>
                    <button type="reset" class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>{{ trans("Anulează încărcarea") }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-modal">
        {!! Form::open(['action' => ['CotoRiskRegistersController@documents_multiple_destroy', $item->id], 'method' => 'DELETE']) !!}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Șterge fișiere') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('Doriți să ștergeți aceste fișiere') }}
                    <div class="inputs-container"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Șterge', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
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
    <script src="{{ asset('js/dropzone.min.js') }}"></script>

    <script>
        jQuery(document).ready(function($) {

            $('.upload-btn').click(function() {
                setDropzoneUpload("{{ action('CotoRiskRegistersController@documents_upload', [$item->id, 'processes' => $item->processes]) }}");
            });

            //adds tab href to url + opens tab based on hash on page load
            var hash = window.location.hash;
            hash && $('ul.nav a[href="' + hash + '"]').tab('show');
            $('input[name="active_tab"]').val(hash);

            $('.nav-tabs a').click(function (e) {
                $(this).tab('show');
                var scrollmem = $('body').scrollTop() || $('html').scrollTop();
                window.location.hash = this.hash;
                $('input[name="active_tab"]').val(this.hash);
                $('html,body').scrollTop(scrollmem);
            });
        });
    </script>

    <script>
        jQuery(document).ready(function($) {

            refreshRiskProbRating();
            refreshRiskConsRating();

            refreshMitigationProbRating();
            refreshMitigationConsRating();

            refreshBeforeRiskFactor();
            refreshAfterRiskFactor();

            $('#risk_likelihood').change(function () { refreshRiskProbRating(); });
            $('#risk_occurrences').change(function () { refreshRiskProbRating(); });
            $('#risk_potential_loss_of_contracts').change(function() { refreshRiskConsRating(); });
            $('#risk_potential_risk_to_human_health').change(function() { refreshRiskConsRating(); });
            $('#risk_inability_to_meet_contract_terms').change(function() { refreshRiskConsRating(); });
            $('#risk_potential_violation_of_regulations').change(function() { refreshRiskConsRating(); });
            $('#risk_impact_on_company_reputation').change(function() { refreshRiskConsRating(); });
            $('#risk_est_cost_of_correction').change(function() { refreshRiskConsRating(); });

            $('#mitigation_likelihood').change(function () { refreshMitigationProbRating(); });
            $('#mitigation_occurrences').change(function () { refreshMitigationProbRating(); });
            $('#mitigation_potential_loss_of_contracts').change(function() { refreshMitigationConsRating(); });
            $('#mitigation_potential_risk_to_human_health').change(function() { refreshMitigationConsRating(); });
            $('#mitigation_inability_to_meet_contract_terms').change(function() { refreshMitigationConsRating(); });
            $('#mitigation_potential_violation_of_regulations').change(function() { refreshMitigationConsRating(); });
            $('#mitigation_impact_on_company_reputation').change(function() { refreshMitigationConsRating(); });
            $('#mitigation_est_cost_of_correction').change(function() { refreshMitigationConsRating(); });

            $('#risk_prob_rating').change(function() { refreshBeforeRiskFactor(); });
            $('#risk_cons_rating').change(function() { refreshBeforeRiskFactor(); });

            $('#mitigation_prob_rating').change(function () { refreshAfterRiskFactor(); });
            $('#mitigation_cons_rating').change(function () { refreshAfterRiskFactor(); });

            function refreshRiskProbRating() {
                var risk_likelihood = parseInt($('#risk_likelihood').val());
                var risk_occurrences = parseInt($('#risk_occurrences').val());
                var average = parseFloat((risk_likelihood + risk_occurrences) / 2).toFixed(2);

                $('#risk_prob_rating').val(average).trigger('change');
            }
            function refreshRiskConsRating() {
                var risk_potential_loss_of_contracts = parseInt($('#risk_potential_loss_of_contracts').val());
                var risk_potential_risk_to_human_health = parseInt($('#risk_potential_risk_to_human_health').val());
                var risk_inability_to_meet_contract_terms = parseInt($('#risk_inability_to_meet_contract_terms').val());
                var risk_potential_violation_of_regulations = parseInt($('#risk_potential_violation_of_regulations').val());
                var risk_impact_on_company_reputation = parseInt($('#risk_impact_on_company_reputation').val());
                var risk_est_cost_of_correction = parseInt($('#risk_est_cost_of_correction').val());

                var average = parseFloat((risk_potential_loss_of_contracts + risk_potential_risk_to_human_health + risk_inability_to_meet_contract_terms + risk_potential_violation_of_regulations + risk_impact_on_company_reputation + risk_est_cost_of_correction) / 6).toFixed(2);

                $('#risk_cons_rating').val(average).trigger('change');
            }
            function refreshMitigationProbRating() {
                var mitigation_likelihood = parseInt($('#mitigation_likelihood').val());
                var mitigation_occurrences = parseInt($('#mitigation_occurrences').val());

                var average = parseFloat((mitigation_likelihood + mitigation_occurrences) / 2).toFixed(2);

                $('#mitigation_prob_rating').val(average).trigger('change');
            }
            function refreshMitigationConsRating() {
                var mitigation_potential_loss_of_contracts = parseInt($('#mitigation_potential_loss_of_contracts').val());
                var mitigation_potential_risk_to_human_health = parseInt($('#mitigation_potential_risk_to_human_health').val());
                var mitigation_inability_to_meet_contract_terms = parseInt($('#mitigation_inability_to_meet_contract_terms').val());
                var mitigation_potential_violation_of_regulations = parseInt($('#mitigation_potential_violation_of_regulations').val());
                var mitigation_impact_on_company_reputation = parseInt($('#mitigation_impact_on_company_reputation').val());
                var mitigation_est_cost_of_correction = parseInt($('#mitigation_est_cost_of_correction').val());

                var average = parseFloat((mitigation_potential_loss_of_contracts + mitigation_potential_risk_to_human_health + mitigation_inability_to_meet_contract_terms + mitigation_potential_violation_of_regulations + mitigation_impact_on_company_reputation + mitigation_est_cost_of_correction) / 6).toFixed(2);

                $('#mitigation_cons_rating').val(average).trigger('change');
            }
            function refreshBeforeRiskFactor() {
                var risk_prob_rating = parseFloat($('#risk_prob_rating').val());
                var risk_cons_rating = parseFloat($('#risk_cons_rating').val());

                var rating = parseFloat(risk_prob_rating * risk_cons_rating).toFixed(2);

                $('#before_risk_factor').val(rating);

                if (rating > 8) {
                    $('#before_risk_factor').css('background-color', '#e10909');
                }
                else if (rating > 5) {
                    $('#before_risk_factor').css('background-color', '#ffe429');
                }
                else {
                    $('#before_risk_factor').css('background-color', 'initial');
                }
            }
            function refreshAfterRiskFactor() {
                var mitigation_prob_rating = parseFloat($('#mitigation_prob_rating').val());
                var mitigation_cons_rating = parseFloat($('#mitigation_cons_rating').val());

                var rating = parseFloat(mitigation_cons_rating * mitigation_prob_rating).toFixed(2);

                $('#after_risk_factor').val(rating);

                if (rating > 8) {
                    $('#after_risk_factor').css('background-color', '#e10909');
                }
                else if (rating > 5) {
                    $('#after_risk_factor').css('background-color', '#ffe429');
                }
                else {
                    $('#after_risk_factor').css('background-color', 'initial');
                }
            }
        });
    </script>
@endsection
