@extends('app')

@section('title') {{ trans('Editare') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model($item, ['action' => ['MachinesController@update', $item->id], 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header no-border col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default pull-left']) !!}
                <a href="{{ action('MachinesController@index') }}" class="btn btn-secondary marginL10 marginR10 back-btn pull-left">{{ trans('Înapoi') }}</a>
                <span class="buttons-separator pull-left"></span>
                <a href="{{ action('MachinesController@qr_label', $item->id) }}" class="btn btn-primary marginL15 pull-left" target="_blank"><i class="material-icons">&#xE41D;</i> {{ trans('Descarcă eticheta') }}</a>
            </div>
        </div>

        <!-- Nav tabs -->
        <div class="col-xs-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#general-container"  aria-controls="coutput-container" role="tab" data-toggle="tab">{{ trans('Informații generale') }}</a></li>
                <li role="presentation"><a href="#machine-manuals-container"  aria-controls="machine-manuals-container-container" role="tab" data-toggle="tab">{{ trans('Cartea mașinii') }}</a></li>
                <li role="presentation"><a href="#revisions-container"  aria-controls="revisions-container-container" role="tab" data-toggle="tab">{{ trans('Revizii') }}</a></li>
                <li role="presentation"><a href="#photos-container"  aria-controls="photos-container" role="tab" data-toggle="tab">{{ trans('Poze') }}</a></li>
                <li role="presentation" id="maintenance-nav-item"><a href="#maintenance-container"  aria-controls="maintenance-container" role="tab" data-toggle="tab">{{ trans('Mentenanță') }}</a></li>
            </ul>
        </div>

        <div class="tab-content col-xs-12 marginT30">
            <div class="tab-pane row active" id="general-container" role="tabpanel">
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('name', trans('Denumire') , ['class'=> 'control-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('inventory_no')) has-error @endif">
                        {!! Form::label('inventory_no', trans('Număr de identificare') , ['class'=> 'control-label']) !!}
                        {!! Form::text('inventory_no', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('inventory_no'))
                            <span class="help-block">{{ $errors->first('inventory_no') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('source')) has-error @endif">
                        {!! Form::label('source', trans('Sursa') , ['class'=> 'control-label']) !!}
                        {!! Form::text('source', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('source'))
                            <span class="help-block">{{ $errors->first('source') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('manufacturing_year')) has-error @endif">
                        {!! Form::label('manufacturing_year', trans('Anul fabricației') , ['class'=> 'control-label']) !!}
                        {!! Form::number('manufacturing_year', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('manufacturing_year'))
                            <span class="help-block">{{ $errors->first('manufacturing_year') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('type')) has-error @endif">
                        {!! Form::label('type', trans('Tip') , ['class'=> 'control-label']) !!}
                        {!! Form::text('type', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('type'))
                            <span class="help-block">{{ $errors->first('type') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('power')) has-error @endif">
                        {!! Form::label('power', trans('Putere') . ' (kW)' , ['class'=> 'control-label']) !!}
                        {!! Form::text('power', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('power'))
                            <span class="help-block">{{ $errors->first('power') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('hourly_rate')) has-error @endif">
                        {!! Form::label('hourly_rate', trans('Manopera') . ' (&euro;/h)' , ['class'=> 'control-label']) !!}
                        {!! Form::number('hourly_rate', null, ['class' => 'form-control', 'step' => '0.01']) !!}
                        @if ($errors->has('hourly_rate'))
                            <span class="help-block">{{ $errors->first('hourly_rate') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('operation_id')) has-error @endif">
                        {!! Form::label('operation_id', trans('Operație'), ['class'=> 'control-label']) !!}
                        {!! Form::select('operation_id', array_merge([0 => ''], $operations->toArray()), null, ['class' => 'form-control']) !!}
                        @if ($errors->has('operation_id'))
                            <span class="help-block">{{ $errors->first('operation_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('maintenance_log', trans('Jurnal de mentenanta'), ['class' => 'control-label']) !!}
                        {!! Form::select('maintenance_log', Config::get('machines.maintenance_log'), null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group @if ($errors->has('observations')) has-error @endif">
                        {!! Form::label('observations', trans('Observații') , ['class'=> 'control-label']) !!}
                        {!! Form::textarea('observations', null, ['class' => 'form-control', 'rows' => 2]) !!}
                        @if ($errors->has('observations'))
                            <span class="help-block">{{ $errors->first('observations') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <h4 class="marginT0">{{ trans('Fotografie') }}</h4>
                    <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }} row clearfix">
                        @if ($item->photo)
                            <div class="marginB15 col-xs-3" id="image-container">
                                <img class="marginB5 block img-responsive img-circle" src="{{ action('FilesController@image', base64_encode('ims/machines/' . $item->id . '/photos/thumbs/' . $item->photo)) }}" alt="{{ $item->photo }}" />
                            </div>
                        @endif
                        <div class="col-xs-9">
                            @if ($item->photo)
                                <a class="btn btn-danger marginT10" data-toggle="modal" data-target="#image-delete-modal">{{ trans('Șterge fotografia') }}</a>
                            @else
                                {!! Form::file('photo', ['class' => 'form-control']) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="machine-manuals-container" role="tabpanel">
                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#machine-manuals-files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>

                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal"  data-type="machine_manual"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>

                <div class="table-responsive">
                    @include('ims.machines._documents_list', ['documents' => $machine_manual_documents, 'table_id' => 'machine-manuals-files-table'])
                </div>
            </div>
            <div class="tab-pane" id="revisions-container" role="tabpanel">
                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#revision-files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>

                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal"  data-type="revision"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>

                <div class="table-responsive">
                    @include('ims.machines._documents_list', ['documents' => $revision_documents, 'table_id' => 'revision-files-table'])
                </div>
            </div>
            <div class="tab-pane" id="photos-container" role="tabpanel">
                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#photos-files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>

                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal"  data-type="photo"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>

                <div class="table-responsive">
                    @include('ims.machines._documents_list', ['documents' => $photos, 'table_id' => 'photos-files-table'])
                </div>
            </div>
            <div class="tab-pane" id="maintenance-container" role="tabpanel">
                @include('ims.machines._maintenance_calendar')
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

    <div class="modal fade" id="image-delete-modal">
        {!! Form::open(['action' => ['MachinesController@destroy_photo', $item->id], 'method' => 'DELETE']) !!}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Șterge fotografie') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('Doriți să ștergeți această fotografie?') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Șterge', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="modal fade" id="delete-modal">
        {!! Form::open(['action' => ['MachinesController@documents_multiple_destroy', $item->id], 'method' => 'DELETE']) !!}
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
                setDropzoneUpload("{{ action('MachinesController@documents_upload', [$item->id]) }}" + '?type=' + $(this).data('type'));
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
