@extends('app')

@section('title') @include('projects._header') @endsection

@section('content')
    <div class="sidebar">
        @include('projects._sidebar')
    </div>
    <div class="content-fluid offset">
        <div class="paddingL15 paddingR15">
            {!! Form::open(['action' => ['ProjectsController@subassembly_groups_update', $project->id], 'id' => 'saveForm', 'class' => 'relative']) !!}
                <div class="page-header col-xs-12  no-border paddingL0 marginB0">
                    <h2>{{ trans('Grupuri de (sub)ansamble') }}</h2>
                    @include('projects._buttons')
                </div>
                <div class="clearfix"></div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation"><a href="{{ action('ProjectsController@subassemblies', $project->id) }}">{{ trans('Lista (sub)ansamble') }}</a></li>
                    <li role="presentation" class="active"><a>{{ trans('Grupuri de (sub)ansamble') }}</a></li>
                </ul>

                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#subassembly-groups-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>
                        @can ('Projects - Delete subassembly groups')
                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                        @endcan
                    </div>
                </div>

                <div class="filters-bar transparent-filters-bar clearfix paddingT10 paddingB10" data-target="#subassembly-groups-table">
                    <div class="col-xs-12">
                        <div class="form-inline filters row clearfix">
                            <div class="form-group pull-right" style="padding-top: 7px">
                                @can ('Projects - Add subassemblies')
                                <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add-modal"><i class="material-icons">&#xE145;</i> {{ trans('Adaugă grupă de (sub)ansamblu') }}</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive list-container">
                    @include('projects._subassembly_groups_list')
                </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('content-modals')
    <div class="modal fade" id="add-modal">
        {!! Form::open(['action' => ['ProjectsController@subassembly_groups_store', $project->id], 'files' => true]) !!}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Adăugare grupă de (sub)ansamblu') }}</h4>
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
        {!! Form::open(['action' => ['ProjectsController@subassembly_groups_multiple_destroy', $project->id], 'method' => 'DELETE']) !!}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Șterge grupa de (sub)ansamblu') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('Doriți să ștergeți aceste grupe de (sub)ansamble?') }}
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

    @if (count($subassembly_groups) > 0)
        @foreach ($subassembly_groups as $k => $item)
            <div class="modal fade" id="add-responsible-{{ $item->id }}">
                {!! Form::open(['action' => ['ProjectsController@subassembly_groups_responsible_store', $project->id], 'files' => true]) !!}
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" >{{ trans('Adăugare responsabil') }}</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::hidden('_token', csrf_token()) !!}
                            {!! Form::hidden('group_id', $item->id) !!}
                            <div class="form-group  @if ($errors->has('name')) has-error @endif">
                                {!! Form::label('user', trans('Responsabil') , ['class'=> 'control-label label-req']) !!}
                                {!! Form::text('user', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('UsersController@get_users'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'name']) !!}
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

            @if (count($item->responsibles) > 0)
                @foreach ($item->responsibles as $responsible)

                <div class="modal fade" id="delete-responsible-modal-{{ $item->id }}-{{ $responsible->user->id }}">
                    {!! Form::open(['action' => ['ProjectsController@subassembly_groups_responsible_destroy', $project->id], 'method' => 'DELETE']) !!}
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            {!! Form::hidden('user_id', $responsible->user->id) !!}
                            {!! Form::hidden('group_id', $item->id) !!}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" >{{ trans('Șterge responsabil') }}</h4>
                            </div>
                            <div class="modal-body">
                                {{ trans('Doriți să ștergeți acest responsabil?') }}
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

                @endforeach
            @endif
        @endforeach
    @endif
@endsection

@section('content-scripts')
    <script type="application/javascript">
        @if ($errors->has('name'))
            jQuery('#add-modal').modal('show');
        @endif
    </script>
@endsection