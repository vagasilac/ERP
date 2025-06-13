@extends('app')

@section('title') {{ trans('Editare') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model($item, ['action' => ['CotoOpportunityRegistersController@update', $item->id], 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header no-border col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('CotoOpportunityRegistersController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 marginR15">
            <div class="form-group">
                {!! Form::label('processes', trans('Proces') , ['class'=> 'control-label']) !!}
                {!!Form::text('processes', $item->processes, ['readonly','class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('opportunity', trans('Oportunitate') , ['class'=> 'control-label']) !!}
                {!!Form::text('opportunity', $item->opportunity, ['readonly','class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">

            <div class="form-group">
                {!! Form::label('likelihood', trans('Probabilitate') , ['class'=> 'control-label']) !!}
                {!! Form::select('likelihood', Config::get('coto.opportunity_registers.likelihood'), $registers->likelihood, ['class' => 'form-control', 'id' => 'likelihood']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('occurrences', trans('Apariţie') , ['class'=> 'control-label']) !!}
                {!! Form::select('occurrences', Config::get('coto.opportunity_registers.occurrences'), $registers->occurrences, ['class' => 'form-control', 'id' => 'occurrences']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('prob_rating', trans('Nota de probabilitate') , ['class'=> 'control-label']) !!}
                {!!Form::text('prob_rating', '0', ['readonly','class' => 'form-control', 'id' => 'prob_rating']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('potential_for_new_business', trans('Potențial pentru noi afaceri') , ['class'=> 'control-label']) !!}
                {!! Form::select('potential_for_new_business', Config::get('coto.opportunity_registers.potential_for_new_business'), $registers->potential_for_new_business, ['class' => 'form-control', 'id' => 'potential_for_new_business']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('potential_expansion_of_current_business', trans('Potențială extindere a afacerii curente') , ['class'=> 'control-label']) !!}
                {!! Form::select('potential_expansion_of_current_business', Config::get('coto.opportunity_registers.potential_expansion_of_current_business'), $registers->potential_expansion_of_current_business, ['class' => 'form-control', 'id' => 'potential_expansion_of_current_business']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('potential_improvement_in_satisfying_regulations', trans('Îmbunătățirea potențială a respectării reglementărilor') , ['class'=> 'control-label']) !!}
                {!! Form::select('potential_improvement_in_satisfying_regulations', Config::get('coto.opportunity_registers.potential_improvement_in_satisfying_regulations'), $registers->potential_improvement_in_satisfying_regulations, ['class' => 'form-control', 'id' => 'potential_improvement_in_satisfying_regulations']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('potential_improvement_to_internal_qms_processes', trans('Îmbunătățirea potențială a proceselor interne QMS') , ['class'=> 'control-label']) !!}
                {!! Form::select('potential_improvement_to_internal_qms_processes', Config::get('coto.opportunity_registers.potential_improvement_to_internal_qms_processes'), $registers->potential_improvement_to_internal_qms_processes, ['class' => 'form-control', 'id' => 'potential_improvement_to_internal_qms_processes']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('improvement_to_company_reputation', trans('Îmbunătățirea reputației companiei') , ['class'=> 'control-label']) !!}
                {!! Form::select('improvement_to_company_reputation', Config::get('coto.opportunity_registers.improvement_to_company_reputation'), $registers->improvement_to_company_reputation, ['class' => 'form-control', 'id' => 'improvement_to_company_reputation']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('potential_cost_of_implementation', trans('Costul potențial al implementării') , ['class'=> 'control-label']) !!}
                {!! Form::select('potential_cost_of_implementation', Config::get('coto.opportunity_registers.potential_cost_of_implementation'), $registers->potential_cost_of_implementation, ['class' => 'form-control', 'id' => 'potential_cost_of_implementation']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('ben_rating', trans('Nota de beneficiu') , ['class'=> 'control-label']) !!}
                {!!Form::text('ben_rating', '0', ['readonly','class' => 'form-control', 'id' => 'ben_rating']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('opp_factor', trans('Factor de oportunitate') , ['class'=> 'control-label']) !!}
                {!!Form::text('opp_factor', '0', ['readonly','class' => 'form-control', 'id' => 'opp_factor']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('opportunity_pursuit_plan', trans('Plan de urmărire a oportunităților') , ['class'=> 'control-label']) !!}
                {!! Form::textarea('opportunity_pursuit_plan', $registers->opportunity_pursuit_plan, ['class' => 'form-control', 'size' => '50x3']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('post_implementation_success', trans('Post succes de implementare') , ['class'=> 'control-label']) !!}
                {!! Form::select('post_implementation_success', Config::get('coto.opportunity_registers.post_implementation_success'), $registers->post_implementation_success, ['class' => 'form-control', 'id' => 'post_implementation_success']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('status', trans('Stare') , ['class'=> 'control-label']) !!}
                {!! Form::select('status', Config::get('coto.opportunity_registers.status'), $registers->status, ['class' => 'form-control', 'id' => 'status']) !!}
            </div>
            <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#files-table">
                <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                    <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                    <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                </div>
            </div>
            <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>
            <div class="table-responsive">
                @include('coto_opportunity_registers._documents_list', ['documents' => $documents])
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
        {!! Form::open(['action' => ['CotoOpportunityRegistersController@documents_multiple_destroy', $item->id], 'method' => 'DELETE']) !!}
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
                setDropzoneUpload("{{ action('CotoOpportunityRegistersController@documents_upload', [$item->id, 'processes' => $item->processes]) }}");
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

            refreshProbRating();
            refreshBenRating();
            refreshOppFactor();

            $('#likelihood').change(function() { refreshProbRating(); });
            $('#occurrences').change(function() { refreshProbRating(); });

            $('#potential_for_new_business').change(function() { refreshBenRating(); });
            $('#potential_expansion_of_current_business').change(function() { refreshBenRating(); });
            $('#potential_improvement_in_satisfying_regulations').change(function() { refreshBenRating(); });
            $('#potential_improvement_to_internal_qms_processes').change(function() { refreshBenRating(); });
            $('#improvement_to_company_reputation').change(function() { refreshBenRating(); });
            $('#potential_cost_of_implementation').change(function() { refreshBenRating(); });
            $('#post_implementation_success').change(function() { refreshBenRating(); });

            $('#prob_rating').change(function() { refreshOppFactor(); });
            $('#ben_rating').change(function() { refreshOppFactor(); });

            function refreshProbRating() {
                var likelihood = parseFloat($('#likelihood').val());
                var occurrences = parseFloat($('#occurrences').val());
                var average = parseFloat((likelihood + occurrences) / 2).toFixed(2);

                $('#prob_rating').val(average).trigger('change');
            }
            function refreshBenRating() {
                var potential_for_new_business = parseFloat($('#potential_for_new_business').val());
                var potential_expansion_of_current_business = parseFloat($('#potential_expansion_of_current_business').val());
                var potential_improvement_in_satisfying_regulations = parseFloat($('#potential_improvement_in_satisfying_regulations').val());
                var potential_improvement_to_internal_qms_processes = parseFloat($('#potential_improvement_to_internal_qms_processes').val());
                var improvement_to_company_reputation = parseFloat($('#improvement_to_company_reputation').val());
                var potential_cost_of_implementation = parseFloat($('#potential_cost_of_implementation').val());
                var post_implementation_success = parseFloat($('#post_implementation_success').val());

                var average = parseFloat((potential_for_new_business + potential_expansion_of_current_business + potential_improvement_in_satisfying_regulations + potential_improvement_to_internal_qms_processes + improvement_to_company_reputation + potential_cost_of_implementation + post_implementation_success) / 7).toFixed(2);

                $('#ben_rating').val(average).trigger('change');
            }
            function refreshOppFactor() {
                var prob_rating = parseFloat($('#prob_rating').val());
                var ben_rating = parseFloat($('#ben_rating').val());

                var rating = parseFloat(prob_rating * ben_rating).toFixed(2);

                $('#opp_factor').val(rating).trigger('change');

                if (rating > 8) {
                    $('#opp_factor').css('background-color', '#35c500');
                }
                else {
                    $('#opp_factor').css('background-color', 'initial');
                }
            }
        });
    </script>
@endsection
