@extends('app')

@section('title') {{ trans('Terminal atelier') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model(null, ['action' => ['TimeTrackingController@qr_tracking_store'], 'id' => 'start-form']) !!}
        <div class="col-xs-12 col-md-6 marginT30">
            {!! Form::hidden('type', 'start') !!}
            <div class="form-group  @if ($errors->has('qr_code')) has-error @endif">
                {!! Form::label('qr_code', trans('Cod QR') , ['class'=> 'control-label label-req']) !!}
                {!! Form::text('qr_code', null, ['class' => 'form-control']) !!}
                @if ($errors->has('qr_code'))
                    <span class="help-block">{{ $errors->first('qr_code') }}</span>
                @endif
            </div>

            <div id="qr_info"></div>

            <div class="pull-left">
                <a class="btn btn-success action-btn hidden" id="start-button"><i class="material-icons">&#xE037;</i> {{ trans('Start') }}</a>
                <a class="btn btn-secondary marginL5 action-btn hidden" id="pause-button"><i class="material-icons">&#xE034;</i> {{ trans('Pauză') }}</a>
                <a class="btn btn-primary marginL5 action-btn hidden" id="stop-button"><i class="material-icons">&#xE047;</i> {{ trans('Stop') }}</a>
            </div>
            <div class="pull-right">
                <a class="btn btn-default marginL5 action-btn hidden" id="view-drawing-button" target="_blank"><i class="material-icons">&#xE410;</i> {{ trans('Desen') }}</a>
                <a class="btn btn-default marginL5 action-btn hidden" id="view-maintenance-button" target="_blank"><i class="material-icons">&#xE616;</i> {{ trans('Calendarul de mentenanță') }}</a>
            </div>

        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('content-modals')
    <div class="modal fade" id="start-modal">
        {!! Form::open(['action' => ['TimeTrackingController@qr_tracking_store'], 'id' => 'modal-start-form']) !!}
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Start') }}</h4>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('type', 'start') !!}
                    <div class="form-group" >
                        {!! Form::label('note', trans('Observație') , ['class'=> 'control-label label-req']) !!}
                        {!! Form::textarea('note', null, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('supplier', trans('Subcontractant') , ['class'=> 'control-label label-req']) !!}
                        {!! Form::text('supplier', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('SuppliersController@get_suppliers'), 'data-autocomplete-data' => "data",  'data-autocomplete-id' => "id", 'data-autocomplete-value' => "long_name"]) !!}
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


    <div class="modal fade" id="pause-modal">
        {!! Form::open(['action' => ['TimeTrackingController@qr_tracking_store'], 'id' => 'pause-form']) !!}
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Pauză') }}</h4>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('type', 'pause') !!}
                    <div class="form-group" >
                        {!! Form::label('note', trans('Nr. terminate') , ['class'=> 'control-label label-req']) !!}
                        {!! Form::number('completed_items_no', null, ['class' => 'form-control', 'step' => 1, 'min' => 0]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('in_process_item_percentage', trans('Procentaj - pentru (sub)ansamblul actual') , ['class'=> 'control-label label-req']) !!}
                        {!! Form::number('in_process_item_percentage', null, ['class' => 'form-control', 'min' => 0, 'max' => 100, 'step' => 1]) !!}
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

    <div class="modal fade" id="stop-modal">
        {!! Form::open(['action' => ['TimeTrackingController@qr_tracking_store'], 'id' => 'stop-form']) !!}
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Stop') }}</h4>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('type', 'stop') !!}
                    <div class="form-group @if ($errors->has('completed_items_no')) has-error @endif">
                        {!! Form::label('completed_items_no', trans('Nr. terminate') , ['class'=> 'control-label label-req']) !!}
                        {!! Form::number('completed_items_no', null, ['class' => 'form-control', 'step' => 1, 'min' => 0]) !!}
                        @if ($errors->has('completed_items_no'))
                            <span class="help-block">{{ $errors->first('qr_code') }}</span>
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
@endsection

@section('content-scripts')
    <script type="text/javascript">
        jQuery(document).ready(function($) {

            var start_form = $('#start-form');
            var modal_start_form = $('#modal-start-form');
            var pause_form = $('#pause-form');
            var stop_form = $('#stop-form');

            var operation = null;
            var type = null;

            $(document).on('keyup', 'input[name="qr_code"]', function (e) {
                $.ajax({
                    method: "GET",
                    url: '{{ action('TimeTrackingController@qr_read')  }}',
                    data: { qr_code: $(this).val() }
                })
                .done(function(json_data) {
                    var data = $.parseJSON(json_data);

                    if (typeof data.type != 'undefined' && data.type != '') {

                        // set vars
                        type = data.type;
                        if (data.type == 'project') {
                            if (typeof data.operation_slug != 'undefined' && data.operation_slug != '')
                                operation = data.operation_slug;
                        }
                        else if (data.type == 'machine') {
                            if (typeof data.operation_type != 'undefined' && data.operation_type != '')
                                operation = data.operation_type;
                        }

                        //display qr info
                        if (typeof data.info != 'undefined' && data.info != '') {
                            $('#qr_info').html('<div class="qr-info-container"><i class="material-icons">&#xE88F;</i>' + data.info + '</div>');
                        }
                        else {
                            $('#qr_info').html('');
                            start_form.find('input[name="project_id"]').remove();
                            pause_form.find('input[name="project_id"]').remove();
                            stop_form.find('input[name="project_id"]').remove();
                        }

                        // hide buttons
                        $('.action-btn').addClass('hidden');

                        // show buttons
                        if (data.type == 'project') {
                            $('#view-drawing-button').removeClass('hidden');
                        }
                        else if (data.type == 'machine') {
                            $('#view-maintenance-button').attr('href', "{{ action('MachinesController@maintenance') }}" + '/' + data.machine_id).removeClass('hidden');
                        }

                        if (typeof data.last_action == 'undefined' || data.last_action == '' || data.last_action == 'stop' || data.last_action == 'pause') {
                            if (!(data.type == 'machine' && data.operation_type == 'general')) {
                                $('#start-button').removeClass('hidden');
                            }
                        }
                        else if (typeof data.last_action != 'undefined' && data.last_action == 'start') {
                            $('#stop-button').removeClass('hidden');
                            $('#pause-button').removeClass('hidden');
                        }

                        // add data to forms
                        if (start_form.find('input[name="data"]').length > 0) {
                            start_form.find('input[name="data"]').val(JSON.stringify(json_data));
                        }
                        else {
                            start_form.append('<input type="hidden" name="data" value="' + JSON.stringify(json_data) + '">');
                        }
                        if (modal_start_form.find('input[name="data"]').length > 0) {
                            modal_start_form.find('input[name="data"]').val(JSON.stringify(json_data));
                        }
                        else {
                            modal_start_form.append('<input type="hidden" name="data" value="' + JSON.stringify(json_data) + '">');
                        }
                        if (pause_form.find('input[name="data"]').length > 0) {
                            pause_form.find('input[name="data"]').val(JSON.stringify(json_data));
                        }
                        else {
                            pause_form.append('<input type="hidden" name="data" value="' + JSON.stringify(json_data) + '">');
                        }

                        if (stop_form.find('input[name="data"]').length > 0) {
                            stop_form.find('input[name="data"]').val(JSON.stringify(json_data));
                        }
                        else {
                            stop_form.append('<input type="hidden" name="data" value="' + json_data + '">');
                        }
                    }
                    else {
                        $('#qr_info').html('<div class="bg-danger padding10">{{ trans('Codul QR este incorect!') }}</div>');
                        $('.action-btn').addClass('hidden');
                    }
                });
            });


            $(document).on('click', '#start-button', function (e) {
                if (type != null && type == 'machine' && operation != null && operation == 'repair') {
                    $('#start-modal').modal('show');
                }
                else {
                    start_form.submit();
                }
            });

            $(document).on('click', '#pause-button', function (e) {
                if (type != null && type == 'machine') {
                    pause_form.submit();
                }
                else {
                    $('#pause-modal').modal('show');
                }
            });

            $(document).on('click', '#stop-button', function (e) {
                if (type != null && type == 'machine') {
                    stop_form.submit();
                }
                else {
                    $('#stop-modal').modal('show');
                }
            });


            @if ($errors->has('completed_items_no') || $errors->has('in_process_item_percentage'))
                var alert_container = $('#alert-container');
                alert_container.find('.alert').attr('class', '').addClass('alert alert-danger').html('{{ trans('Datele nu a fost salvate!') . ' ' .$errors->first('completed_items_no') . ' ' .$errors->first('in_process_item_percentage') }}');
                alert_container.slideDown().delay(4000).slideUp();
            @endif
        });


    </script>
@endsection