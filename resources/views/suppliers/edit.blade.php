@extends('app')

@section('title') {{ $supplier->name }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model($supplier, ['action' => ['SuppliersController@update', $supplier->id], 'id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header col-xs-12">
            <h2>{{ trans('Editare furnizor aprobat') }}</h2>
            <div class="buttons-container">
                {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default']) !!}
                <a href="{{ action('SuppliersController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-xs-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#general"  aria-controls="general" role="tab" data-toggle="tab">{{ trans('Informații generale') }}</a></li>
                <li role="presentation"><a href="#rating"  aria-controls="rating" role="tab" data-toggle="tab">{{ trans('Evaluare') }}</a></li>
                <li role="presentation"><a href="#contracts-container"  aria-controls="contracts-container" role="tab" data-toggle="tab">{{ trans('Contracte') }}</a></li>
                <li role="presentation"><a href="#others-container"  aria-controls="others-container" role="tab" data-toggle="tab">{{ trans('Alte') }}</a></li>
            </ul>
        </div>

        <div class="tab-content col-xs-12 marginT30">
            <div class="tab-pane active" id="general" role="tabpanel">
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
                            <h4>{{ trans('Alte adrese') }}</h4>
                        </div>
                        <div class="row marginB30">
                            @if (count($supplier->addresses) > 0)
                                @foreach ($supplier->addresses as $k => $address)
                                    <div class="additional-address">
                                        <div class="form-group">
                                            {!! Form::label('_address', trans('Adresa'), ['class'=> 'control-label']) !!}
                                            {!! Form::text('additional_address[' . $k . ']', $address->address, ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="form-group city-container">
                                            {!! Form::label('additional_city', trans('Localitate'), ['class'=> 'control-label']) !!}
                                            {!! Form::text('additional_city[' . $k . ']', $address->city, ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="form-group city-container">
                                            {!! Form::label('additional_county', trans('Județ'), ['class'=> 'control-label']) !!}
                                            {!! Form::text('additional_county[' . $k . ']', $address->county, ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('additional_country', trans('Țara'), ['class'=> 'control-label']) !!}
                                            {!! Form::select('additional_country[' . $k . ']', App\Models\Country::lists('name', 'code'), $address->country, ['class' => 'form-control']) !!}
                                        </div>

                                        <a class="text-danger no-underline remove-row" data-target=".additional-address"><span class="fa fa-minus-circle"></span> {{ trans('Șterge adresa') }}</a>
                                        <hr>
                                    </div>
                                @endforeach
                            @else
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
                            @endif
                            <a class="marginB15 no-underline clone" data-target=".additional-address"><span class="fa fa-plus-circle"></span> {{ trans('Adaugă adresă nou') }}</a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-5">
                        <div class="row">
                            <h4>{{ trans('Fotografie') }}</h4>
                            <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }} row clearfix">
                                @if ($supplier->logo)
                                    <div class="marginB15 col-xs-3" id="image-container">
                                        <img class="marginB5 block img-responsive img-circle" src="{{ action('FilesController@image', base64_encode('suppliers/thumbs/' . $supplier->logo)) }}" alt="{{ $supplier->logo }}" />
                                    </div>
                                @endif
                                <div class="col-xs-9">
                                    {!! Form::file('logo', ['class' => 'form-control']) !!}
                                    @if ($supplier->logo)
                                        <a class="btn btn-danger marginT10" data-toggle="modal" data-target="#image-delete-modal">{{ trans('Șterge fotografia') }}</a>
                                    @endif
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
                                    {!! Form::checkbox('type[' . $k . ']', $type->id, $supplier->hasType($type->name) ? true : false, ['class' => 'select'] ) !!}
                                    {!! Form::label('type[' . $k . ']', trans($type->name), ['class' => 'marginB0 paddingL30']) !!}
                                    <br />
                                @endforeach
                            @endif
                        </div>
                        <div class="row">
                            <h4>{{ trans('Persoane de contact') }}</h4>
                            @if (count($supplier->contacts) > 0)
                                @foreach ($supplier->contacts as $k => $contact)
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
                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal"  data-type="contract"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>
                <div class="table-responsive">
                    @include('suppliers._documents_list', ['documents' => $contract_documents, 'table_id' => 'contract-files-table'])
                </div>
            </div>
            <div class="tab-pane" id="others-container" role="tabpanel">
                <div class="actions-bar clearfix paddingT10 paddingB10" data-target="#other-files-table">
                    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>

                        <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                    </div>
                </div>
                <a class="btn btn-sm btn-default marginT15 marginB15 upload-btn" type="button" data-toggle="modal" data-target="#upload-modal"  data-type="other"><i class="material-icons">&#xE2C6;</i> {{ trans('Încărcare documente') }}</a>
                <div class="table-responsive">
                    @include('suppliers._documents_list', ['documents' => $other_documents, 'table_id' => 'other-files-table'])
                </div>
            </div>
            <div class="tab-pane rating-container" id="rating" role="tabpanel">
                <h4>{{ trans('Per total') }}</h4>
                <input id="average_rating" name="average_rating" type="number" class="rating" value="{{ $supplier->average_rating }}" readonly="readonly" step="0.01" data-language="ro" data-show-clear="false" data-size="xs" data-theme="krajee-svg">
                <h4 class="marginT30">{{ trans('Detaliat') }}</h4>
                <div class="row">
                    @foreach ($rating_options as $rating_option)
                    <div class="col-xs-6 col-sm-4 col-md-3 marginB15">
                        <label>{{ $rating_option->name }}</label>
                        <input type="number" class="rating" value="{{ isset($supplier_ratings[$rating_option->id]) ? $supplier_ratings[$rating_option->id] : 0 }}" readonly="readonly" step="0.01" data-language="ro" data-show-clear="false" data-size="xs" data-theme="krajee-svg">
                    </div>
                    @endforeach
                </div>
                <a class="btn btn-sm btn-default marginT15 marginB15" type="button" data-toggle="modal" data-target="#rating-modal"><i class="material-icons">&#xE145;</i> {{ trans('Evaluare nouă') }}</a>
                <a class="marginL15" data-toggle="modal" data-target="#view-ratings-modal">Vezi toate evaluările</a>
            </div>

        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('content-modals')
    <div class="modal fade" id="image-delete-modal">
        {!! Form::open(['action' => ['SuppliersController@destroy_photo', $supplier->id], 'method' => 'DELETE']) !!}
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
        {!! Form::open(['action' => ['SuppliersController@documents_multiple_destroy', $supplier->id], 'method' => 'DELETE']) !!}
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

    <div class="modal fade" id="rating-modal">
        {!! Form::open(['action' => ['SuppliersController@rating', $supplier->id], 'method' => 'POST']) !!}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Evaluare furnizor aprobat') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('order_number', trans('Număr comandă') , ['class'=> 'control-label']) !!}
                        {!! Form::text('order_number', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="row rating-container">
                        @foreach ($rating_options as $rating_option)
                            <div class="col-xs-6 marginB15">
                                <label>{{ $rating_option->name }}</label>
                                <input name="rating[{{ $rating_option->id }}]" type="number" class="rating" step="0.5" data-language="ro" data-show-clear="false" data-size="xs" data-theme="krajee-svg">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Adaugă', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="modal fade" id="view-ratings-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Evaluare furnizor aprobat') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row rating-container">
                        @foreach ($supplier->ratings as $rating)
                            <div class="clearfix">
                                <h5 class="col-xs-12">{{ trans('suppliers.:user a evaluat acest furnizor în data de :date', ['user' => $rating->user->name(), 'date' => $rating->created_at->format('d.m.Y')]) }} @if (!is_null($rating->order_number) && $rating->order_number != '') ({{ trans('Număr comandă') }}: {{ $rating->order_number }}) @endif</h5>
                                @foreach ($rating->options as $option)
                                    <div class="col-xs-6 marginB15">
                                        <label>{{ $option->name }}</label>
                                        <input type="number" class="rating" value="{{ $option->pivot->value }}" readonly="readonly" step="0.01" data-language="ro" data-show-clear="false" data-size="xs" data-theme="krajee-svg">
                                    </div>
                                @endforeach
                            </div>
                            <div class="separator marginB15"></div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Adaugă', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link href="{{ asset('css/star-rating.css') }}?v={{ time() }}" rel="stylesheet" />
    <link href="{{ asset('css/star-rating-theme.css') }}?v={{ time() }}" rel="stylesheet" />
@endsection

@section('content-scripts')
    <script src="{{ asset('js/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/star-rating.min.js') }}"></script>
    <script src="{{ asset('js/star-rating-theme.min.js') }}"></script>
    <script src="{{ asset('js/star-rating-ro.min.js') }}"></script>

    <script>
        (function ($) {
            $.fn.rating.defaults.starCaptionClasses = function (val) {
                if (val == 0 || val == null) {
                    return 'label label-default';
                }
                else if (val < 2) {
                    return 'label label-danger';
                }
                else if (val >= 2 && val < 4) {
                    return 'label label-warning';
                }
                else {
                    return 'label label-success';
                }
            };
        })(window.jQuery);

        jQuery(document).ready(function($) {
            $('.upload-btn').click(function() {
                setDropzoneUpload("{{ action('SuppliersController@documents_upload', [$supplier->id]) }}"+ '?type=' + $(this).data('type'));
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
