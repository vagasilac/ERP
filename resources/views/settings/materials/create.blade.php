@extends('app')

@section('title') {{ trans('Adaugă material') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model(null, ['action' => ['SettingsController@materials_store', $type], 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>{{ trans('Date material') }}</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('SettingsController@materials', $type) }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>
        <div class="col-md-10">
            <div class="col-xs-12 col-sm-6 marginR15">
                {!! Form::hidden('type', $type) !!}
                <div class="row">
                    <h4>{{ trans('General') }}</h4>
                </div>
                <div class="row">
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('name', trans('Denumire') , ['class'=> 'control-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('info', trans('Info'), ['class'=> 'control-label']) !!}
                        {!! Form::text('info', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                @if ($type == 'auxiliary')
                    <div class="row">
                        <div class="form-group">
                            {!! Form::label('coefficient', trans('Coeficient'), ['class'=> 'control-label']) !!}
                            {!! Form::text('coefficient', null , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('unit', trans('Unitate de măsură'), ['class'=> 'control-label']) !!}
                        {!! Form::text('unit', null , ['class' => 'form-control']) !!}
                    </div>
                </div>
                @if ($type == 'main' || $type == 'other')
                    <div class="row">
                        <div class="form-group">
                            <label for="G" class="control-label">G [kg.m<sup>-1</sup>]</label>
                            {!! Form::text('G', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="AL" class="control-label">A<sub>L</sub> [m<sup>2</sup>.m<sup>-1</sup>]</label>
                            {!! Form::text('AL', null , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <h4>{{ trans('Grosime') }}</h4>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            {!! Form::label('thickness', trans('Grosime'), ['class'=> 'control-label']) !!}
                            {!! Form::text('thickness', null , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <h4>ml</h4>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            {!! Form::checkbox('ml_6', '1', null ) !!}
                            {!! Form::label('ml_6', '6 m', ['class' => 'marginB0 paddingL30']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group ">
                            {!! Form::checkbox('ml_12', '1', null ) !!}
                            {!! Form::label('ml_12', '12 m', ['class' => 'marginB0 paddingL30']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group ">
                            {!! Form::checkbox('ml_12_1', '1', null ) !!}
                            {!! Form::label('ml_12_1', '12.1 m', ['class' => 'marginB0 paddingL30']) !!}
                        </div>
                    </div>
                @endif
                @if ($type == 'auxiliary' || $type == 'paint' || $type == 'other')
                    <div class="row">
                        <div class="form-group">
                            {!! Form::label('price', trans('Preț'), ['class'=> 'control-label']) !!}
                            {!! Form::text('price', null , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                @endif
                @if ($type == 'auxiliary' || $type == 'other')
                    <div class="row">
                        <div class="form-group">
                            {!! Form::label('consumption', trans('Consum'), ['class'=> 'control-label']) !!}
                            {!! Form::text('consumption', null , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                @endif
                @if ($type == 'assembly' || $type == 'other')
                    <div class="row">
                        <div class="form-group">
                            {!! Form::label('material_group', trans('Grupa'), ['class'=> 'control-label']) !!}
                            {!! Form::text('material_group', null , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            {!! Form::label('M', 'M', ['class'=> 'control-label']) !!}
                            {!! Form::text('M', null , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-xs-12 col-sm-5">
                @if ($type == 'main' || $type == 'assembly' || $type == 'other')
                <div class="row">
                    <h4>{{ trans('Standarde') }}</h4>

                    <div class="form-group">
                        {!! Form::checkbox('DIN1025_1', '1', null ) !!}
                        {!! Form::label('DIN1025_1', 'DIN 1025-1', ['class' => 'marginB0 paddingL30']) !!}
                    </div>

                    <div class="form-group ">
                        {!! Form::checkbox('DIN1025_5', '1', null ) !!}
                        {!! Form::label('DIN1025_5', 'DIN 1025-5', ['class' => 'marginB0 paddingL30']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::checkbox('EN10210_2', '1', null ) !!}
                        {!! Form::label('EN10210_2', 'EN 10210-2', ['class' => 'marginB0 paddingL30']) !!}
                    </div>

                    <div class="form-group ">
                        {!! Form::checkbox('EN10210_3', '1', null ) !!}
                        {!! Form::label('EN10210_3', 'EN 10210-3', ['class' => 'marginB0 paddingL30']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::checkbox('EN10210_4', '1', null ) !!}
                        {!! Form::label('EN10210_4', 'EN 10210-4', ['class' => 'marginB0 paddingL30']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::checkbox('EN10210_5', '1', null ) !!}
                        {!! Form::label('EN10210_5', 'EN 10210-5', ['class' => 'marginB0 paddingL30']) !!}
                    </div>

                    <div class="form-group ">
                        {!! Form::checkbox('EN10210_6', '1', null ) !!}
                        {!! Form::label('EN10210_6', 'EN 10210-6', ['class' => 'marginB0 paddingL30']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::checkbox('EN10210_7', '1', null ) !!}
                        {!! Form::label('EN10210_7', 'EN 10210-7', ['class' => 'marginB0 paddingL30']) !!}
                    </div>

                    <div class="form-group ">
                        {!! Form::checkbox('Euronorm19_57', '1', null ) !!}
                        {!! Form::label('Euronorm19_57', 'Euronorm 19-57', ['class' => 'marginB0 paddingL30']) !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
