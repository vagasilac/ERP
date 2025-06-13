<table class="table table-striped" id="me-table">
    <thead>
    <tr>
        <th class="sortable text-left">{{ trans('Denumire') }}</th>
        <th class="sortable text-left">{{ trans('Identificare') }}</th>
        <th class="sortable text-left">{{ trans('Valabilitatea calibrării') }}</th>
        <th class="sortable text-left">{{ trans('Domeniu de măsurare') }}</th>
    </tr>
    </thead>
    <tbody>

    @if (count($equipments) > 0)
        @foreach ($equipments as $k => $item)
            <tr>
                <td><div class="user-tag-sm">@if ($item->photo != '')<img src="{{ action('FilesController@image', base64_encode('ims/measuring_equipments/'.$item->id.'/photos/thumbnails/'.$item->photo)) }}}" />@else <span class="placeholder"><i class="material-icons">&#xE8B8;</i></span> @endif {{ $item->name }}</div></td>
                <td>{{ $item->inventory_number }}</td>
                <td>{{ $item->calibration_validity }}</td>
                <td>{{ $item->measuring_range }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="13">{{ trans('Nu există înregistrări') }}</td>
        </tr>
    @endif
    </tbody>
</table>
