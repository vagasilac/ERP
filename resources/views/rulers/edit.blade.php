@extends('app')

@section('title') {{ trans('Editare') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model($item, ['action' => ['RulersController@update', $item->id], 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header no-border col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('RulersController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <!-- Nav tabs -->
        <div class="col-xs-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#general-container"  aria-controls="general-container" role="tab" data-toggle="tab">{{ trans('Informații generale') }}</a></li>
                <li role="presentation"><a href="#documents-container"  aria-controls="documents-container" role="tab" data-toggle="tab">{{ trans('Dovezi de etalonare') }}</a></li>
            </ul>
        </div>

        <div class="tab-content col-xs-12 marginT30">
            <div class="tab-pane active" id="general-container" role="tabpanel">
                <div class="col-xs-12 col-sm-6 marginR15">
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('Name', trans('Denumirea') , ['class'=> 'control-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('inventory_number', trans('Identificare'), ['class'=> 'control-label']) !!}
                        {!! Form::text('inventory_number', null , ['class' => 'form-control']) !!}
                        @if ($errors->has('inventory_number'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('measuring_range', trans('Domeniu de măsurare'), ['class'=> 'control-label small-label']) !!}
                        {!! Form::text('measuring_range', null , ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('user', trans('Utilizator') , ['class'=> 'control-label label-req']) !!}
                        {!! Form::text('user', !is_null($item->user) ? $item->user->name() : null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('UsersController@get_users'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'name', 'data-autocomplete-default-value' => old('secondary_responsible')]) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <h4 class="marginT0">{{ trans('Fotografie') }}</h4>
                    <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }} row clearfix">
                        @if ($item->photo)
                            <div class="marginB15 col-xs-3" id="image-container">
                                <img class="marginB5 block img-responsive img-circle" src="{{ action('FilesController@image', base64_encode('ims/rulers/'.$item->id.'/photos/thumbnails/'.$item->photo)) }}" alt="{{ $item->photo }}" />
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
            <div class="tab-pane" id="documents-container" role="tabpanel">
                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>
                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>
                <div class="table-responsive">
                    @include('rulers._documents_list', ['documents' => $documents])
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@endsection

@section('content-modals')
    <div class="modal fade" id="image-delete-modal">
        {!! Form::open(['action' => ['RulersController@destroy_photo', $item->id], 'method' => 'DELETE']) !!}
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
        {!! Form::open(['action' => ['RulersController@documents_multiple_destroy', $item->id], 'method' => 'DELETE']) !!}
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
                setDropzoneUpload("{{ action('RulersController@documents_upload', [$item->id]) }}");
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

