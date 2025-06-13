@if($material->offer->offer_suppliers->count() > 0)
    @foreach($material->offer->offer_suppliers as $offer_supplier)
        <fieldset>
            <legend>{{ $offer_supplier->supplier->name }}</legend>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label class="control-label">{{ trans('Preț') }}</label>
                        <div class="input-group">
                            <input class="form-control" name="price[{{ $offer_supplier->id }}]" type="text" @if( $offer_supplier->price) value="{{ $offer_supplier->price }}" @endif/>
                            <span class="input-group-addon">EUR</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label class="control-label input-with-icon">{{ trans('Data ofertei') }}</label>
                        <input class="form-control has-datepicker" name="date[{{ $offer_supplier->id }}]" type="text" @if( $offer_supplier->offer_received_at) value="{{ $offer_supplier->offer_received_at }}"@endif />
                    </div>
                </div>
                <div class="row">
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label class="control-label">{{ trans('Numărul ofertei') }}</label>
                        <input class="form-control" name="offer_number[{{ $offer_supplier->id }}]" type="text" @if( $offer_supplier->offer_received_number) value="{{ $offer_supplier->offer_received_number }}"  @endif/>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group row @if($offer_supplier->offer_file) file-upload hidden @endif">
                        <div class="col-xs-4">
                            <label class="paddingT15">{{ trans('Încărcare ofertă') }}:</label>
                        </div>
                        <div class="col-xs-8">
                            <input class="form-control" name="offer_file[{{ $offer_supplier->id }}]" type="file" />
                        </div>
                    </div>
                    @if($offer_supplier->offer_file)
                    <div class="form-group the-file">
                        <a class="marginT15 inline-block" href="{{ action('InventoryController@downloadOfferFile', ['id' => $offer_supplier->offer_file]) }}">{{ basename($offer_supplier->fileOffer->file) }}</a>
                        <a class="btn btn-sm btn-danger" onclick="jQuery(this).parent().parent().find('.file-upload').removeClass('hidden'); jQuery(this).parent().addClass('hidden');">Remove</a>
                    </div>
                    @endif
                </div>
            </div>
        </fieldset>

    @endforeach
@endif