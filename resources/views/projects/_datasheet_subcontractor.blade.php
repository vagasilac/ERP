<div class="clearfix">
    <div class="pull-left marginR15">
    {!! Form::radio($field_name. '[type]' . (isset($index) ? '[' . $index . ']' : ''), 1, null,  ['class' => 'collapsible', 'data-target' => '#' . $collapse_id, 'data-expand-area' => '1']) !!}
    {!! Form::label($field_name. '[type]' . (isset($index) ? '[' . $index . ']' : ''), trans('Subcontractant'), ['class' => 'marginB0 paddingL30']) !!}
    </div>
    <div class="pull-left">
    {!! Form::radio($field_name . '[type]' . (isset($index) ? '[' . $index . ']' : ''), 0, null, ['class' => 'collapsible', 'data-target' => '#' . $collapse_id, 'data-expand-area' => '0']) !!}
    {!! Form::label($field_name, trans('Steiger'), ['class' => 'marginB0 paddingL30']) !!}
    </div>
</div>
<div id="{{ $collapse_id }}" class="collapse child-container marginT5 clearfix">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
        {!! Form::label($field_name . '[subcontractor][name]' . (isset($index) ? '[' . $index . ']' : ''), trans('Subcontractant') , ['class'=> 'control-label']) !!}
        {!! Form::text($field_name . '[subcontractor][name]' . (isset($index) ? '[' . $index . ']' : ''), null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('SuppliersController@get_suppliers'), 'data-autocomplete-data' => "data",  'data-autocomplete-id' => "id", 'data-autocomplete-value' => "long_name", 'data-input-name' => $field_name . '[subcontractor][id]']) !!}
    </div>
</div>