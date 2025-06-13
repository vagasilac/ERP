@extends('app')

@section('title') {{ trans('Aprovizionare') }} / {{ trans('Magazie') }} @endsection

@section('content')
    <div class="content-fluid">
        <div id="actions-bar-before"></div>
        <div class="actions-bar clearfix" id="actions-bar" data-target="#materials-table">
            <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>
                <div class="pull-left marginL10"><a class="btn btn-default" id="send-offer-btn" data-toggle="modal" data-target="#send-to-supplier-modal">{{ trans('Trimite cerere către furnizor aprobat') }}</a></div>
                <div class="pull-left marginL10"><a class="btn btn-default" id="send-order">{{ trans('Trimite comandă') }}</a></div>
                <div class="pull-left marginL10"><a class="btn btn-default" id="receive-order-btn" data-toggle="modal" data-target="#reception-modal">{{ trans('Recepție materiale') }}</a></div>
            </div>
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs marginT30 marginB30" role="tablist">
            <li role="presentation" @if($type == 'main') class="active" @endif><a href="{{ action('InventoryController@index') }}">{{ trans('Materiale principale') }}</a></li>
            <li role="presentation" @if($type == 'auxiliary') class="active" @endif><a href="{{ action('InventoryController@index', ['type' => 'auxiliary']) }}">{{ trans('Materiale auxiliare') }}</a></li>
            <li role="presentation" @if($type == 'paint') class="active" @endif><a href="{{ action('InventoryController@index', ['type' => 'paint']) }}">{{ trans('Vopsire') }}</a></li>
            <li role="presentation" @if($type == 'assembly') class="active" @endif><a href="{{ action('InventoryController@index', ['type' => 'assembly']) }}">{{ trans('Materiale pentru montaj') }}</a></li>
            <li role="presentation" @if($type == 'other') class="active" @endif><a href="{{ action('InventoryController@index', ['type' => 'other']) }}">{{ trans('Alte materiale') }}</a></li>
        </ul>
        <div class="filters-bar clearfix" data-target="#materials-table">
            <div class="col-xs-12">
                <form action="" method="get" class="form-inline filters">
                    <div class="form-group marginR15">
                        <label class="control-label">{{ trans('Denumire material') }}</label>
                        <input class="form-control input-lg keyup-filter" name="search" type="text"  />
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{ trans('Status') }}</label>
                        <select name="status" class="form-control">
                            <option></option>
                            <option value="required">{{ trans("Necesar") }}</option>
                            <option value="offer_sent">{{ trans("Cerere de ofertă trimisă") }}</option>
                            <option value="offer_received">{{ trans("Ofertă primită") }}</option>
                            <option value="order_sent">{{ trans("Comandă trimisă") }}</option>
                            <option value="production">{{ trans("În producție") }}</option>
                            <option value="stock">{{ trans("În stoc") }}</option>
                        </select>
                    </div>
                    <div class="form-group marginR15">
                        <label class="control-label input-with-icon">{{ trans('Data') }}</label>
                        <input class="form-control input-lg has-daterangepicker" type="text" name="created_date" />
                    </div>
                    <div class="form-group marginR15">
                        <label class="control-label">{{ trans('Furnizor aprobat') }}</label>
                        <input class="form-control input-lg has-combobox" name="supplier" type="text" data-autocomplete-src="{{ action('SuppliersController@get_suppliers') }}" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" />
                    </div>
                    <div class="form-group marginR15">
                        <label class="control-label">{{ trans('Proiect') }}</label>
                        <input class="form-control input-lg has-combobox" name="project" type="text" data-autocomplete-src="{{ action('InventoryController@getAllProjects') }}" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" />
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive marginT30 list-container">
            @include('inventory._inventory_list')
        </div>
    </div>
@endsection

@section('content-modals')
    <!-- Demand info modal -->
    <div class="modal fade" id="demand-info-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="demand-modal-content">
                @include('inventory._demand_modal')
            </div>
        </div>
    </div>
    <!-- Stock info modal -->
    <div class="modal fade" id="stock-info-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="stock-info-content">

            </div>
        </div>
    </div>

    <!-- Materials received info modal -->
    <div class="modal fade" id="reception-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('Recepție materiale') }}</h4>
                </div>
                <div class="modal-body">
                    <form id="reception-modal-form">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="received_date">{{ trans('Data recepției') }}</label>
                                <input type="text" name="received_date" id="received_date" class="form-control has-datepicker" value="{{ date('Y-m-d') }}"/>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="invoice_number">{{ trans('Nr. factură') }}</label>
                                <input type="text" name="invoice_number" id="invoice_number" class="form-control"/>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="notice_number">{{ trans('Nr. aviz') }}</label>
                                <input type="text" name="notice_number" id="notice_number" class="form-control"/>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('Anulare') }}</button>
                    <button type="button" class="btn btn-success" id="reception-modal-btn">{{ trans('Salvare') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Register stock -->
    <div class="modal fade" id="stock-registration-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form id="registerStock" class="modal-content" action="/" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('Inregistrare in stock') }}</h4>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-sm-6">
                        <label for="quantity">{{ trans('Valoare') }}</label>
                        <input type="text" class="form-control" name="quantity" id="quantity"/>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="pieces">{{ trans('Bucăți') }}</label>
                        <input type="text" class="form-control" name="pieces" id="pieces"/>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="location">{{ trans('Locație') }}</label>
                        <input type="text" class="form-control" name="location" id="location"/>
                    </div>
                    <input type="hidden" id="stock_material_id" name="stock_material_id" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('Anulare') }}</button>
                    <input type="submit" class="btn btn-success" value="{{ trans('Salvare') }}" />
                </div>
            </form>
        </div>
    </div>

    <!-- Edit stock -->
    <div class="modal fade" id="stock-edit-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form id="editStock" class="modal-content" action="/" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('Modifică stoc') }}</h4>
                </div>
                <div class="modal-body" id="stock-edit-content">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('Anulare') }}</button>
                    <input type="submit" class="btn btn-success" value="{{ trans('Salvare') }}" />
                </div>
            </form>
        </div>
    </div>

    <!-- Send to supplier modal -->
    <div class="modal fade" id="send-to-supplier-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form class="modal-content" action="/" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('Trimite cerere către furnizor aprobat') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group ui-front">
                        <label class="control-label">{{ trans('Alege furnizor aprobat') }} 1</label>
                        <input class="form-control has-combobox" name="name[]" type="text" data-autocomplete-src="{{ action('SuppliersController@get_suppliers') }}" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" />
                    </div>
                    <div class="form-group ui-front">
                        <label class="control-label">{{ trans('Alege furnizor aprobat') }} 2</label>
                        <input class="form-control has-combobox" name="name[]" type="text" data-autocomplete-src="{{ action('SuppliersController@get_suppliers') }}" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" />
                    </div>
                    <div class="form-group ui-front send-to-supplier-clone">
                        <label class="control-label">{{ trans('Alege furnizor aprobat') }} 3</label>
                        <input class="form-control has-combobox" name="name[]" type="text" data-autocomplete-src="{{ action('SuppliersController@get_suppliers') }}" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="name" />
                    </div>
                    <a href="#" id="add-supplier-to-modal">+ {{ trans('Adaugă furnizor aprobat') }}</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('Anulare') }}</button>
                    <button type="button" class="btn btn-success" id="send-to-supplier-btn">{{ trans('Trimitere') }}</button>
                    <button type="button" class="btn btn-primary" id="preview-send-to-supplier-btn">{{ trans('Previzualizare') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Set prices modal -> offer_received -->
    <div class="modal fade" id="set-offer-received-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form id="setOffer" class="modal-content" action="{{ action('InventoryController@setOffer') }}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('Editare prețuri') }}</h4>
                </div>
                <div class="modal-body">
                    <div id="offer-received-body">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('Anulare') }}</button>
                    <input type="submit" class="btn btn-success" value="{{ trans('Salvare') }}"/>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            </form>
        </div>
    </div>

    <!-- Set prices modal -> send offer -->
    <div class="modal fade" id="set-prices-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content" action="/" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('Editare prețuri') }}</h4>
                </div>
                <div class="modal-body">
                    <div id="offer-received-body">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('Anulare') }}</button>
                    <button type="button" class="btn btn-success">{{ trans('Salvare') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- CTC modal -->
    <div class="modal fade" id="ctc-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content" action="{{ action('InventoryController@setCtc') }}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('Date CTC') }}</h4>
                </div>
                <div class="modal-body" id="ctc-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('Anulare') }}</button>
                    <input type="submit" class="btn btn-success" value="{{ trans('Salvare') }}"/>
                </div>
            </form>
        </div>
    </div>

    <!-- Reserve stock modal -->
    <div class="modal fade" id="reserve-stock-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content" action="{{ action('InventoryController@reserveStock') }}" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('Rezervare') }}</h4>
                </div>
                <div class="modal-body" id="reserve-stock-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('Anulare') }}</button>
                    <input type="submit" class="btn btn-success" value="{{ trans('Salvare') }}"/>
                </div>
            </form>
        </div>
    </div>


    <!-- Send order modal -->
    <div class="modal fade" id="send-order-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form id="send-order-form" class="modal-content" action="{{ action('InventoryController@sendOrder') }}" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('Trimite comandă') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="send-order-body">

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('Anulare') }}</button>
                    <input type="submit" class="btn btn-success" value="{{ trans('Trimitere') }}"/>
                    <button type="button" class="btn btn-primary" id="preview-order-btn">{{ trans('Previzualizare') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('content-scripts')
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script type="application/javascript">

        jQuery(document).ready(function($) {
            $('.has-daterangepicker').daterangepicker({
                "locale": {
                    "direction": "ltr",
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "{{ trans('Aplică') }}",
                    "cancelLabel": "{{ trans('Anulează') }}",
                    "fromLabel": "{{ trans('de la') }}",
                    "toLabel": "{{ trans('până la') }}",
                    "customRangeLabel": "{{ trans('Personalizat') }}",
                    "daysOfWeek": [
                        "{{ trans('Du') }}",
                        "{{ trans('Lu') }}",
                        "{{ trans('Ma') }}",
                        "{{ trans('Mi') }}",
                        "{{ trans('Jo') }}",
                        "{{ trans('Vi') }}",
                        "{{ trans('Sâ') }}"
                    ],
                    "monthNames": [
                        "{{ trans('Ianuarie') }}",
                        "{{ trans('Februarie') }}",
                        "{{ trans('Martie') }}",
                        "{{ trans('Aprilie') }}",
                        "{{ trans('Mai') }}",
                        "{{ trans('Iunie') }}",
                        "{{ trans('Iulie') }}",
                        "{{ trans('August') }}",
                        "{{ trans('Septembrie') }}",
                        "{{ trans('Octombrie') }}",
                        "{{ trans('Noiembrie') }}",
                        "{{ trans('Decembrie') }}"
                    ],
                    "firstDay": 1
                },
                "ranges": {
                    "{{ trans('Astăzi') }}": [moment(), moment()],
                    "{{ trans('Ultimele 7 zile') }}": [moment().subtract(6, 'days'), moment()],
                    "{{ trans('Ultimele 30 zile') }}": [moment().subtract(29, 'days'), moment()],
                    "{{ trans('Luna aceasta') }}": [moment().startOf('month'), moment().endOf('month')],
                    "{{ trans('Ultimele 6 luni') }}": [moment().subtract(6, 'month'), moment()],
                    "{{ trans('Acest an') }}": [moment().startOf('year'), moment()]
                },
                "autoUpdateInput": false,
                "alwaysShowCalendars": true
            });

            $('.has-daterangepicker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                $(this).blur().change();
            });

            $('.has-daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                $(this).blur().change();
            });

            /**
             * Select child rows
             **/
            $(document).on('click', 'table .select, table .select-parent', function(e){
                var children = $(this).data('children');

                if ($(this).is(":checked")) {
                    $(this).closest('tr').addClass('active');
                    $('.'+children).prop('checked', true).closest('tr').addClass('active');

                }
                else {
                    $(this).closest('tr').removeClass('active');
                    $('.'+children).prop('checked', false).closest('tr').removeClass('active');
                }

                var selected_items = $(this).closest('table').find('tr > td > input[type="checkbox"].select:checked').length;
                var actions_bar = $('.actions-bar[data-target="#' + $(this).parents('table').attr('id') + '"]');

                //show/hide action bar
                if (selected_items > 0) {
                    actions_bar.find('.count').html(selected_items);
                    actions_bar.show();
                }
                else {
                    actions_bar.find('.count').html(0);
                    actions_bar.hide();
                }

                //Enable/disable action buttons by checkbox values
                status_counts = [];
                $('#materials-table').find('tbody tr .select').each(function(){
                    if($(this).is(':checked')){
                        if(status_counts[$(this).attr('data-status')]){
                            status_counts[$(this).attr('data-status')]++;
                        }
                        else{
                            status_counts[$(this).attr('data-status')] = 1;
                        }
                    }
                });

                if(((typeof(status_counts['necesar']) != 'undefined' && status_counts['necesar'] >= 1 && Object.keys(status_counts).length == 1) ||
                        (typeof(status_counts['offer_sent']) != 'undefined' && status_counts['offer_sent'] >= 1 && Object.keys(status_counts).length == 1) ) ||
                        (typeof(status_counts['necesar']) != 'undefined' && status_counts['necesar'] >= 1 && typeof(status_counts['offer_sent']) != 'undefined' && status_counts['offer_sent'] >= 1 && Object.keys(status_counts).length == 2) ||
                        (typeof(status_counts['necesar']) != 'undefined' && status_counts['necesar'] >= 1 && typeof(status_counts['offer_received']) != 'undefined' && status_counts['offer_received'] >= 1 && Object.keys(status_counts).length == 2) ||
                        (typeof(status_counts['offer_sent']) != 'undefined' && status_counts['offer_sent'] >= 1 && typeof(status_counts['offer_received']) != 'undefined' && status_counts['offer_received'] >= 1 && Object.keys(status_counts).length == 2) ||
                        (typeof(status_counts['necesar']) != 'undefined' && status_counts['necesar'] >= 1 && typeof(status_counts['offer_sent']) != 'undefined' && status_counts['offer_sent'] >= 1 && typeof(status_counts['offer_received']) != 'undefined' && status_counts['offer_received'] >= 1 && Object.keys(status_counts).length == 3) ){
                    // only required material selected
                    $('#send-offer-btn').removeClass('hidden');
                    $('#send-order').addClass('hidden');
                    $('#receive-order-btn').addClass('hidden');
                }
                else{
                    if(typeof(status_counts['offer_received']) != 'undefined' && status_counts['offer_received'] >= 1 && Object.keys(status_counts).length == 1){
                        // only material with status offer_received
                        $('#send-order').removeClass('hidden');
                        $('#send-offer-btn').removeClass('hidden');
                        $('#receive-order-btn').addClass('hidden');
                    }
                    else{
                        $('#send-order').addClass('hidden');
                        $('#send-offer-btn').addClass('hidden');
                        // at least 1 material with different status than offer_received
                        if(typeof(status_counts['order_sent']) != 'undefined' && status_counts['order_sent'] >= 1 && Object.keys(status_counts).length == 1){
                            $('#receive-order-btn').removeClass('hidden');
                        }
                        else{
                            $('#receive-order-btn').addClass('hidden');
                        }
                    }
                }
            });

            var status_counts = [];
            /**
             * Enable/disable action buttons by checkbox values
             **/
            $(document).on('click', 'tbody tr .select', function(e){
                status_counts = [];
                $('#materials-table').find('tbody tr .select').each(function(){
                    if($(this).is(':checked')){
                        if(status_counts[$(this).attr('data-status')]){
                            status_counts[$(this).attr('data-status')]++;
                        }
                        else{
                            status_counts[$(this).attr('data-status')] = 1;
                        }
                    }
                });

                if(((typeof(status_counts['necesar']) != 'undefined' && status_counts['necesar'] >= 1 && Object.keys(status_counts).length == 1) ||
                        (typeof(status_counts['offer_sent']) != 'undefined' && status_counts['offer_sent'] >= 1 && Object.keys(status_counts).length == 1) ) ||
                        (typeof(status_counts['necesar']) != 'undefined' && status_counts['necesar'] >= 1 && typeof(status_counts['offer_sent']) != 'undefined' && status_counts['offer_sent'] >= 1 && Object.keys(status_counts).length == 2) ||
                        (typeof(status_counts['necesar']) != 'undefined' && status_counts['necesar'] >= 1 && typeof(status_counts['offer_received']) != 'undefined' && status_counts['offer_received'] >= 1 && Object.keys(status_counts).length == 2) ||
                        (typeof(status_counts['offer_sent']) != 'undefined' && status_counts['offer_sent'] >= 1 && typeof(status_counts['offer_received']) != 'undefined' && status_counts['offer_received'] >= 1 && Object.keys(status_counts).length == 2) ||
                        (typeof(status_counts['necesar']) != 'undefined' && status_counts['necesar'] >= 1 && typeof(status_counts['offer_sent']) != 'undefined' && status_counts['offer_sent'] >= 1 && typeof(status_counts['offer_received']) != 'undefined' && status_counts['offer_received'] >= 1 && Object.keys(status_counts).length == 3) ){
                    // only required material selected
                    $('#send-offer-btn').removeClass('hidden');
                    $('#send-order').addClass('hidden');
                    $('#receive-order-btn').addClass('hidden');
                }
                else{
                    if(typeof(status_counts['offer_received']) != 'undefined' && status_counts['offer_received'] >= 1 && Object.keys(status_counts).length == 1){
                        // only material with status offer_received
                        $('#send-order').removeClass('hidden');
                        $('#send-offer-btn').removeClass('hidden');
                        $('#receive-order-btn').addClass('hidden');
                    }
                    else{
                        $('#send-order').addClass('hidden');
                        $('#send-offer-btn').addClass('hidden');
                        // at least 1 material with different status than offer_received
                        if(typeof(status_counts['order_sent']) != 'undefined' && status_counts['order_sent'] >= 1 && Object.keys(status_counts).length == 1){
                            $('#receive-order-btn').removeClass('hidden');
                        }
                        else{
                            $('#receive-order-btn').addClass('hidden');
                        }
                    }
                }
            });

            /**
             * Demand info modal content
             */
            $(document).on('click', '.demand-info-open', function(e){
                var id = $(this).attr('data-id');

                $.ajax({
                    url: '{{ action('InventoryController@getProjects') }}',
                    type: 'POST',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response){
                        $('#demand-modal-content').html(response);
                        $('#demand-info-modal').modal();
                    }
                });
                e.preventDefault();
            });

            /**
             * Stock info modal
             **/
            $(document).on('click', '.stock-info-modal', function(e){
                var id = $(this).attr('data-id');

                $.ajax({
                    url: '{{ action('InventoryController@getStock') }}',
                    type: 'POST',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response){
                        $('#stock-info-content').html(response);
                        $('#stock-info-modal').modal();
                    }
                });
                e.preventDefault();
            });

            /**
             * CTC modal
             **/
            $(document).on('click', '.ctc-btn', function(e){
                var id = $(this).attr('data-id');

                $.ajax({
                    url: '{{ action('InventoryController@generateCtcModal') }}',
                    type: 'POST',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response){
                        $('#ctc-body').html(response);
                        $('#ctc-modal').modal();
                    }
                });
                e.preventDefault();
            });

            /**
             * Stock edit modal
             **/
            $(document).on('click', '.edit-stock', function(e){
                var id = $(this).attr('data-id');

                $.ajax({
                    url: '{{ action('InventoryController@editStock') }}',
                    type: 'GET',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response){
                        $('#stock-edit-content').html(response);
                        $('#stock-edit-modal').modal();
                    }
                });
                e.preventDefault();
            });

            /**
             * Offer received modal content
             **/
            $(document).on('click', '.offer-received', function(e){
                var id = $(this).attr('data-id');

                $.ajax({
                    url: '{{ action('InventoryController@generateOfferReceivedModal') }}',
                    type: 'POST',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response){
                        $('#offer-received-body').html(response);
                        initDatePicker();
                        $('#set-offer-received-modal').modal();
                    }
                });
                e.preventDefault();
            });

            /**
             * Send order modal
             **/
            $(document).on('click', '#send-order', function(e){
                var materials = [];
                $('#materials-table').find('tbody tr .select').each(function(){
                    if($(this).is(':checked')) materials.push($(this).attr('data-id'));
                });

                $.ajax({
                    url: '{{ action('InventoryController@generateSendOrderModal') }}',
                    type: 'POST',
                    data: {
                        materials: materials,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response){
                        $('#send-order-body').html(response);
                        $('#send-order-modal').modal();
                    }
                });

                e.preventDefault();
            });

            /**
             * Reserve stock modal
             **/
            $(document).on('click', '.reserve-stock', function(e){
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ action('InventoryController@generateReserveStockModal') }}',
                    type: 'POST',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response){
                        $('#reserve-stock-body').html(response);
                        $('#reserve-stock-modal').modal();
                    }
                });

                e.preventDefault();
            });

            /**
             * Materials received
             **/
            $(document).on('click', '#reception-modal-btn', function(e){
                var materials = [];
                $('#materials-table').find('tbody tr .select').each(function(){
                    if($(this).is(':checked')) materials.push($(this).attr('data-id'));
                });
                var $form = $('#reception-modal-form');
                var invoice_number = $form.find('#invoice_number').val();
                var notice_number = $form.find('#notice_number').val();
                var received_date = $form.find('#received_date').val();

                $.ajax({
                    url: '{{ action('InventoryController@materialsReceived') }}',
                    type: 'POST',
                    data: {
                        materials: materials,
                        invoice_number: invoice_number,
                        notice_number: notice_number,
                        received_date: received_date,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response){
                        if(response.status == 'ok'){
                            $('#reception-modal').modal('hide').on('hidden.bs.modal', function(e){
                                location.reload();
                            });
                        }
                    }
                });

                e.preventDefault();
            });

            /**
             * Add furnizor aprobat to modal
             */
            $(document).on('click', '#add-supplier-to-modal', function(e){
                var $modal = $('#send-to-supplier-modal');
                var $newSupplier = $modal.find('.send-to-supplier-clone').clone();
                $modal.find('.send-to-supplier-clone').removeClass('send-to-supplier-clone');
                var counter = $newSupplier.find('.control-label').html().match(/\d+$/)[0];
                counter++;
                $newSupplier.find('.control-label').html('Alege furnizor aprobat '+counter);
                $(this).before($newSupplier);
                initComboBox();
                e.preventDefault();
            });

            /**
             * Send offer to supplier
             */
            $(document).on('click', '#send-to-supplier-btn', function(e){
                var suppliers = [];
                var materials = [];
                $('#send-to-supplier-modal').find('.form-group input[type=hidden]').each(function(){
                   if($(this).val() != 'undefined' && $(this).val().trim() != '') {
                       if(suppliers.indexOf($(this).val()) == -1)
                            suppliers.push($(this).val());
                   }
                });

                $('#materials-table').find('tbody tr .select').each(function(){
                    if($(this).is(':checked')) materials.push($(this).attr('data-id'));
                });

                $.ajax({
                    url: '{{ action('InventoryController@sendOffer') }}',
                    type: 'POST',
                    data: {
                        suppliers: suppliers,
                        materials: materials,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response){
                        //@todo handle errors
                        $('#send-to-supplier-modal').modal('hide').on('hidden.bs.modal', function(e){
                            location.reload();
                        });
                    }
                });
                e.preventDefault();
            });

            /**
             * Preview offer
             */
            $(document).on('click', '#preview-send-to-supplier-btn', function(e){
                var THIS = $(this);
                var suppliers = [];
                var materials = [];
                $('#send-to-supplier-modal').find('.form-group input[type=hidden]').each(function(){
                    if($(this).val() != 'undefined' && $(this).val().trim() != '') {
                        if(suppliers.indexOf($(this).val()) == -1)
                            suppliers.push($(this).val());
                    }
                });

                $('#materials-table').find('tbody tr .select').each(function(){
                    if($(this).is(':checked')) materials.push($(this).attr('data-id'));
                });

                var form = $("<form></form>");
                form.attr('target', '_blank');
                form.attr('action', '{{ action('InventoryController@previewOffer') }}');
                form.attr('method', 'post');
                form.append('<input type="hidden" value="{{ csrf_token() }}" name="_token">');
                suppliers.forEach(function(item) {
                    form.append('<input type="hidden" value="' + item + '" name="suppliers[]">');
                });
                materials.forEach(function(item) {
                    form.append('<input type="hidden" value="' + item + '" name="materials[]">');
                });

                $('body').append(form);

                form.submit();
            });

            /**
             * Set offer prices
             */
            {{--$(document).on('submit', '#setOffer', function(e){--}}
                {{--$.ajax({--}}
                    {{--url: '{{ action('InventoryController@setOffer') }}',--}}
                    {{--type: 'POST',--}}
                    {{--data: $('#setOffer').serialize(),--}}
                    {{--success: function(response){--}}
                        {{--if(response.status == 'ok'){--}}
                            {{--$('#set-offer-received-modal').modal('hide').on('hidden.bs.modal', function(e){--}}
                                {{--location.reload();--}}
                            {{--});--}}
                        {{--}--}}

                    {{--}--}}
                {{--});--}}
                {{--e.preventDefault();--}}
            {{--});--}}

            /**
             * Open register stock modal
             */
            $(document).on('click', '.register-stock', function(e){
                var id = $(this).attr('data-id');
                $('#stock-registration-modal').modal().on('shown.bs.modal', function(e){
                   $('#stock_material_id').val(id);
                });
                e.preventDefault();
            });

            /**
             * Register stock form submit
             */
            $(document).on('submit', '#registerStock', function(e){
                $.ajax({
                    url: '{{ action('InventoryController@setStock') }}',
                    type: 'POST',
                    data: $('#registerStock').serialize(),
                    success: function(response){
                        if(response.status == 'ok'){
                            $('#stock-registration-modal').modal('hide').on('hidden.bs.modal', function(e){
                                location.reload();
                            });
                        }

                    }
                });
                e.preventDefault();
            });

            /**
             * Edit stock modal
             */
            $(document).on('submit', '#editStock', function(e){
                $.ajax({
                    url: '{{ action('InventoryController@editStock') }}',
                    type: 'POST',
                    data: $('#editStock').serialize(),
                    success: function(response){
                        if(response.status == 'ok'){
                            $('#stock-edit-modal').modal('hide').on('hidden.bs.modal', function(e){
                                location.reload();
                            });
                        }

                    }
                });
                e.preventDefault();
            });

            /**
             * Set offer prices
             */
            $(document).on('submit', '#send-order-form', function(e){
                $.ajax({
                    url: '{{ action('InventoryController@sendOrder') }}',
                    type: 'POST',
                    data: $('#send-order-form').serialize(),
                    success: function(response){
                        if(response.status == 'ok'){
                           location.reload();
                        }

                    }
                });
                e.preventDefault();
            });

            /**
             * Preview order
             */
            $(document).on('click', '#preview-order-btn', function(e){
                var THIS = $(this);

                var form = $("<form></form>");
                form.attr('target', '_blank');
                form.attr('action', '{{ action('InventoryController@previewOrder') }}');
                form.attr('method', 'post');

                $('#send-order-form input, #send-order-form select').each(function() {
                    form.append($(this).clone());
                });
                $('body').append(form);
                form.submit();

                /*
                var suppliers = [];
                var materials = [];
                $('#send-to-supplier-modal').find('.form-group input[type=hidden]').each(function(){
                    if($(this).val() != 'undefined' && $(this).val().trim() != '') {
                        if(suppliers.indexOf($(this).val()) == -1)
                            suppliers.push($(this).val());
                    }
                });

                $('#materials-table').find('tbody tr .select').each(function(){
                    if($(this).is(':checked')) materials.push($(this).attr('data-id'));
                });

                var form = $("<form></form>");
                form.attr('target', '_blank');
                form.attr('action', '{{ action('InventoryController@previewOffer') }}');
                form.attr('method', 'post');
                form.append('<input type="hidden" value="{{ csrf_token() }}" name="_token">');
                suppliers.forEach(function(item) {
                    form.append('<input type="hidden" value="' + item + '" name="suppliers[]">');
                });
                materials.forEach(function(item) {
                    form.append('<input type="hidden" value="' + item + '" name="materials[]">');
                });

                $('body').append(form);

                form.submit();*/
            });

            /**
             * Open CTC modal
             */
            $(document).on('click', '.ctc-btn', function(e){
                $('#ctc-body').find('#ctcid').val($(this).data('id'));
                $('#ctc-modal').modal('show');
                e.preventDefault();
            });


            /**
             * Show details
             */
            $(document).on('click', '.show-details, .show-hidden-rows', function(e) {
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
@endsection
