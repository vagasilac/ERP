@extends('app')

@section('title') {{ trans('Adăugare') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model(null, ['action' => 'CapasController@store', 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header no-border col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('CapasController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                {!! Form::label('type', trans('Tip'), ['class'=> 'control-label']) !!}
                {!! Form::select('type', Config::get('capa.capa_form.capa_create.type'), null, ['class' => 'form-control', 'id' => 'type']) !!}
            </div>
            <div id="supplier" class="form-group hidden">
                {!! Form::label('supplier', trans('Furnizor aprobat'), ['class' => 'control-label']) !!}
                {!! Form::text('supplier', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('SuppliersController@get_suppliers'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'id', 'data-autocomplete-value' => 'name', 'id' => 'supplier-input']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('source', trans('Sursă'), ['class'=> 'control-label']) !!}
                {!! Form::select('source', Config::get('capa.capa_form.capa_create.source'), null, ['class' => 'form-control', 'id' => 'source']) !!}
            </div>
            <div id="other-source" class="form-group hidden">
                {!! Form::label('other_source', trans('Alte surse'), ['class' => 'control-label']) !!}
                {!! Form::text('other_source', '', ['class' => 'form-control', 'id' => 'other-source-input']) !!}
            </div>
            <div id="process-container" class="form-group">
                {!! Form::label('process_id', trans('Proces'), ['class'=> 'control-label']) !!}
                {!! Form::select('process_id', $processes, null, ['class' => 'form-control', 'id' => 'process']) !!}
            </div>
            <div id="other-process" class="form-group hidden">
                {!! Form::label('other_process', trans('Alte proces'), ['class' => 'control-label']) !!}
                {!! Form::text('other_process', '', ['class' => 'form-control', 'id' => 'other-process-input']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('priority', trans('Prioritate'), ['class'=> 'control-label']) !!}
                {!! Form::select('priority', Config::get('capa.capa_form.capa_create.priority'), null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group @if ($errors->has('description')) has-error @endif">
                {!! Form::label('description', trans('Descrieți problema sau problema în detaliu'), ['class' => 'control-label']) !!}
                {!! Form::textarea('description', '', ['class' => 'form-control', 'size' => '50x3']) !!}
                @if ($errors->has('description'))
                    <span class="help-block">{{ $errors->first('description') }}</span>
                @endif
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@endsection

@section('content-scripts')
    <script>
        jQuery(document).ready(function($) {

            otherSource();
            otherProcess();

            $('#source').change(function() { otherSource(); });

            $('#process').change(function() { otherProcess(); });

            $('#type').change(function() { corrective_action_provider_selected(); });

            function otherSource()
            {
                var source = $('#source').val();
                if (source == 'other') {
                    $('#other-source').removeClass('hidden');
                }
                else {
                    $('#other-source').addClass('hidden');
                    $('#other-source-input').val('');
                }
            }

            function otherProcess()
            {
                var process = $('#process').val();
                if (process == '-1') {
                    $('#other-process').removeClass('hidden');
                }
                else {
                    $('#other-process').addClass('hidden');
                    $('#other-process-input').val('');
                }
            }

            function corrective_action_provider_selected()
            {
                var type = $('#type').val();

                if (type == 'corrective_action_provider') {
                    $('#supplier').removeClass('hidden');
                    $('#source option[value="supplier_feedback"]').addClass('hidden');
                    $('#process-container').addClass('hidden');
                    $('#process').val('');
                    $('#other-process-input').val('');
                }
                else {
                    $('#supplier').addClass('hidden');
                    $('#supplier-input').val('');
                    $('#supplier input[name="supplier_id"]').val('');
                    $('#source option[value="supplier_feedback"]').removeClass('hidden');
                    $('#process-container').removeClass('hidden');
                }
            }
        });
    </script>
@endsection
