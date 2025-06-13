@foreach($materials_in_stock as $m)
<div class="row">
    <div class="form-group col-sm-4">
        <label for="quantity">{{ trans('Valoare') }}</label>
        <input type="text" class="form-control" name="quantity[{{ $m->id }}]" id="quantity" value="{{$m->quantity}}"/>
    </div>
    <div class="form-group col-sm-4">
        <label for="pieces">{{ trans('Bucăți') }}</label>
        <input type="text" class="form-control" name="pieces[{{ $m->id }}]" id="pieces" value="{{$m->pieces}}"/>
    </div>
    <div class="form-group col-sm-4">
        <a class="btn btn-primary marginT30 reserve-stock" data-dismiss="modal" data-id="{{ $m->id }}">{{ trans('Rezervare') }}</a>
    </div>
</div>
@endforeach
<input type="hidden" id="stock_material_id" name="stock_material_id" value="{{ $material->id }}" />
<input type="hidden" name="_token" value="{{ csrf_token() }}"/>