@extends('app')

@section('title') {{ trans('Adăugare') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model(null, ['action' => 'MachinesController@store', 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('MachinesController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <div class="tab-content col-xs-12 marginT30">
            <div class="tab-pane row active" id="output-container" role="tabpanel">
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('name', trans('Denumire') , ['class'=> 'control-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('inventory_no')) has-error @endif">
                        {!! Form::label('inventory_no', trans('Număr de identificare') , ['class'=> 'control-label']) !!}
                        {!! Form::text('inventory_no', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('inventory_no'))
                            <span class="help-block">{{ $errors->first('inventory_no') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('source')) has-error @endif">
                        {!! Form::label('source', trans('Sursa') , ['class'=> 'control-label']) !!}
                        {!! Form::text('source', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('source'))
                            <span class="help-block">{{ $errors->first('source') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('manufacturing_year')) has-error @endif">
                        {!! Form::label('manufacturing_year', trans('Anul fabricației') , ['class'=> 'control-label']) !!}
                        {!! Form::number('manufacturing_year', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('manufacturing_year'))
                            <span class="help-block">{{ $errors->first('manufacturing_year') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('type')) has-error @endif">
                        {!! Form::label('type', trans('Tip') , ['class'=> 'control-label']) !!}
                        {!! Form::text('type', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('type'))
                            <span class="help-block">{{ $errors->first('type') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('power')) has-error @endif">
                        {!! Form::label('power', trans('Putere') . ' (kW)' , ['class'=> 'control-label']) !!}
                        {!! Form::text('power', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('power'))
                            <span class="help-block">{{ $errors->first('power') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('hourly_rate')) has-error @endif">
                        {!! Form::label('hourly_rate', trans('Manopera') . ' (&euro;/h)' , ['class'=> 'control-label']) !!}
                        {!! Form::number('hourly_rate', null, ['class' => 'form-control', 'step' => '0.01']) !!}
                        @if ($errors->has('hourly_rate'))
                            <span class="help-block">{{ $errors->first('hourly_rate') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('operation_id')) has-error @endif">
                        {!! Form::label('operation_id', trans('Operație'), ['class'=> 'control-label']) !!}
                        {!! Form::select('operation_id', array_merge([0 => ''], $operations->toArray()), null, ['class' => 'form-control']) !!}
                        @if ($errors->has('operation_id'))
                            <span class="help-block">{{ $errors->first('operation_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('maintenance_log', trans('Jurnal de mentenanta'), ['class' => 'control-label']) !!}
                        {!! Form::select('maintenance_log', Config::get('machines.maintenance_log'), null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group @if ($errors->has('observations')) has-error @endif">
                        {!! Form::label('observations', trans('Observații') , ['class'=> 'control-label']) !!}
                        {!! Form::textarea('observations', null, ['class' => 'form-control', 'rows' => 2]) !!}
                        @if ($errors->has('observations'))
                            <span class="help-block">{{ $errors->first('observations') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <h4 class="marginT0">{{ trans('Fotografie') }}</h4>
                    <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }} row clearfix">
                        <div class="col-xs-12">
                            {!! Form::file('photo', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
