@extends('app')

@section('title') {{ trans('Angajați') }} <a href="{{ action('UsersController@create') }}" class="action pull-right"><i class="fa fa-plus"></i> {{ trans('Adaugă utilizator nou') }}</a> @endsection

@section('content')
    <div class="content-fluid">
        <div class="actions-bar clearfix" data-target="#users-table">
            <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>
                @can ('Users delete')
                <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal" title="{{ trans('Ștergere') }}"><i class="material-icons">&#xE872;</i></a></div>
                <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#deactivation-modal" title="{{ trans('Dezactivare') }}"><i class="material-icons">&#xE572;</i></a></div>
                @endcan
            </div>
        </div>
        <div class="filters-bar clearfix" data-target="#users-table">
            <div class="col-xs-12">
                <form action="" method="get" class="form-inline filters">
                    <div class="form-group marginR15">
                        <label class="control-label">{{ trans('Nume angajat') }}</label>
                        <input class="form-control input-lg keyup-filter" name="name" type="text"  />
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{ trans('Rol') }}</label>
                        <select class="form-control" name="role">
                            <option value="0">{{ trans('Toate') }}</option>
                            <optgroup label="------------------"></optgroup>
                            @if (count($roles) > 0)
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ trans($role->name) }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{ trans('Stare') }}</label>
                        <select class="form-control" name="status">
                            <option value="0">{{ trans('Toate') }}</option>
                            <optgroup label="------------------"></optgroup>
                            <option value="active">{{ trans('Activ') }}</option>
                            <option value="inactive">{{ trans('Inactiv') }}</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive marginT30 list-container">
            @include('users._users_list');
        </div>
    </div>
@endsection


@section('content-modals')
    <div class="modal fade" id="delete-modal">
        {!! Form::open(['action' => ['UsersController@multiple_destroy'], 'method' => 'DELETE']) !!}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Ștergere angajați') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('Doriți să ștergeți acești angajați') }}
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
    <div class="modal fade" id="deactivation-modal">
        {!! Form::open(['action' => ['UsersController@deactivation'], 'method' => 'POST']) !!}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Dezactivarea utilizatorilor') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('Doriți să dezactivați acești utilizatori') }}
                    <div class="inputs-container"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Dezactivare', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('content-scripts')
    <script type="application/javascript">
        apply_filters(jQuery('.list-container'));
    </script>
@endsection