@extends('app')

@section('title') {{ $user->firstname }} {{ $user->lastname }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model($user, ['action' => 'ProfileController@update', 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>{{ trans('Editare profil') }}</h2>
            <div class="buttons-container">{!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}</div>
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
                        {!! Form::text('email', null, ['class' => 'form-control', 'disabled']) !!}
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
                    <div class="form-group">
                        {!! Form::label('phone', trans('Telefon'), ['class' => 'control-label']) !!}
                        {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('personal_phone', trans('Telefon personal'), ['class' => 'control-label']) !!}
                        {!! Form::text('personal_phone', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('dob', trans('Data nașterii'), ['class'=> 'control-label']) !!}
                        {!! Form::text('dob', date('d-m-Y',strtotime($user->dob)), ['class' => 'form-control validate[required,custom[dateFormatCustom],customPast[' . \Carbon\Carbon::now()->subYear(18)->format('d-m-Y') . '] dob-datepicker']) !!}
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
            </div>
            <div class="col-xs-12 col-sm-5">
                <div class="row">
                    <h4>{{ trans('Fotografie') }}</h4>
                    <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }} row clearfix">
                        @if ($user->photo)
                            <div class="marginB15 col-xs-3" id="image-container">
                                <img class="marginB5 block img-responsive img-circle" src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $user->photo)) }}" alt="{{ $user->photo }}" />
                            </div>
                        @endif
                        <div class="col-xs-9">
                            {!! Form::file('photo', ['class' => 'form-control']) !!}
                            @if ($user->photo)
                                <a class="btn btn-danger marginT10" data-toggle="modal" data-target="#image-delete-modal">{{ trans('Șterge fotografia') }}</a>
                            @endif
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
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('content-modals')
    <div class="modal fade" id="image-delete-modal">
        {!! Form::open(['action' => ['ProfileController@destroy_photo'], 'method' => 'DELETE']) !!}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Șterge fotografie') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('Doriți să ștergeți această fotografie?') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Șterge', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
