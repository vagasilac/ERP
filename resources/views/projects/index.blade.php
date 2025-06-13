@extends('app')

@section('title') {{ trans('Proiecte') }} <a href="{{ action('ProjectsController@create') }}" class="action pull-right"><i class="fa fa-plus"></i> {{ trans('Adaugă proiect nou') }}</a> @endsection

@section('content')
    <div class="content-fluid">
        <div id="actions-bar-before"></div>
        <div class="actions-bar clearfix" id="actions-bar" data-target="#projects-table">
            <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>
                @can ('Projects - Projects delete')
                    <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                @endcan
            </div>
        </div>
        <div class="filters-bar clearfix" data-target="#projects-table">
            <div class="col-xs-12">
                <form action="" method="get" class="form-inline filters">
                    <div class="form-group marginR15">
                        <label class="control-label">{{ trans('Denumire proiect') }}</label>
                        <input class="form-control input-lg keyup-filter" name="search" type="text"  />
                    </div>
                    <div class="form-group marginR15">
                        <label class="control-label">{{ trans('Client') }}</label>
                        <input class="form-control input-lg has-combobox" name="customer" type="text" data-autocomplete-src="{{ action('CustomersController@get_customers') }}" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" />
                    </div>
                    <div class="form-group marginR15">
                        <label class="control-label input-with-icon">{{ trans('Data creării') }}</label>
                        <input class="form-control input-lg has-daterangepicker" type="text" name="created_date" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{ trans('Status') }}</label>
                        <select class="form-control" name="type">
                            <option></option>
                            <option value="offer">{{ trans('Ofertă') }}</option>
                            <option value="work">{{ trans('În lucru') }}</option>
                            <option value="executed">{{ trans('Executat') }}</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive marginT30 list-container">
            @include('projects._projects_list')
        </div>
    </div>
@endsection

@section('content-modals')
    <div class="modal fade" id="delete-modal">
        {!! Form::open(['action' => ['ProjectsController@multiple_destroy'], 'method' => 'DELETE']) !!}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Ștergere proiecte') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('Doriți să ștergeți aceste proiecte') }}
                    <div class="inputs-container"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('Închide') }}</button>
                    {!! Form::button(trans('Șterge'), ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('content-scripts')

    <script type="application/javascript">
        apply_filters(jQuery('.list-container'));

        jQuery(document).ready(function ($) {
            /**
             * Show details
             */
            $(document).on('click', '.show-details', function(e) {
                $(this).toggleClass('collapsed');
            });

            /**
             * Add affix to actions bar
             */
            $('#actions-bar').affix({
                offset: {
                    top: function() {
                        var position = $('#actions-bar-before').offset();
                        return position.top;
                    }
                }
            });
        });
    </script>
    @include('projects._daterangepicker')
@endsection
