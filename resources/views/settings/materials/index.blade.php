@extends('app')

@section('title') {{ trans('Materiale') }} <a href="{{ action('SettingsController@materials_create', $type) }}" class="action pull-right"><i class="fa fa-plus"></i> {{ trans('Adaugă material nou') }}</a> @endsection

@section('content')
    <div class="content-fluid">
        <div class="actions-bar clearfix" data-target="#materials-table">
            <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>
                @can ('Settings - Materials delete')
                <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                @endcan
            </div>
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs marginT30 marginB30" role="tablist">
            <li role="presentation" @if ($type == 'main') class="active" @endif><a href="{{ action('SettingsController@materials', 'main') }}">{{ trans('Materiale principale') }}</a></li>
            <li role="presentation" @if ($type == 'auxiliary') class="active" @endif><a href="{{ action('SettingsController@materials', 'auxiliary') }}">{{ trans('Materiale auxiliare') }}</a></li>
            <li role="presentation" @if ($type == 'paint') class="active" @endif><a href="{{ action('SettingsController@materials', 'paint') }}">{{ trans('Vopsire') }}</a></li>
            <li role="presentation" @if ($type == 'assembly') class="active" @endif><a href="{{ action('SettingsController@materials', 'assembly') }}">{{ trans('Materiale pentru montaj') }}</a></li>
            <li role="presentation" @if ($type == 'other') class="active" @endif><a href="{{ action('SettingsController@materials', 'other') }}">{{ trans('Alte materiale') }}</a></li>
        </ul>
        <div class="filters-bar clearfix" data-target="#materials-table">
            <div class="col-xs-12">
                <form action="" method="get" class="form-inline filters">
                    <div class="form-group marginR15">
                        <label class="control-label">{{ trans('Denumire material') }}</label>
                        <input class="form-control input-lg keyup-filter" name="search" type="text"  />
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive marginT30 list-container">
            @include('settings.materials._materials_list');
        </div>
    </div>
@endsection


@section('content-modals')
    <div class="modal fade" id="delete-modal">
        {!! Form::open(['action' => ['SettingsController@materials_multiple_destroy'], 'method' => 'DELETE']) !!}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Șterge materiale') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('Doriți să ștergeți aceste materiale') }}
                    <div class="inputs-container"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Șterge', ['class' => 'btn btn-danger', 'type' => 'susubmit']) !!}
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