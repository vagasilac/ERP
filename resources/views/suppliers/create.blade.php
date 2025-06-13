@extends('app')

@section('title') {{ trans('Adaugă furnizor aprobat') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model(null, ['action' => 'SuppliersController@store', 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>{{ trans('Date furnizor aprobat') }}</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('SuppliersController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>

        </div>
        <div class="col-md-10">
            <div class="col-xs-12 col-sm-6 marginR15">
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
                    <div class="form-group ">
                        {!! Form::label('short_name', trans('Denumire scurtă'), ['class'=> 'control-label']) !!}
                        {!! Form::text('short_name', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('vat_number', trans('CUI'), ['class'=> 'control-label']) !!}
                        {!! Form::text('vat_number', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('company_number', trans('Nr. registrul comerțului'), ['class'=> 'control-label']) !!}
                        {!! Form::text('company_number', null , ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('office_email', trans('Adresa de email'), ['class'=> 'control-label']) !!}
                        {!! Form::text('office_email', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('office_phone', trans('Telefon'), ['class' => 'control-label']) !!}
                        {!! Form::text('office_phone', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <h4>{{ trans('Adresa') }}</h4>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('address', trans('Adresa'), ['class'=> 'control-label']) !!}
                        {!! Form::text('address', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group city-container">
                        {!! Form::label('city', trans('Localitate'), ['class'=> 'control-label']) !!}
                        {!! Form::text('city', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group city-container">
                        {!! Form::label('county', trans('Județ'), ['class'=> 'control-label']) !!}
                        {!! Form::text('county', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('country', trans('Țara'), ['class'=> 'control-label']) !!}
                        {!! Form::select('country', App\Models\Country::lists('name', 'code'), null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <h4>{{ trans('Alte adrese') }}</h4>
                </div>
                <div class="row marginB30">
                    <div class="additional-address">
                        <div class="form-group">
                            {!! Form::label('_address', trans('Adresa'), ['class'=> 'control-label']) !!}
                            {!! Form::text('additional_address[0]', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group city-container">
                            {!! Form::label('additional_city', trans('Localitate'), ['class'=> 'control-label']) !!}
                            {!! Form::text('additional_city[0]', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group city-container">
                            {!! Form::label('additional_county', trans('Județ'), ['class'=> 'control-label']) !!}
                            {!! Form::text('additional_county[0]', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('additional_country', trans('Țara'), ['class'=> 'control-label']) !!}
                            {!! Form::select('additional_country[0]', App\Models\Country::lists('name', 'code'), null, ['class' => 'form-control']) !!}
                        </div>

                        <a class="text-danger no-underline remove-row" data-target=".additional-address"><span class="fa fa-minus-circle"></span> {{ trans('Șterge adresa') }}</a>
                        <hr>
                    </div>
                    <a class="marginB15 no-underline clone" data-target=".additional-address"><span class="fa fa-plus-circle"></span> {{ trans('Adaugă adresă nou') }}</a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-5">
                <div class="row">
                    <h4>{{ trans('Fotografie') }}</h4>
                    <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }} row clearfix">
                        <div class="col-xs-9">
                            {!! Form::file('photo', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row @if ($errors->has('type')) has-error @endif">
                    <h4>{{ trans('Tip') }}</h4>
                    @if ($errors->has('type'))
                        <span class="help-block">{{ $errors->first('type') }}</span>
                    @endif
                    @if (count($types) > 0)
                        @foreach ($types as $k => $type)
                            {!! Form::checkbox('type[' . $k . ']', $type->id, false, ['class' => 'select'] ) !!}
                            {!! Form::label('type[' . $k . ']', trans($type->name), ['class' => 'marginB0 paddingL30']) !!}
                            <br />
                        @endforeach
                    @endif
                </div>
                <div class="row">
                    <h4>{{ trans('Persoane de contact') }}</h4>
                    <div class="contact-person">
                        <div class="form-group">
                            {!! Form::label('contact_name', trans('Nume') , ['class'=> 'control-label']) !!}
                            {!! Form::text('contact_name[0]', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('contact_email', trans('Adresa E-mail') , ['class'=> 'control-label']) !!}
                            {!! Form::text('contact_email[0]', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('contact_phone', trans('Telefon') , ['class'=> 'control-label']) !!}
                            {!! Form::text('contact_phone[0]', null, ['class' => 'form-control']) !!}
                        </div>
                        <a class="text-danger no-underline remove-row" data-target=".contact-person"><span class="fa fa-minus-circle"></span> {{ trans('Șterge persoana de contact') }}</a>
                        <hr>
                    </div>
                    <a class="marginB15 no-underline clone" data-target=".contact-person"><span class="fa fa-plus-circle"></span> {{ trans('Adaugă persoană de contact nou') }}</a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
