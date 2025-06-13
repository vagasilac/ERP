@foreach($materials as $material)
    @if($material->offer->count() > 0 && $material->offer->status == 'offer_received')
            <fieldset>
                <legend>{{ $material->material_info->name }}</legend>
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">{{ trans('Furnizor aprobat') }}</label>
                            <select class="form-control" name="suppliers[{{ $material->offer->id }}]">
                                @foreach($material->offer->offer_suppliers as $offer_supplier)
                                    <option value="{{ $offer_supplier->id }}">{{ $offer_supplier->supplier->name }} - {{ $offer_supplier->price }} EUR</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>
    @endif
@endforeach
