@extends('app')

@section('title') @include('projects._header') @endsection

@section('content')
    <div class="sidebar">
        @include('projects._sidebar')
    </div>
    <div class="content-fluid offset">
        <div class="paddingL15 paddingR15">
            {!! Form::open(['action' => ['ProjectsController@drawings_qa_download_templates', $project->id], 'id' => 'drawingsForm', 'class' => 'relative']) !!}
            <div class="page-header col-xs-12 paddingL0 marginB0">
                <h2>{{ trans('Desene') }}</h2>
                @include('projects._buttons')
            </div>
            <div class="clearfix"></div>

            <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#drawings-table">
                <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                    <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                    <div class="form-inline">
                        {!! Form::select('template', ['F-02-02' => 'F-02-02', 'F-02-03' => 'F-02-03', 'F-02-04' => 'F-02-04', 'F-02-08' => 'F-02-08'], null, ['class' => 'form-control without-label pull-left', 'style' => 'min-width: 110px']) !!}
                        <div class="pull-left marginL10"><button class="btn btn-default" type="submit" name="download-template" value="1">{{ trans('Descarcă șablon') }}</button></div>
                    </div>

                </div>
            </div>

            <div class="table-responsive marginT60">
                @include('projects._drawings_qa_list')
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('content-modals')
    @if (count($project->drawings) > 0)
        @foreach ($project->drawings as $k => $file)
            @if (count($file->quality_control_drawings) > 0)
                <div class="modal fade" id="upload-modal{{ $file->id }}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" >{{ trans('Încărcare fișiere') }}</h4>
                            </div>
                            <div class="modal-body dropzone-upload" id="dropzone-upload{{ $file->id }}">
                                <div class="dz-drag-message">{{ trans('Drag & drop fișierele sau directoarele pe care doriți să le încărcați') }}</div>
                                {!! Form::hidden('_token', csrf_token()) !!}
                                <div class="files" id="dropzone-previews{{ $file->id }}">

                                    <div id="dropzone-template{{ $file->id }}" class="file-row">
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
                            <div class="modal-footer" id="actions{{ $file->id }}">
                                <span class="fileupload-process hidden">
                                  <div id="total-progress{{ $file->id }}" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                      <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                  </div>
                                </span>
                                <span class="btn btn-primary fileinput-button{{ $file->id }}">
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

                @if (count($file->quality_control_drawings) > 0)
                    @foreach ($file->quality_control_drawings as $k => $qa_file)
                        <div class="modal fade" id="delete-modal{{ $qa_file->id }}">
                            {!! Form::open(['action' => ['ProjectsController@drawings_qa_file_destroy', $project->id], 'method' => 'DELETE']) !!}
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" >{{ trans('Șterge fișiere') }}</h4>
                                    </div>
                                    <div class="modal-body">
                                        {{ trans('Doriți să ștergeți aceste fișiere') }}
                                        <div class="inputs-container"></div>
                                        {!! Form::hidden('id', $qa_file->id) !!}
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
            @endif
        @endforeach
    @endif


@endsection

@section('content-scripts')
    <script src="{{ asset('js/dropzone.min.js') }}"></script>

    <script type="application/javascript">
        @if (count($project->drawings) > 0)
            @foreach ($project->drawings as $k => $file)
                @if (count($file->quality_control_drawings) > 0)
                    setDropzoneUpload("{{ action('ProjectsController@drawings_qa_upload', $project->id) }}", "{{ $file->id }}");
                @endif
            @endforeach
        @endif

        jQuery(document).ready(function($) {
            //hide save button
            $('#save-page-btn').hide();

            //change save button
            $('input[type="checkbox"]').on('change', function() {
                $('input[type="checkbox"]').not(this).prop('checked', false);
            });
        });
    </script>
@endsection