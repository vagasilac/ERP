@extends('app')

@section('title') {{ $user->firstname }} {{ $user->lastname }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model($user, ['action' => ['UsersController@update', $user->id], 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>{{ trans('Editare angajat') }}</h2>
            <div class="buttons-container">
                @can ('Education add')
                    <a class="btn btn-success marginR15" data-toggle="modal" data-target="#education-create-modal">{{ trans('Adăugare instruire') }}</a>
                @endcan
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('UsersController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-xs-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#general-container"  aria-controls="general-container" role="tab" data-toggle="tab">{{ trans('Informații generale') }}</a></li>
                <li role="presentation"><a href="#emm-container"  aria-controls="documents-container" role="tab" data-toggle="tab">{{ trans('EMM') }}</a></li>
                <li role="presentation"><a href="#personal-documents-container"  aria-controls="personal-documents-container" role="tab" data-toggle="tab">{{ trans('Acte personale') }}</a></li>
                <li role="presentation"><a href="#job-documents-container"  aria-controls="job-documents-container" role="tab" data-toggle="tab">{{ trans('Acte de muncă') }}</a></li>
                <li role="presentation"><a href="#medic-documents-container"  aria-controls="medic-documents-container" role="tab" data-toggle="tab">{{ trans('Fișe medicale') }}</a></li>
                @if (hasPermission('Education list') || $user->id == \Auth::user()->id)
                    <li role="education"><a href="#education-container"  aria-controls="education-container" role="tab" data-toggle="tab">{{ trans('Instruire') }}</a></li>
                @endif
                @if (count($trainer) > 0)
                    @if (hasPermission('Education trainer list') || \Auth::user()->id == $user->id)
                        <li role="trainer"><a href="#trainer-container" aria-controls="trainer-container" role="tab" data-toggle="tab">{{ trans('Trainer') }}</a></li>
                    @endif
                @endif
            </ul>
        </div>

        <div class="tab-content col-xs-12 marginT30">
            <div class="tab-pane active" id="general-container" role="tabpanel">
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
                            {!! Form::text('dob', !is_null($user->dob) ? $user->dob->format('d-m-Y') : null, ['class' => 'form-control has-datepicker']) !!}
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
                            {!! Form::select('status', ['Activ', 'Inactiv'], ($user->status == 'active') ? 0 : 1, ['class' => 'form-control'] ) !!}
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
                    <div class="row @if ($errors->has('role')) has-error @endif">
                        <h4>{{ trans('Roluri') }}</h4>
                        @if ($errors->has('role'))
                            <span class="help-block">{{ $errors->first('role') }}</span>
                        @endif
                        @if (count($roles) > 0)
                            @foreach ($roles as $k => $role)
                                {!! Form::checkbox('role[' . $k . ']', $role->id, $user->hasRole($role->name) ? true : false, ['class' => 'select'] ) !!}
                                {!! Form::label('role[' . $k . ']', trans($role->name), ['class' => 'marginB0 paddingL30']) !!}
                                <br />
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="emm-container" role="tabpanel">
                <div class="table-responsive">
                    <h4>{{ trans('Rulete') }}</h4>
                    @include('users._rulers_list')
                    <h4>{{ trans('Echipamente de măsurare') }}</h4>
                    @include('users._me_list')
                </div>
            </div>
            <div class="tab-pane" id="personal-documents-container" role="tabpanel">
                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#identity-files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>
                <h4>{{ trans('Acte de Identitate') }}</h4>
                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal" data-type="identity"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>
                <div class="table-responsive">
                    @include('users._documents_list', ['documents' => $identity_documents, 'table_id' => 'identity-files-table'])
                </div>
                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#diploma-files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>
                <h4>{{ trans('Diplome') }}</h4>
                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal" data-type="diploma"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>
                <div class="table-responsive">
                    @include('users._documents_list', ['documents' => $diploma_documents, 'table_id' => 'diploma-files-table'])
                </div>
                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#family-files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>
                <h4>{{ trans('Acte familiale') }}</h4>
                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal" data-type="family"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>
                <div class="table-responsive">
                    @include('users._documents_list', ['documents' => $family_documents, 'table_id' => 'family-files-table'])
                </div>
            </div>
            <div class="tab-pane" id="job-documents-container" role="tabpanel">
                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#employment-contract-files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>
                <h4>{{ trans('Contract de Muncă') }}</h4>
                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal" data-type="employment_contract"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>
                <div class="table-responsive">
                    @include('users._documents_list', ['documents' => $employment_contract_documents, 'table_id' => 'employment-contract-files-table'])
                </div>
                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#job-description-files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>
                <h4>{{ trans('Fisa Postului') }}</h4>
                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal" data-type="job_description"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>
                <div class="table-responsive">
                    @include('users._documents_list', ['documents' => $job_description_documents, 'table_id' => 'job-description-files-table'])
                </div>
                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#decision-files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>
                <h4>{{ trans('Decizii') }}</h4>
                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal" data-type="decision"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>
                <div class="table-responsive">
                    @include('users._documents_list', ['documents' => $decision_documents, 'table_id' => 'decision-files-table'])
                </div>
            </div>
            <div class="tab-pane" id="medic-documents-container" role="tabpanel">
                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#medical-record-files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>
                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal" data-type="medical_record"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>
                <div class="table-responsive">
                    @include('users._documents_list', ['documents' => $medical_record_documents, 'table_id' => 'medical-record-files-table'])
                </div>
            </div>
            @if (hasPermission('Education list') || $user->id == \Auth::user()->id)
                <div class="tab-pane" id="education-container" role="tabpanel">
                    @include('users._education')
                </div>
            @endif
            @if (count($trainer) > 0)
                @if (hasPermission('Education trainer list') || \Auth::user()->id == $user->id)
                    <div class="tab-pane" id="trainer-container" role="tabpanel">
                        @include('users._trainer')
                    </div>
                @endif
            @endif
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('content-modals')
    <div class="modal fade" id="image-delete-modal">
        {!! Form::open(['action' => ['UsersController@destroy_photo', $user->id], 'method' => 'DELETE']) !!}
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

    <div class="modal fade" id="upload-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Încărcare fișiere') }}</h4>
                </div>
                <div class="modal-body dropzone-upload">
                    <div class="dz-drag-message">{{ trans('Drag & drop fișierele sau directoarele pe care doriți să le încărcați') }}</div>
                    {!! Form::hidden('_token', csrf_token()) !!}
                    {!! Form::hidden('type', null) !!}
                    <div class="files" id="dropzone-previews">

                        <div id="dropzone-template" class="file-row">
                            <!-- This is used as the file preview template -->
                            <div class="preview-container">
                                <span class="preview"><img data-dz-thumbnail src="{{ asset('img/doc-placeholder.png') }}"/></span>
                            </div>
                            <div>
                                <p class="name" data-dz-name></p>
                                <strong class="error text-danger" data-dz-errormessage></strong>
                            </div>
                            <div>
                                <p class="size" data-dz-size></p>
                            </div>
                            <div class="progress-container">
                                <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                </div>
                            </div>
                            <div class="actions-container">
                                <button type="submit" class="btn btn-primary start">
                                    <i class="glyphicon glyphicon-upload"></i>
                                    <span>{{ trans("Pornește încărcarea") }}</span>
                                </button>
                                <button type="reset" class="btn btn-warning cancel">
                                    <i class="glyphicon glyphicon-ban-circle"></i>
                                    <span>{{ trans("Anulează încărcarea") }}</span>
                                </button>
                                <button data-dz-remove class="btn btn-danger delete" title="{{ trans("Ștergere") }}">
                                    <i class="material-icons">&#xE872;</i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer" id="actions">
                    <span class="fileupload-process hidden">
                      <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                          <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                      </div>
                    </span>
                    <span class="btn btn-primary fileinput-button">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>{{ trans("Adaugă fișiere") }}...</span>
                    </span>
                    <button type="submit" class="btn btn-success start">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>{{ trans("Pornește încărcarea") }}</span>
                    </button>
                    <button type="reset" class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>{{ trans("Anulează încărcarea") }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-modal">
        {!! Form::open(['action' => ['UsersController@documents_multiple_destroy', $user->id], 'method' => 'DELETE']) !!}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Șterge fișiere') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('Doriți să ștergeți aceste fișiere') }}
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

    <div class="modal fade" id="education-edit-modal">
        {!! Form::open(['id' => 'editForm', 'files' => true]) !!}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Editarea instruire') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('description', trans('Descriere program / Tematica instruirii'), ['class' => 'control-label']) !!}
                        {!! Form::text('description', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('trainer', trans('Trainer'), ['class' => 'control-label']) !!}
                        {!! Form::text('trainer', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('EducationController@get_trainers'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'trainer_id', 'data-autocomplete-value' => 'name']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('planned_interval', trans('Planificat'), ['class' => 'control-label input-with-icon']) !!}
                        {!! Form::text('planned_interval', null, ['class' => 'form-control has-daterangepicker']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('accomplished_interval', trans('Realizat'), ['class' => 'control-label input-with-icon']) !!}
                        {!! Form::text('accomplished_interval', null, ['class' => 'form-control has-daterangepicker']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('rating_mode', trans('Mod Evaluare'), ['class' => 'control-label']) !!}
                        {!! Form::select('rating_mode', Config::get('education.rating_mode'), null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('repeat', trans('Trebuie repetată?'), ['class' => 'control-label']) !!}
                        {!! Form::select('repeat', Config::get('education.repeat'), null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('certificate_id', trans('Diploma'), ['class' => 'control-label']) !!}
                        {!! Form::select('certificate_id', [], null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('certificate_nr', trans('Serie'), ['class' => 'control-label']) !!}
                        {!! Form::text('certificate_nr', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Salvare', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>

    <div class="modal fade" id="education-create-modal">
        {!! Form::open(['action' => ['EducationController@store', $user->id], 'id' => 'createForm', 'files' => true, 'method' => 'POST']) !!}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Adaugă instruire') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('description', trans('Descriere program / Tematica instruirii'), ['class' => 'control-label']) !!}
                        {!! Form::text('description', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('trainer', trans('Trainer'), ['class' => 'control-label']) !!}
                        {!! Form::text('trainer', null, ['class' => 'form-control has-combobox', 'data-autocomplete-src' => action('EducationController@get_trainers'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => 'trainer_id', 'data-autocomplete-value' => 'name']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('planned_interval', trans('Planificat'), ['class' => 'control-label input-with-icon']) !!}
                        {!! Form::text('planned_interval', null, ['class' => 'form-control has-daterangepicker']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('accomplished_interval', trans('Realizat'), ['class' => 'control-label input-with-icon']) !!}
                        {!! Form::text('accomplished_interval', null, ['class' => 'form-control has-daterangepicker']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('rating_mode', trans('Mod Evaluare'), ['class' => 'control-label']) !!}
                        {!! Form::select('rating_mode', Config::get('education.rating_mode'), null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('repeat', trans('Trebuie repetată?'), ['class' => 'control-label']) !!}
                        {!! Form::select('repeat', Config::get('education.repeat'), null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('certificate_id', trans('Diploma'), ['class' => 'control-label']) !!}
                        {!! Form::select('certificate_id', $diploma->lists('name', 'id'), null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('certificate_nr', trans('Serie'), ['class' => 'control-label']) !!}
                        {!! Form::text('certificate_nr', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Salvare', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>


@endsection

@section('css')
    <link href="{{ asset('css/token-input.css') }}?v={{ time() }}" rel="stylesheet" />
@endsection

@section('content-scripts')
    @include('users._daterangepicker')
    <script src="{{ asset('js/inputmask/inputmask.min.js') }}"></script>
    <script src="{{ asset('js/inputmask/inputmask.phone.extensions.min.js') }}"></script>
    <script src="{{ asset('js/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('js/inputmask/phone.js') }}"></script>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(":input").inputmask();
        });
    </script>

    <script src="{{ asset('js/jquery.tokeninput.min.js') }}"></script>
    <script src="{{ asset('js/dropzone.min.js') }}"></script>

    <script>
        jQuery(document).ready(function($) {

            $('.upload-btn').click(function() {
                setDropzoneUpload("{{ action('UsersController@documents_upload', [$user->id]) }}"+ '?type=' + $(this).data('type'));
            });

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

            $('.open-edit-modal').click(function() {
                $.ajax({
                    url: "{{ action('EducationController@get_education') }}",
                    data: {'id': $(this).data('id')}
                }).done(function(object) {
                    $('#editForm').attr('action', '{{ action('EducationController@update') }}' + '/' + object.id);
                    $('#editForm input[name="description"]').val(object.description);
                    if (object.role_id != null) {
                        $('#editForm input[name="trainer"]').val(object.role.name);
                    }
                    else if (object.supplier_id != null) {
                        $('#editForm input[name="trainer"]').val(object.supplier.name);
                    }
                    else if (object.other_trainer != null) {
                        $('#editForm input[name="trainer"]').val(object.other_trainer);
                    }
                    else {
                        $('#editForm input[name="trainer"]').val('');
                    }
                    $('#editForm input[name="planned_interval"]').val(moment(object.planned_start_date).format('DD-MM-YYYY') + ' - ' + moment(object.planned_finish_date).format('DD-MM-YYYY'));
                    $('#editForm input[name="accomplished_interval"]').val(moment(object.accomplished_start_date).format('DD-MM-YYYY') + ' - ' + moment(object.accomplished_finish_date).format('DD-MM-YYYY'));
                    $('#editForm select[name="rating_mode"]').val(object.rating_mode);
                    $('#editForm select[name="repeat"]').val(object.repeat);
                    $('#editForm select[name="certificate_id"]').html('');
                    if (object.diplomas != null) {
                        $.each(object.diplomas, function(index, diploma) {
                            $('#editForm select[name="certificate_id"]').append($("<option></option>").attr("value", diploma.file_id).text(diploma.name));
                        });
                    }
                    $('#editForm select[name="certificate_id"]').val(object.certificate_id);
                    $('#editForm input[name="certificate_nr"]').val(object.certificate_nr);
                    $('#education-edit-modal').modal('show');
                });
            });
        });
    </script>

@endsection
