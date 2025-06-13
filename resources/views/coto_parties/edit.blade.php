@extends('app')

@section('title') {{ trans('Editare') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model($item, ['action' => ['CotoPartiesController@update', $item->id], 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header no-border col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('CotoPartiesController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 marginR15">
            <div class="form-group @if ($errors->has('interested_party')) has-error @endif">
                {!! Form::label('interested_party', trans('Partea interesată') , ['class'=> 'control-label']) !!}
                {!! Form::text('interested_party', null, ['class' => 'form-control']) !!}
                @if ($errors->has('interested_party'))
                    <span class="help-block">{{ $errors->first('interested_party') }}</span>
                @endif
            </div>
            <div class="form-group @if ($errors->has('int_ext')) has-error @endif">
                {!! Form::label('int_ext', trans('Internal/External') , ['class'=> 'control-label']) !!}
                {!! Form::select('int_ext', ['internal', 'external'], ($item->int_ext == 'internal') ? 0 : 1, ['class' => 'form-control']) !!}
                @if ($errors->has('int_ext'))
                    <span class="help-block">{{ $errors->first('int_ext') }}</span>
                @endif
            </div>
            <div class="form-group @if ($errors->has('reason_for_inclusion')) has-error @endif">
                {!! Form::label('reason_for_inclusion', trans('Motiv pentru includere') , ['class'=> 'control-label']) !!}
                {!! Form::text('reason_for_inclusion', null, ['class' => 'form-control']) !!}
                @if ($errors->has('reason_for_inclusion'))
                    <span class="help-block">{{ $errors->first('reason_for_inclusion') }}</span>
                @endif
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@endsection
