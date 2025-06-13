<div class="row">
    <div class="form-group col-sm-6">
        <label for="ctcnumber">{{ trans('Număr intern al certificatului') }}</label>
        <input type="text" class="form-control" name="ctcnumber" id="ctcnumber" @if($offer->ctc_number)value="{{ $offer->ctc_number }}" @endif />
    </div>
    <div class="form-group col-sm-6 @if($offer->ctc_file) file-upload hidden @endif">
        <label for="ctcfile">{{ trans('CTC file') }}</label>
        <input type="file" class="form-control" name="ctcfile" id="ctcfile" />
    </div>
    @if($offer->ctc_file)
        <div class="form-group the-file">
            <a class="marginT30 paddingT5 inline-block" href="{{ action('InventoryController@downloadCtcFile', ['id' => $offer->ctc_file]) }}">{{ basename($offer->ctcFile->file) }}</a>
            <a class="btn btn-sm btn-danger" onclick="jQuery(this).parent().parent().find('.file-upload').removeClass('hidden'); jQuery(this).parent().addClass('hidden');">Remove</a>
        </div>
    @endif
    <input type="hidden" name="id" id="ctcid" value="{{$offer->id}}"/>
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        <label for="ctcertno">{{ trans('Număr certificat de calitate') }}</label>
        <input type="text" class="form-control" name="ctcertno" id="ctcertno" @if($offer->ctc_certificate_no)value="{{ $offer->ctc_certificate_no }}" @endif />
    </div>
    <div class="form-group col-sm-6">
        <label for="ctcsarja">{{ trans('Număr sarja') }}</label>
        <input type="text" class="form-control" name="ctcsarja" id="ctcsarja" @if($offer->ctc_sarja)value="{{ $offer->ctc_sarja }}" @endif />
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        <label for="ctccert">{{ trans('Calitate certificată') }}</label>
        <input class="form-control input-lg has-combobox" name="ctccert" type="text" data-autocomplete-src="{{ action('InventoryController@getAllStandards') }}" data-autocomplete-data="data" data-autocomplete-id="id" data-autocomplete-value="EN" @if($offer->material->certificate)data-autocomplete-default-value="{{ $offer->material->certificate->id }}" value="{{ $offer->material->certificate->EN }}" @endif/>
    </div>
</div>

<script>
    jQuery(document).ready(function(){
        initComboBox();
    })
</script>