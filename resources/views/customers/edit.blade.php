@extends('app')

@section('title') {{ $customer->name }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model($customer, ['action' => ['CustomersController@update', $customer->id], 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>{{ trans('Editare client') }}</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('CustomersController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-xs-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#general-container"  aria-controls="general-container" role="tab" data-toggle="tab">{{ trans('Informații generale') }}</a></li>
                <li role="presentation"><a href="#contracts-container"  aria-controls="contracts-container" role="tab" data-toggle="tab">{{ trans('Contracte') }}</a></li>
                <li role="presentation"><a href="#others-container"  aria-controls="others-container" role="tab" data-toggle="tab">{{ trans('Alte') }}</a></li>
                <li role="presentation"><a href="#requests-offers-container"  aria-controls="requests-offers-container" role="tab" data-toggle="tab">{{ trans('Cereri de Oferte') }}</a></li>
                <li role="presentation"><a href="#offers-client-container"  aria-controls="others-container" role="tab" data-toggle="tab">{{ trans('Oferte către Client') }}</a></li>
            </ul>
        </div>

        <div class="tab-content col-xs-12 marginT30">
            <div class="tab-pane active" id="general-container" role="tabpanel">
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
                            <div class="form-group @if ($errors->has('short_name')) has-error @endif">
                                {!! Form::label('short_name', trans('Denumire scurtă'), ['class'=> 'control-label']) !!}
                                {!! Form::text('short_name', null, ['class' => 'form-control']) !!}
                                @if ($errors->has('short_name'))
                                    <span class="help-block">{{ $errors->first('short_name') }}</span>
                                @endif
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
                            <h4>{{ trans('Adresa de livrare') }}</h4>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                {!! Form::label('delivery_address', trans('Adresa'), ['class'=> 'control-label']) !!}
                                {!! Form::text('delivery_address', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group city-container">
                                {!! Form::label('delivery_city', trans('Localitate'), ['class'=> 'control-label']) !!}
                                {!! Form::text('delivery_city', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group city-container">
                                {!! Form::label('delivery_county', trans('Județ'), ['class'=> 'control-label']) !!}
                                {!! Form::text('delivery_county', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                {!! Form::label('delivery_country', trans('Țara'), ['class'=> 'control-label']) !!}
                                {!! Form::select('delivery_country', App\Models\Country::lists('name', 'code'), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-5">
                        <div class="row">
                            <h4>{{ trans('Fotografie') }}</h4>
                            <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }} row clearfix">
                                @if ($customer->logo)
                                    <div class="marginB15 col-xs-3" id="image-container">
                                        <img class="marginB5 block img-responsive img-circle" src="{{ action('FilesController@image', base64_encode('customers/thumbs/' . $customer->logo)) }}" alt="{{ $customer->logo }}" />
                                    </div>
                                @endif
                                <div class="col-xs-9">
                                    {!! Form::file('logo', ['class' => 'form-control']) !!}
                                    @if ($customer->logo)
                                        <a class="btn btn-danger marginT10" data-toggle="modal" data-target="#image-delete-modal">{{ trans('Șterge fotografia') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h4>{{ trans('Persoane de contact') }}</h4>
                            @if (count($customer->contacts) > 0)
                                @foreach ($customer->contacts as $k => $contact)
                                    <div class="contact-person">
                                        <div class="form-group">
                                            {!! Form::label('contact_name', trans('Nume') , ['class'=> 'control-label']) !!}
                                            {!! Form::text('contact_name[' . $k . ']', $contact->name, ['class' => 'form-control']) !!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('contact_email', trans('Adresa E-mail') , ['class'=> 'control-label']) !!}
                                            {!! Form::text('contact_email[' . $k . ']', $contact->email, ['class' => 'form-control']) !!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('contact_phone', trans('Telefon') , ['class'=> 'control-label']) !!}
                                            {!! Form::text('contact_phone[' . $k . ']', $contact->phone, ['class' => 'form-control']) !!}
                                        </div>
                                        <a class="text-danger no-underline remove-row" data-target=".contact-person"><span class="fa fa-minus-circle"></span> {{ trans('Șterge persoana de contact') }}</a>
                                        <hr>
                                    </div>
                                @endforeach
                            @else
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
                            @endif
                            <a class="marginB15 no-underline clone" data-target=".contact-person"><span class="fa fa-plus-circle"></span> {{ trans('Adaugă persoană de contact nou') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="contracts-container" role="tabpanel">
                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#contract-files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>
                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal" data-type="contract"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>
                <div class="table-responsive">
                    @include('customers._documents_list', ['documents' => $contract_documents, 'table_id' => 'contract-files-table'])
                </div>
                <h4>{{ trans('Contracte legate de proiecte') }}</h4>
                <div class="table-responsive">
                    @include('customers._documents_without_modify', ['documents' => $project_contracts_documents])
                </div>
            </div>
            <div class="tab-pane" id="others-container" role="tabpanel">
                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#other-files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>
                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal" data-type="other"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>
                <div class="table-responsive">
                    @include('customers._documents_list', ['documents' => $other_documents, 'table_id' => 'other-files-table'])
                </div>
            </div>
            <div class="tab-pane" id="requests-offers-container" role="tabpanel">
                <div class="table-responsive">
                    @include('customers._documents_without_modify', ['documents' => $requests_offers_other_documents])
                </div>
            </div>
            <div class="tab-pane" id="offers-client-container" role="tabpanel">
                <div class="table-responsive">
                    @include('customers._documents_without_modify', ['documents' => $offers_client_other_documents])
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('content-modals')
    <div class="modal fade" id="image-delete-modal">
        {!! Form::open(['action' => ['CustomersController@destroy_photo', $customer->id], 'method' => 'DELETE']) !!}
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
        {!! Form::open(['action' => ['CustomersController@documents_multiple_destroy', $customer->id], 'method' => 'DELETE']) !!}
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
@endsection

@section('css')
    <link href="{{ asset('css/token-input.css') }}?v={{ time() }}" rel="stylesheet" />
@endsection

@section('content-scripts')
    <script src="{{ asset('js/jquery.tokeninput.min.js') }}"></script>
    <script src="{{ asset('js/dropzone.min.js') }}"></script>

    <script>
        jQuery(document).ready(function($) {

            $('.upload-btn').click(function() {
                setDropzoneUpload("{{ action('CustomersController@documents_upload', [$customer->id]) }}"+ '?type=' + $(this).data('type'));
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
        });
    </script>
@endsection
