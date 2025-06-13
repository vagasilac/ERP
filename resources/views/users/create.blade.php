@extends('app')

@section('title') {{ trans('Adaugă angajat') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model(null, ['action' => 'UsersController@store', 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>{{ trans('Profil angajat') }}</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('UsersController@index') }}" class="btn btn-secondary marginL15 ">{{ trans('Înapoi') }}</a>
            </div>

        </div>
        <div class="col-md-10">
            <div class="col-xs-12 col-sm-6 marginR15">
                <div class="row">
                    <h4>{{ trans('Profil') }}</h4>
                </div>
                <div class="row">
                    <div class="form-group @if ($errors->has('firstname')) has-error @endif">
                        {!! Form::label('firstname', trans('Prenume') , ['class'=> 'control-label']) !!}
                        {!! Form::text('firstname', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('firstname'))
                            <span class="help-block">{{ $errors->first('firstname') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group @if ($errors->has('lastname')) has-error @endif">
                        {!! Form::label('lastname', trans('Nume'), ['class'=> 'control-label']) !!}
                        {!! Form::text('lastname', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('lastname'))
                            <span class="help-block">{{ $errors->first('lastname') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group @if ($errors->has('email')) has-error @endif">
                        {!! Form::label('email', trans('Adresa de email'), ['class'=> 'control-label']) !!}
                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        @if ($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('personal_email', trans('Adresa personală de email'), ['class'=> 'control-label']) !!}
                        {!! Form::text('personal_email', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('job_title', trans('Poziția curentă'), ['class'=> 'control-label']) !!}
                        {!! Form::text('job_title', null , ['class' => 'form-control']) !!}
                    </div>
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
                    <div class="form-group @if ($errors->has('phone')) has-error @endif">
                        {!! Form::label('phone', trans('Telefon'), ['class' => 'control-label']) !!}
                        {!! Form::text('phone', null, ['class' => 'form-control', 'data-inputmask' => "'alias': 'phone'"]) !!}
                        @if ($errors->has('phone'))
                            <span class="help-block">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group @if ($errors->has('personal_phone')) has-error @endif">
                        {!! Form::label('personal_phone', trans('Telefon personal'), ['class' => 'control-label']) !!}
                        {!! Form::text('personal_phone', null, ['class' => 'form-control', 'data-inputmask' => "'alias': 'phone'"]) !!}
                        @if ($errors->has('personal_phone'))
                            <span class="help-block">{{ $errors->first('personal_phone') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('dob', trans('Data nașterii'), ['class'=> 'control-label input-with-icon']) !!}
                        {!! Form::text('dob', null, ['class' => 'form-control has-datepicker']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('id_card', trans('Carte de identitate'), ['class' => 'control-label']) !!}
                        {!! Form::text('id_card', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('bank_account', trans('Cont bancar'), ['class' => 'control-label']) !!}
                        {!! Form::text('bank_account', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('locker_room_number', trans('Număr vestiar'), ['class' => 'control-label']) !!}
                        {!! Form::text('locker_room_number', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('rfid', trans('Numărul cardului RFID'), ['class' => 'control-label']) !!}
                        {!! Form::text('rfid', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <h4>{{ trans('Stare') }}</h4>
                    <div class="form-group">
                        {!! Form::select('status', ['Activ', 'Inactiv'], null, ['class' => 'form-control']) !!}
                    </div>
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
                <div class="row">
                    <h4>{{ trans('Parola') }}</h4>
                    <div class="form-group @if ($errors->has('password')) has-error @endif">
                        {!! Form::label('password', trans('Parola'), ['class' => 'control-label']) !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                        @if ($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('password_confirmation', trans('Confirmă parola'), ['class' => 'control-label']) !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row @if ($errors->has('role')) has-error @endif">
                    <h4>{{ trans('Roluri') }}</h4>
                    @if ($errors->has('role'))
                        <span class="help-block">{{ $errors->first('role') }}</span>
                    @endif
                    @if (count($roles) > 0)
                        @foreach ($roles as $k => $role)
                            {!! Form::checkbox('role[' . $k . ']', $role->id, false, ['class' => 'select'] ) !!}
                            {!! Form::label('role[' . $k . ']', trans($role->name), ['class' => 'marginB0 paddingL30']) !!}
                            <br />
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('content-scripts')
    <script src="{{ asset('js/inputmask/inputmask.min.js') }}"></script>
    <script src="{{ asset('js/inputmask/inputmask.phone.extensions.min.js') }}"></script>
    <script src="{{ asset('js/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('js/inputmask/phone.js') }}"></script>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(":input").inputmask();
        });
    </script>

@endsection
