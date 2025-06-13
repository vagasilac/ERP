@extends('app')

@section('title') {{ trans('Editare') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model($item, ['action' => ['InputsOutputsRegisterController@update', $item->id], 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header no-border col-xs-12">
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
                <div class="form-group @if ($errors->has('description')) has-error @endif">
                    {!! Form::label('description', trans('Denumire/Conținut') , ['class'=> 'control-label']) !!}
                    {!! Form::text('description', null, ['class' => 'form-control']) !!}
                    @if ($errors->has('description'))
                        <span class="help-block">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::label('date', trans('Data ieșirii'), ['class'=> 'control-label input-with-icon']) !!}
                    {!! Form::text('date', $item->date->format('d-m-Y'), ['class' => 'form-control has-datepicker']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('receiver', trans('Destinatar'), ['class'=> 'control-label']) !!}
                    {!! Form::text('receiver', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('InputsOutputsRegisterController@get_receivers'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'name']) !!}
                </div>
                <div class="form-group focused">
                    {!! Form::label('target', trans('Proiect(e) aferent(e)'), ['class'=> 'control-label small-label']) !!}
                    {!! Form::text('target', null , ['class' => 'form-control token-input']) !!}
                </div>

                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>

                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal" data-type="output"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>

                <div class="table-responsive">
                    @include('io_register._documents_list', ['documents' => $output_documents])
                </div>
            </div>
            <div class="tab-pane" id="input-container" role="tabpanel">
                <div class="form-group">
                    {!! Form::label('received_date', trans('Data rezolvării'), ['class'=> 'control-label input-with-icon']) !!}
                    {!! Form::text('received_date', $item->received_date != null ? $item->received_date->format('d-m-Y') : null, ['class' => 'form-control has-datepicker']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('invoice_number', trans('Nr. factură'), ['class'=> 'control-label']) !!}
                    {!! Form::text('invoice_number', null , ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('notice_number', trans('Nr. aviz'), ['class'=> 'control-label']) !!}
                    {!! Form::text('notice_number', null , ['class' => 'form-control']) !!}
                </div>

                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>

                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal"  data-type="input"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>

                <div class="table-responsive">
                    @include('io_register._documents_list', ['documents' => $input_documents])
                </div>
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
        {!! Form::open(['action' => ['InputsOutputsRegisterController@documents_multiple_destroy', $item->id], 'method' => 'DELETE']) !!}
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
            $('.token-input').tokenInput('{{ action('InputsOutputsRegisterController@get_projects') }}', {
                hintText : '{{ trans( 'Introduceți termenul de căutare') }}',
                minChars : 0,
                noResultsText : '{{ trans( 'Niciun rezultat') }}',
                @if ($item->target != '' && count($targets = explode(',', $item->target)) > 0)
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

            $('.upload-btn').click(function() {
                setDropzoneUpload("{{ action('InputsOutputsRegisterController@documents_upload', [$item->id]) }}" + '?type=' + $(this).data('type'));
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
@endsection
