@extends('app')

@section('title') @include('projects._header') @endsection

@section('content')
    <div class="sidebar">
        @include('projects._sidebar')
    </div>
    <div class="content-fluid offset">
        <div class="paddingL15 paddingR15">
            {!! Form::model(isset($project->calculation->data) ? $project->calculation->data : null, ['action' => ['ProjectsController@calculation_update', $project->id], 'id' => 'saveForm', 'novalidate']) !!}
                {!! Form::hidden('active_tab') !!}
                <div class="page-header no-border marginB0">
                    <h2>{{ trans('Calcul') }}</h2>
                    @include('projects._buttons')
                </div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#calculation-subassemblies"  aria-controls="calculation-subassemblies" role="tab" data-toggle="tab">{{ trans('Lista (sub)ansamble') }}</a></li>
                    <li role="presentation"><a href="#calculation-subassembly-groups"  aria-controls="calculation-subassembly-groups" role="tab" data-toggle="tab">{{ trans('Grupuri de (sub)ansamble') }}</a></li>
                    <li role="presentation"><a href="#calculation-materials" aria-controls="calculation-materials" role="tab" data-toggle="tab">{{ trans('Lista materiale') }}</a></li>
                    <li role="presentation"><a href="#calculation-execution" aria-controls="calculation-execution" role="tab" data-toggle="tab">{{ trans('Execuție') }}</a></li>
                    <li role="presentation"><a href="#calculation-assembly" aria-controls="calculation-assembly" role="tab" data-toggle="tab">{{ trans('Montaj') }}</a></li>
                </ul>

                <div class="col-xs-10">
                <!-- Tab panes -->
                    <div class="tab-content row">
                        <div class="row marginT30">
                            <div class="col-xs-12">
                                <div class="form-group pull-right" style="padding-top: 7px">
                                    <a class="btn btn-sm btn-primary" href="{{ action('ProjectsController@qr_label', $project->id) }}" target="_blank"><i class="material-icons">&#xE41D;</i> {{ trans('Descarcă eticheta') }}</a>
                                    @can ('Projects - Add calculation materials')
                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#upload-modal"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare fișier XLS materiale') }}</a>
                                    <a class="btn btn-sm btn-default" href="{{ asset('media/templates/subansamble.xlsx') }}" target="_blank" download="{{ $project->production_name() }}_(sub)ansamble.xlsx"><i class="material-icons">&#xE2C4;</i> {{ trans('Descarcă șablon XLS materiale') }}</a>
                                    @endcan
                                </div>
                            </div>
                        </div>

                        @php
                        /*
                        @foreach ($colors as $k => $color)
                            <span style="display: inline-block; height: 50px; width: 50px; background: {{  $color }}"></span>
                        @endforeach
                        */
                        @endphp
                        {!! Form::hidden('subassemblies-change', 0) !!}

                        <div role="tabpanel" class="tab-pane active" id="calculation-subassemblies">
                            <div class="table-responsive">
                                @include('projects._subassemblies_list')
                            </div>
                            <a class="table-row-clone marginT15 marginB15 inline-block" data-target=".assemblies-row">+ {{ trans('Adaugă un rând nou') }}</a>
                        </div>


                        <div role="tabpanel" class="tab-pane" id="calculation-subassembly-groups">
                            <div class="table-responsive">
                                @include('projects._subassembly_groups_list')
                            </div>
                            <a class="table-row-clone marginT15 marginB15 inline-block" data-target=".subassembly-groups-row">+ {{ trans('Adaugă un rând nou') }}</a>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="calculation-materials">
                            @include('projects._calculation_materials_list')
                        </div>

                        <div role="tabpanel" class="tab-pane" id="calculation-execution">
                            @include('projects._calculation_execution')
                        </div>

                        <div role="tabpanel" class="tab-pane" id="calculation-assembly">
                            @include('projects._calculation_assembly')
                        </div>
                    </div>
                </div>
                <div class="col-xs-2 calculation-sidebar">
                    <div class="row paddingL15">
                        <label>{{ trans("Greutate netă") }}</label>
                        {!! Form::text('summary_net_weight', '0.00 kg / 0.00 t', ['class' => 'form-control output marginB10', 'disabled' => 'disabled', 'id' => 'summary_net_weight']) !!}
                        <label>{!! trans("Total materiale principale,<br> materiale sudare, taiere") !!} (&euro;)</label>
                        {!! Form::text('total_main_materials', '0.00', ['class' => 'form-control output extra-padding marginB10', 'disabled' => 'disabled', 'id' => 'total_main_materials']) !!}
                        <label>{{ trans("Pret manopera (executie)") }} (&euro;)</label>
                        {!! Form::text('total_execution', '0.00', ['class' => 'form-control output marginB10', 'disabled' => 'disabled', 'id' => 'total_execution']) !!}
                        <label>{{ trans("Total materiale pentru montaj") }} (&euro;)</label>
                        {!! Form::text('total_assembly_materials', '0.00', ['class' => 'form-control output marginB10', 'disabled' => 'disabled', 'id' => 'total_assembly_materials']) !!}
                        <label>{{ trans("Total cheltuieli montaj") }} (&euro;)</label>
                        {!! Form::text('total_assembly', '0.00', ['class' => 'form-control output', 'disabled' => 'disabled', 'id' => 'total_assembly']) !!}
                        <div class="separator"></div>
                        <label>{{ trans("Total calculat") }} (&euro;)</label>
                        {!! Form::text('total_calculated', '0.00', ['class' => 'form-control output large-text marginB10', 'disabled' => 'disabled', 'id' => 'total_calculated']) !!}
                        <label class="green">{{ trans("Total propus") }} (&euro;)</label>
                        {!! Form::number('total', null, ['class' => 'form-control output green large-text', 'disabled' => 'disabled', 'id' => 'total', 'data-value' => isset($project->calculation->data->total) ? $project->calculation->data->total : '']) !!}
                        <a class="btn btn-default marginT10" id="total-modify">{{ trans('Modifică') }}</a>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection


@section('content-modals')
    <div class="modal fade" id="upload-modal">
        {!! Form::open(['action' => ['ProjectsController@materials_upload', $project->id], 'files' => true]) !!}
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

    <div class="modal fade" id="alert-modal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Atenție') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">{{ trans('În lista de (sub)ansamble au fost făcute modificări. Dacă salvați, atunci va fi suprascrisă și lista de materiale.') }}</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    <a class="btn btn-success submit-form" id="submit-form">{{ trans('Salvează') }}</a>
                </div>
            </div>
        </div>
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

    <!-- Stock info modal -->
    <div class="modal fade" id="stock-info-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="stock-info-content">

            </div>
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
@endsection


@section('content-scripts')
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            //adds tab href to url + opens tab based on hash on page load
            var hash = window.location.hash;
            hash && $('ul.nav a[href="' + hash + '"]').tab('show');
            $('input[name="active_tab"]').val(hash);

            $('.nav-tabs a').click(function (e) {
                $(this).tab('show');
                var scrollmem = $('body').scrollTop() || $('html').scrollTop();
                window.location.hash = this.hash;
                $('input[name="active_tab"]').val(this.hash);
                $('html,body').scrollTop(scrollmem);
            });
        });
    </script>

    <script src="{{ asset('js/calculation.min.js') }}?v={{ time() }}"></script>

    <script type="text/javascript">
        jQuery(document).ready(function($) {

            /*add danger background color to entire row */
            $('.has-error').each(function() {
               $(this).parents('tr').addClass('bg-danger');
            });


            /* auto-scaling inputs to width of value */
            $('.table input[type="text"], .table input[type="number"], .table select').each(function() {
                var text  = $(this).is('select') ? $(this).find('option:selected').text() : $(this).val();

                //$(this).css('width', $(this).textWidth(text) + ($(this).is(':disabled') ? 0 : 26 /*padding*/) + ($(this).is('select') ? 25 : 0));
            });
            $(document).on('keyup blur', '.table input[type="text"], .table input[type="number"], .table select', function (e) {
                var text  = $(this).is('select') ? $(this).find('option:selected').text() : $(this).val();

                //$(this).css('width', $(this).textWidth(text) + ($(this).is(':disabled') ? 0 : 26 /*padding*/) + ($(this).is('select') ? 65 : 0));
            });

            var no_of_rows = 0;

            /*clone*/
            $(document).on('click', '.table-row-clone', function (e) {
                jQuery('.has-combobox').autocomplete('destroy').unbind('focus');

                var row_type = '';
                if ($(this).attr('data-target').indexOf('groups') == -1) {
                    row_type = 'subassembly';
                }
                else {
                    row_type = 'group';
                }

                var row = $($(this).data('target')).first();
                var clone = null;
                if (row.find('.has-combobox').length > 0) {
                    clone = row.clone(false);
                }
                else {
                    clone = row.clone(true);
                }

                if (no_of_rows < $($(this).data('target')).parents('table').find('tr').length) {
                    no_of_rows = $($(this).data('target')).parents('table').find('tr').length + 1;
                }
                else {
                    no_of_rows++;
                }

                clone.find('input, select').each(function() {
                    if ($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox') {
                        $(this).prop('checked', false);
                    }
                    else {
                        $(this).val('');
                    }

                    var new_name = $(this).attr('name').replace(new RegExp("([0-9]+)", "g"), no_of_rows);
                    if (new_name.indexOf('new_subassembly_groups') == -1) new_name = new_name.replace('subassembly_groups[', 'new_subassembly_groups[');
                    if (new_name.indexOf('new_subassemblies') == -1) new_name = new_name.replace('subassemblies[', 'new_subassemblies[');
                    $(this).attr('name', new_name);

                });
                clone.find('.focused').removeClass('focused');
                clone.find('.remove-icon').data('target', '#new-' + row_type + '-delete-modal-' + no_of_rows).attr('data-target', '#new-' + row_type + '-delete-modal-' + no_of_rows).attr('id', 'new-' + row_type + '-remove-icon-' + no_of_rows);
                clone.find('input, select').removeAttr('data-id');
                clone.attr('data-id', 'new-' + no_of_rows);
                clone.find('.subassemblies-clone').attr('data-parent-id', 'new-' + no_of_rows);
                clone.find('.add-responsible').remove();


                //clone delete modal
                var modal_clone = $('.' + row_type + '-delete-modal').first().clone(true);
                modal_clone.attr('id', 'new-' + row_type + '-delete-modal-' + no_of_rows);
                modal_clone.find('.remove-table-row').attr('data-id', 'new-' + no_of_rows).attr('data-remove-icon', '#new-' + row_type + '-remove-icon-' + no_of_rows);
                $('body').append(modal_clone);


                $($(this).data('target')).parents('table').find('tr').last().after(clone);

                initComboBox();
            });

            $(document).on('click', '.subassemblies-clone', function (e) {
                //jQuery('.has-combobox').autocomplete('destroy').unbind('focus');

                var row = $($(this).data('target')).first();
                var clone = null;
                var parent_id = $(this).attr('data-parent-id');
                if (row.find('.has-combobox').length > 0) {
                    clone = row.clone(false);

                }
                else {
                    clone = row.clone(true);
                }
                if (no_of_rows < $(this).parents('table').find('tr').length) {
                    no_of_rows = $(this).parents('table').find('tr').length + 1;
                }
                else {
                    no_of_rows++;
                }
                clone.find('input, select').each(function() {
                    if ($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox') {
                        $(this).prop('checked', false);
                    }
                    else {
                        $(this).val('');
                    }

                    var new_name = $(this).attr('name').replace(new RegExp("(([0-9]+)|(temp))", "g"), no_of_rows);
                    if (new_name.indexOf('new_subassembly_groups') == -1) new_name = new_name.replace('subassembly_groups[', 'new_subassembly_groups[');
                    if (new_name.indexOf('new_subassemblies') == -1) new_name = new_name.replace('subassemblies[', 'new_subassemblies[');

                    $(this).attr('name', new_name);

                });

                clone.removeClass('hide').attr('data-parent-id', parent_id);
                clone.find('input[name*="[parent]"]').val(parent_id);
                clone.find('.focused').removeClass('focused');
                clone.find('.remove-table-row').removeAttr('data-id');
                clone.find('.remove-icon').data('target', '#new-subassembly-delete-modal-' + no_of_rows).attr('data-target', '#new-subassembly-delete-modal-' + no_of_rows).attr('id', 'new-subassembly-remove-icon-' + no_of_rows);
                clone.find('input, select').removeAttr('data-id');
                clone.attr('data-id', 'new-' + no_of_rows);
                clone.find('.parts-clone').attr('data-subassembly-id', 'new-' + no_of_rows).attr('data-parent-id', parent_id);
                clone.find('.add-responsible').remove();

                $($(this).data('target') + '[data-parent-id="' + parent_id + '"]').last().after(clone);
                if ($($(this).data('target') + '[data-parent-id="' + parent_id + '"]').length > 0) {
                    $('tr[data-parent-id="' + parent_id + '"]').last().after(clone);
                }
                else {
                    $(this).parents('table').find('tr.assemblies-row[data-id="' + parent_id + '"]').after(clone);
                }

                //add parent input field


                //clone delete modal
                var modal_clone = $('.subassembly-delete-modal').first().clone(true);
                modal_clone.attr('id', 'new-subassembly-delete-modal-' + no_of_rows);
                modal_clone.find('.remove-table-row').attr('data-id', 'new-' + no_of_rows).attr('data-remove-icon', '#new-subassembly-remove-icon-' + no_of_rows);
                $('body').append(modal_clone);

                initComboBox();
            });

            $(document).on('click', '.parts-clone', function (e) {
                //jQuery('.has-combobox').autocomplete('destroy').unbind('focus');

                var row = $($(this).data('target')).first();
                var clone = null;
                var subassembly_id = $(this).attr('data-subassembly-id');
                var parent_id = $(this).attr('data-parent-id');
                if (row.find('.has-combobox').length > 0) {
                    clone = row.clone(false);

                }
                else {
                    clone = row.clone(true);
                }
                if (no_of_rows < $($(this).data('target')).length) {
                    no_of_rows = $($(this).data('target')).length + 1;
                }
                else {
                    no_of_rows++;
                }
                clone.find('input, select').each(function() {
                    if ($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox') {
                        $(this).prop('checked', false);
                    }
                    else {
                        $(this).val('');
                    }

                    var new_name = $(this).attr('name');
                    if (new_name.indexOf('new_parts') == -1) new_name = new_name.replace('[parts]', '[new_parts]');
                    new_name = new_name.slice(0, new_name.indexOf('[new_parts]')).replace(new RegExp("(([0-9]+)|(temp))", "g"), subassembly_id.replace('new-', '')) + new_name.slice(new_name.indexOf('[new_parts]')).replace(new RegExp("(([0-9]+)|(temp))", "g"), no_of_rows);
                    if (new_name.indexOf('new_subassemblies') == -1 && subassembly_id.indexOf('new-') >=0) new_name = new_name.replace('subassemblies[', 'new_subassemblies[').replace('[new-', '[');

                    $(this).attr('name', new_name);

                });
                clone.find('span.input').html('0.00');

                clone.removeClass('hide').attr('data-subassembly-id', subassembly_id).attr('data-parent-id', parent_id);
                clone.find('.focused').removeClass('focused');
                clone.find('.remove-table-row').removeAttr('data-id');
                clone.find('.remove-icon').data('target', '#new-part-delete-modal-' + no_of_rows).attr('data-target', '#new-part-delete-modal-' + no_of_rows).attr('id', 'new-part-remove-icon-' + no_of_rows);
                clone.find('input, select').removeAttr('data-id');
                clone.find('.add-responsible').remove();

                if ($($(this).data('target') + '[data-subassembly-id="' + subassembly_id + '"]').length > 0) {
                    $($(this).data('target') + '[data-subassembly-id="' + subassembly_id + '"]').last().after(clone);
                }
                else {
                    $(this).parents('table').find('tr.subassemblies-row[data-id="' + subassembly_id + '"]').after(clone);
                }

                //clone delete modal
                var modal_clone = $('.part-delete-modal').first().clone(true);
                modal_clone.attr('id', 'new-part-delete-modal-' + no_of_rows);
                modal_clone.find('.remove-table-row').attr('data-id', 'new-' + no_of_rows).attr('data-remove-icon', '#new-part-remove-icon-' + no_of_rows);
                $('body').append(modal_clone);

                initComboBox();
            });

            $(document).on('click', '.remove-table-row', function (e) {
                var THIS = $($(this).data('remove-icon'));
                if (THIS.parents('.subassemblies-row').length > 0 || THIS.parents('.assemblies-row').length) { //assemblies/subassemblies
                    $('input[name="subassemblies-change"]').val(1);

                    if (typeof $(this).data('id') != 'undefined') {
                        THIS.parents('form').append('<input type="hidden" name="delete_subassemblies[]" value="' + $(this).data('id') + '">');
                    }

                    //remove parts
                    $('.subassemblies-row[data-parent-id="' + $(this).data('id') + '"]').remove();
                    $('.parts-row[data-parent-id="' + $(this).data('id') + '"]').remove();

                    //hide modal
                    $(this).parents('.modal').modal('hide');
                }
                else if (THIS.parents('.parts-row').length > 0) { //parts
                    $('input[name="subassemblies-change"]').val(1);
                    if (typeof $(this).data('id') != 'undefined') {
                        THIS.parents('form').append('<input type="hidden" name="delete_subassembly_parts[]" value="' + $(this).data('id') + '">');
                    }

                    //hide modal
                    $(this).parents('.modal').modal('hide');
                }
                else { //subassembly groups
                    if (typeof $(this).data('id') != 'undefined') {
                        THIS.parents('form').append('<input type="hidden" name="delete_subassembly_groups[]" value="' + $(this).data('id') + '">');
                    }

                    //hide modal
                    $(this).parents('.modal').modal('hide');

                }

                THIS.parents('tr').remove();

            });

            /*total modify button*/
            $(document).on('click', '#total-modify', function (e) {
                $('#total').prop('disabled', false).focus();
                $(this).remove();
            });

            /*submit*/
            $('#save-page-btn').click(function(e) {
                e.preventDefault();

                if ($('input[name="subassemblies-change"]').val() == 1) {
                    $('#alert-modal').modal('show');
                }
                else {
                    submit_form();
                }
            });
            $(document).on('click','.submit-form', function (e) {
                e.preventDefault();

                if ($(this).attr('name') != 'undefined')  $('#saveForm').append('<input type="hidden" name="' + $(this).attr('name') + '"/>')

                submit_form();
            });

            /*set-price*/
            $(document).on('click', '.set-price', function (e) {
                $('input[name="' + $(this).data('target') + '"]').val($(this).data('value')).blur().change();
            });

            //subassemblies is changed?
            $(document).on('change', '#calculation-subassemblies input, #calculation-subassemblies select', function (e) {
                $('input[name="subassemblies-change"]').val(1);
            });

            $(document).on('change', '#calculation-subassemblies .table-row-clone', function (e) {
                $('input[name="subassemblies-change"]').val(1);
            });

            //collapse icons
            $(document).on('click', '#plates-table .collapse-icon-container, #profiles-table .collapse-icon-container', function() {
                $(this).toggleClass('collapsed');
            });

            //select/unselect rows
            $(document).on('click', 'table .select', function () {
                var actions_bar = $('#materials-actions-bar');
                var selected_items = $('#calculation-materials .select:checked').length;

                var target = $(this).data('target');
                if (typeof target != 'undefined') {
                    if ($(this).is(':checked')) {
                        $(target).addClass('active');
                    }
                    else {
                        $(target).removeClass('active');
                    }
                }

                //show/hide action bar
                if (selected_items > 0) {
                    actions_bar.find('.count').html(selected_items);
                    actions_bar.show();
                }
                else {
                    actions_bar.find('.count').html(0);
                    actions_bar.hide();
                }
            });
            $(document).on('click', 'table input[name="select_all_rows"]', function () {

                var target = $(this).data('target');
                if (typeof target != 'undefined') {
                    if ($(this).is(':checked')) {
                        $(this).closest('table').closest('tr').find(target).addClass('active');
                        $(this).closest('table').find('input[type="checkbox"]').prop('checked', true);

                    }
                    else {
                        $(this).closest('table').closest('tr').find(target).removeClass('active');
                        $(this).closest('table').find('input[type="checkbox"]').prop('checked', false);

                    }
                }


                //show/hide action bar
                var actions_bar = $('#materials-actions-bar');
                var selected_items = $('#calculation-materials .select:checked').length;
                if (selected_items > 0) {
                    actions_bar.find('.count').html(selected_items);
                    actions_bar.show();
                }
                else {
                    actions_bar.find('.count').html(0);
                    actions_bar.hide();
                }
            });


            //add affix to actions bar
            $('#materials-actions-bar').affix({
                offset: {
                    top: function() {
                        var position = $('#materials-actions-bar-before').offset();
                        return position.top;
                    }
                }
            });

            //actions bar width
            $('#materials-actions-bar').width($('#calculation-materials').width());
            $(window).resize(function() {
                $('#materials-actions-bar').width($('#calculation-materials').width());
            });

            $(document).on('click', '.load-combobox', function (e) {
               $(this).removeClass('load-combobox').addClass('has-combobox');
                initComboBox();
            });
        });

        /* get text width */
        jQuery.fn.textWidth = function(text, font) {

            var str = text || this.val() || this.text();

            jQuery.fn.textWidth.fakeEl = jQuery('<span>').hide().appendTo(document.body);

            jQuery.fn.textWidth.fakeEl.text(str).css('font', font || this.css('font'));
            if (str == 'STRUCTURA') {

                jQuery('#calculation-subassemblies').append(jQuery.fn.textWidth.fakeEl);
            }

            var width = jQuery.fn.textWidth.fakeEl.width();
            jQuery.fn.textWidth.fakeEl.remove();

            return width;
        };

        function submit_form() {
            jQuery('#saveForm').find('input').prop('disabled', false);
            jQuery('#saveForm').submit();
        }
    </script>
@endsection