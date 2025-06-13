
<table class="table table-striped" id="ru-table">
    <thead>
    <tr>
        <th class="sortable text-left">{{ trans('Denumire') }}</th>
        <th class="sortable text-left">{{ trans('Identificare') }}</th>
        <th class="sortable text-left">{{ trans('Domeniu de măsurare') }}</th>
    </tr>
    </thead>
    <tbody>

    @if (count($rulers) > 0)
    @foreach ($rulers as $k => $item)
    <tr>
        <td><div class="user-tag-sm">@if ($item->photo != '')<img src="{{ action('FilesController@image', base64_encode('ims/rulers/'.$item->id.'/photos/thumbnails/'.$item->photo)) }}}" />@else <span class="placeholder"><i class="material-icons">&#xE8B8;</i></span> @endif {{ $item->name }}</div></td>
        <td>{{ $item->inventory_number }}</td>
        <td>{{ $item->measuring_range  }}</td>
    </tr>
    @endforeach
    @else
    <tr>
        <td colspan="13">{{ trans('Nu există înregistrări') }}</td>
    </tr>
    @endif
    </tbody>
</table>
