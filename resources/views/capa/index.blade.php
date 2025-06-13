@extends('app')

@section('title') {{ trans('Acțiuni corective si preventive') }} <a href="{{ action('CapasController@create') }}" class="action pull-right"><i class="fa fa-plus"></i> {{ trans('Adăugare') }}</a> @endsection

@section('content')
    <div class="content-fluid">
        <div class="actions-bar clearfix" data-target="#capa-table">
            <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>
                @can ('Capa delete')
                <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                @endcan
            </div>
        </div>
        <div class="filters-bar clearfix" data-target="#capa-table">
            <div class="col-xs-12">
                <form action="" method="get" class="form-inline filters">
                    <div class="form-group marginR15">
                        <label class="control-label">{{ trans('Căutare') }}</label>
                        <input class="form-control input-lg keyup-filter" name="search" type="text"  />
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{ trans('Tip') }}</label>
                        <select class="form-control" name="type">
                            <option value="0">{{ trans('Toate') }}</option>
                            <optgroup label="------------------"></optgroup>
                            @foreach(Config::get('capa.capa_form.capa_create.type') as $type)
                                <option value="{{ array_search($type, Config::get('capa.capa_form.capa_create.type')) }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{ trans('Sursă') }}</label>
                        <select class="form-control" name="source">
                            <option value="0">{{ trans('Toate') }}</option>
                            <optgroup label="------------------"></optgroup>
                            @foreach(Config::get('capa.capa_form.capa_create.source') as $type)
                                <option value="{{ array_search($type, Config::get('capa.capa_form.capa_create.source')) }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{ trans('Proces') }}</label>
                        <select class="form-control" name="process">
                            <option value="0">{{ trans('Toate') }}</option>
                            <optgroup label="------------------"></optgroup>
                            @foreach(App\Models\Process::orderBy('name')->get() as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive marginT30 list-container">
            @include('capa._capa_list');
        </div>
    </div>
@endsection


@section('content-modals')
    <div class="modal fade" id="delete-modal">
        {!! Form::open(['action' => ['CapasController@multiple_destroy'], 'method' => 'DELETE']) !!}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Ștergere') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('Doriți să ștergeți aceste înregistrări') }}
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
    </script>
@endsection
