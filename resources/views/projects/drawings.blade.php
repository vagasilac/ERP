@extends('app')

@section('title') @include('projects._header') @endsection

@section('content')
    <div class="sidebar">
        @include('projects._sidebar')
    </div>
    <div class="content-fluid offset">
        <div class="paddingL15 paddingR15">
            {!! Form::open(['action' => ['ProjectsController@drawings_update', $project->id], 'id' => 'saveForm', 'class' => 'relative']) !!}
                <div class="page-header col-xs-12 paddingL0 marginB0">
                    <h2>{{ trans('Desene') }}</h2>
                    @include('projects._buttons')
                </div>
                <div class="clearfix"></div>

                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#drawings-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>
                        @can ('Projects - Delete drawings')
                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                        @endcan

                        <div class="pull-left marginL10"><button class="btn btn-default" type="submit" name="send-qa" value="1">{{ trans('Trimite în atenția CTC pentru verificare') }}</button></div>
                        <div class="pull-left marginL10"><button class="btn btn-default" type="submit" name="remove-qa" value="1">{{ trans('Elimină din lista trimisă către CTC') }}</button></div>
                    </div>
                </div>

                @can ('Projects - Add drawings')
                    <a class="btn btn-sm btn-default marginT15 marginB15" type="button" data-toggle="modal" data-target="#upload-modal"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare desene') }}</a>
                @endcan

                <div class="table-responsive">
                    @include('projects._drawings_list')
                </div>

            {!! Form::close() !!}
        </div>
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
        {!! Form::open(['action' => ['ProjectsController@drawings_multiple_destroy', $project->id], 'method' => 'DELETE']) !!}
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

    @if (count($project->drawings) > 0)
        @foreach ($project->drawings as $k => $file)
            <div class="modal fade show-file-modal" id="show-file-modal{{ $file->id }}">
                {!! Form::open(['action' => ['ProjectsController@drawings_multiple_destroy', $project->id], 'method' => 'DELETE']) !!}
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" >{{ trans('Șterge fișiere') }}</h4>
                        </div>
                        <div class="modal-body">
                            <iframe src="about:blank" data-src="http://sharecad.org/cadframe/load?url={{ action('FilesController@show', ['id' => $file->file_id, 'name' =>$file->name]) }}" scrolling="no" width="100%" height="400" id="file-iframe-{{$file->id}}"></iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                            {!! Form::button('Șterge', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        @endforeach
    @endif

    <iframe src="about:blank" data-src="http://sharecad.org/cadframe/load?url=http://steiger.error404.ro/img/temp.dwg" scrolling="no" width="100%" height="400" id="file-iframe-temp"></iframe>
@endsection

@section('content-scripts')
    <script src="{{ asset('js/dropzone.min.js') }}"></script>

    <script type="application/javascript">
        setDropzoneUpload("{{ action('ProjectsController@drawings_upload', $project->id) }}");
    </script>
@endsection