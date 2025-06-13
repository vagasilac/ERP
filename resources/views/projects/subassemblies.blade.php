@extends('app')

@section('title') @include('projects._header') @endsection

@section('content')
    <div class="sidebar">
        @include('projects._sidebar')
    </div>
    <div class="content-fluid offset">
        <div class="paddingL15 paddingR15">
            {!! Form::open(['action' => ['ProjectsController@subassemblies_update', $project->id], 'id' => 'saveForm', 'class' => 'relative']) !!}
                <div class="page-header col-xs-12  no-border paddingL0 marginB0">
                    <h2>{{ trans('(Sub)ansamble') }}</h2>
                    @include('projects._buttons')
                </div>
                <div class="clearfix"></div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a>{{ trans('Lista (sub)ansamble') }}</a></li>
                    <li role="presentation"><a href="{{ action('ProjectsController@subassembly_groups', $project->id) }}" >{{ trans('Grupuri de (sub)ansamble') }}</a></li>
                </ul>

                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#subassemblies-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>
                        @can ('Projects - Delete subassemblies')
                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                        @endcan
                    </div>
                </div>


                <div class="filters-bar transparent-filters-bar clearfix paddingT10 paddingB10" data-target="#subassemblies-table">
                    <div class="col-xs-12">
                        <div class="form-inline filters row clearfix">
                            <div class="form-group">
                                <label class="control-label">{{ trans('Grupa') }}</label>
                                <select class="form-control" name="group">
                                    <option value="0">{{ trans('Toate') }}</option>
                                    <optgroup label="------------------"></optgroup>
                                    @if (count($project->subassembly_groups) > 0)
                                        @foreach ($project->subassembly_groups as $group)
                                            <option value="{{ $group->id }}">{{ trans($group->name) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group pull-right" style="padding-top: 7px">
                                @can ('Projects - Add subassemblies')
                                <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add-modal"><i class="material-icons">&#xE145;</i> {{ trans('Adaugă (sub)ansamblu') }}</a>
                                <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#upload-modal"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare fișier XLS (sub)ansamble') }}</a>
                                <a class="btn btn-sm btn-default" href="{{ asset('media/templates/subansamble.xlsx') }}" target="_blank"><i class="material-icons">&#xE2C4;</i> {{ trans('Descarcă șablon XLS (sub)ansamble') }}</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive list-container">
                    @include('projects._subassemblies_list')
                </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('content-modals')
    <div class="modal fade" id="upload-modal">
        {!! Form::open(['action' => ['ProjectsController@subassemblies_upload', $project->id], 'files' => true]) !!}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Încărcare fișiere') }}</h4>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('_token', csrf_token()) !!}
                    {!! Form::file('file', ['class' => 'form-control']) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Încarcă', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="modal fade" id="add-modal">
        {!! Form::open(['action' => ['ProjectsController@subassemblies_store', $project->id], 'files' => true]) !!}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Adăugare (sub)ansamblu') }}</h4>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('_token', csrf_token()) !!}
                    {!! Form::hidden('project_id', $project->id) !!}
                    <div class="form-group  @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('name', trans('Nume') , ['class'=> 'control-label label-req']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', trans('Descriere') , ['class'=> 'control-label']) !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 2]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('group_id', trans('Grupa'), ['class'=> 'control-label']) !!}
                        {!! Form::select('group_id', $groups, null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Salvează', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="modal fade" id="delete-modal">
        {!! Form::open(['action' => ['ProjectsController@subassemblies_multiple_destroy', $project->id], 'method' => 'DELETE']) !!}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Șterge (sub)ansamblu') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('Doriți să ștergeți aceste (sub)ansamble?') }}
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

@section('content-scripts')
    <script type="application/javascript">
        apply_filters(jQuery('.list-container'));

        @if ($errors->has('name'))
            jQuery('#add-modal').modal('show');
        @endif
    </script>
@endsection