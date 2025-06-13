@extends('app')

@section('title') {{ trans('Adaugă proiect') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model(null, ['action' => 'ProjectsController@store', 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>{{ trans('Date proiect') }}</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('ProjectsController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group  @if ($errors->has('name')) has-error @endif">
                {!! Form::label('name', trans('Nume') , ['class'=> 'control-label label-req']) !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                @if ($errors->has('name'))
                    <span class="help-block">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group @if ($errors->has('customer')) has-error @endif">
                {!! Form::label('customer', trans('Client') , ['class'=> 'control-label label-req']) !!}
                {!! Form::text('customer', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('CustomersController@get_customers'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'name', 'data-autocomplete-default-value' => 99]) !!}
                @if ($errors->has('customer'))
                    <span class="help-block">{{ $errors->first('customer') }}</span>
                @endif
            </div>
            <div class="form-group @if ($errors->has('primary_responsible_id')) has-error @endif">
                {!! Form::label('primary_responsible', trans('Responsabil proiect') , ['class'=> 'control-label label-req']) !!}
                {!! Form::text('primary_responsible', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('UsersController@get_users'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'name', 'data-autocomplete-default-value' => old('primary_responsible')]) !!}
                @if ($errors->has('primary_responsible_id'))
                    <span class="help-block">{{ $errors->first('primary_responsible_id') }}</span>
                @endif
            </div>
            <div class="form-group">
                {!! Form::label('secondary_responsible', trans('Responsabil secundar') , ['class'=> 'control-label label-req']) !!}
                {!! Form::text('secondary_responsible', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('UsersController@get_users'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'name', 'data-autocomplete-default-value' => old('secondary_responsible')]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('type', trans('Status'), ['class'=> 'control-label']) !!}
                {!! Form::select('type', ['offer' => trans('Ofertă'), 'work' => trans('În lucru'), 'executed' => trans('Executat')], null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('primary_code', trans('Cod principal'), ['class'=> 'control-label']) !!}
                {!! Form::select('primary_code', $primary_codes, null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('secondary_code', trans('Cod secundar'), ['class'=> 'control-label']) !!}
                {!! Form::select('secondary_code', $secondary_codes, null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', trans('Descriere') , ['class'=> 'control-label']) !!}
                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
            </div>
            <div class="relative">
            <div class="form-group production-no-container" style="z-index: 9">
                {!! Form::label('production_code', trans('Cod producție') , ['class'=> 'control-label label-req']) !!}
                {!! Form::text('production_code', null, ['class' => 'form-control']) !!}
            </div>
            </div>
            <div class="form-group production-code-container" style="position:relative;">
                {!! Form::label('production_no', trans('Nr. producție') , ['class'=> 'control-label label-req']) !!}
                {!! Form::text('production_no', null, ['class' => 'form-control', 'disabled']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('quantity', trans('Numărul de bucăți') , ['class'=> 'control-label']) !!}
                {!! Form::number('quantity', 1, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group" id="offer_deadline_container">
                {!! Form::label('deadline', trans('Termen limită ofertă'), ['class'=> 'control-label input-with-icon']) !!}
                {!! Form::text('deadline', null, ['class' => 'form-control has-datepicker']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('management_note', trans('Notă management') , ['class'=> 'control-label']) !!}
                {!! Form::textarea('management_note', null, ['class' => 'form-control', 'rows' => 3]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('parent', trans('Legat de proiectul') , ['class'=> 'control-label label-req']) !!}
                {!! Form::text('parent', !is_null($parent) ? $parent->production_name() . ' ' . $parent->name : null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('ProjectsController@get_projects', ['main_projects']), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'name', 'data-autocomplete-default-value' => old('parent_id')]) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('content-scripts')
    <script type="text/javascript">
        jQuery(document).ready(function($) {

            //change secondary codes options
            $('select[name="primary_code"]').change(function() {
                var select = $('select[name="secondary_code"]');
                select.html('');
                if ($(this).val() == '3' || $(this).val() == '4') {
                    select.append('<option value="1">1 - {{ trans('EXW (ex-works)') }}</option>');
                    select.append('<option value="2">2 - {{ trans('EXW (ex-works) / Export') }}</option>');
                    select.append('<option value="3">3 - {{ trans('Fabricație și livrare') }}</option>');
                    select.append('<option value="4">4 - {{ trans('Fabricație și livrare / Export') }}</option>');
                    select.append('<option value="7">7 - {{ trans('Serviciu') }}</option>');
                    select.append('<option value="8">8 - {{ trans('Serviciu / Export') }}</option>');
                }
                else if ($(this).val() == '5') {
                    select.append('<option value="1">1 - {{ trans('Antrepriză generală') }}</option>');
                    select.append('<option value="2">2 - {{ trans('Lucrări de construcții') }}</option>');
                    select.append('<option value="3">3 - {{ trans('Lucrări de construcții / Export') }}</option>');
                    select.append('<option value="7">7 - {{ trans('Serviciu') }}</option>');
                    select.append('<option value="8">8 - {{ trans('Serviciu / Export') }}</option>');
                }
                else {
                    select.append('<option value="1">1 - {{ trans('EXW (ex-works)') }}</option>');
                    select.append('<option value="2">2 - {{ trans('EXW (ex-works) / Export') }}</option>');
                    select.append('<option value="3">3 - {{ trans('Fabricație și livrare') }}</option>');
                    select.append('<option value="4">4 - {{ trans('Fabricație și livrare / Export') }}</option>');
                    select.append('<option value="5">5 - {{ trans('Fabricație livrare și montaj') }}</option>');
                    select.append('<option value="6">6 - {{ trans('Fabricație livrare și montaj / Export') }}</option>');
                    select.append('<option value="7">7 - {{ trans('Serviciu') }}</option>');
                    select.append('<option value="8">8 - {{ trans('Serviciu / Export') }}</option>');
                }
            });

            //generate production code
            $('input[name="name"], input[name="customer"]').change(function() {
                if ($('#type').val() != 'offer') {
                    var name = $('input[name="name"]').val();
                    var customer = $('input[name="customer"]').val();
                    $('input[name="production_code"]').val((name != '' ? name.slice(0, 1).toUpperCase() : '') + (customer != '' ? customer.slice(0, 1).toUpperCase() : '')).blur();
                }
                else {
                    $('input[name="production_code"]').val('');
                }
            });

            $(document).on('change', '#type', function() {
                if ($(this).val() != 'offer') {
                    $('#production_no').val('{{ $next_production_no }}').blur();
                    $('#offer_deadline_container').addClass('hidden');

                    var name = $('input[name="name"]').val();
                    var customer = $('input[name="customer"]').val();
                    $('input[name="production_code"]').val((name != '' ? name.slice(0, 1).toUpperCase() : '') + (customer != '' ? customer.slice(0, 1).toUpperCase() : '')).blur();
                }
                else {
                    $('#production_no').val('').blur();
                    $('input[name="production_code"]').val('');
                    $('#offer_deadline_container').removeClass('hidden');
                }
            });
        });
    </script>
@endsection