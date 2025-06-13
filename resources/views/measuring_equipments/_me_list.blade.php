@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-striped" id="me-table">
    <thead>
    <tr>
        <th width="40" rowspan="2">
            <div class="checkbox-inline">
                {!! Form::checkbox('select_all' , 1, false, ['class' => 'select'] ) !!}{!! Form::label('select_all', '&nbsp;', ['class' => 'marginB0']) !!}
            </div>
        </th>
        
        <th class="sortable text-left"><a data-field="name" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Denumire') }}</a></th>
        <th class="sortable text-left"><a data-field="inventory_number" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "inventory_number") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "inventory_number")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Identificare') }}</a></th>
        <th class="sortable text-left"><a data-field="calibration_validity" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "calibration_validity") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "calibration_validity")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Valabilitatea calibrării') }}</a></th>
        <th class="sortable text-left"><a data-field="measuring_range" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "measuring_range") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "measuring_range")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Domeniu de măsurare') }}</a></th>
        <th class="sortable text-left"><a data-field="user_id" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "user_id") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "user_id")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Utilizator') }}</a></th>


    </tr>
    </thead>
    <tbody>

    @if (count($items) > 0)
        @foreach ($items as $k => $item)
            <tr>
                <td>{!! Form::checkbox('select_' . $item->id , $item->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $item->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                <td><div class="user-tag-sm"><a href="{{ action('MeasuringEquipmentsController@edit', $item->id) }}">@if ($item->photo != '')<img src="{{ action('FilesController@image', base64_encode('ims/measuring_equipments/'.$item->id.'/photos/thumbnails/'.$item->photo)) }}}" />@else <span class="placeholder"><i class="material-icons">&#xE8B8;</i></span> @endif {{ $item->name }}</a></div></td>
                <td>{{ $item->inventory_number }}</td>
                <td>{{ $item->calibration_validity }}</td>
                <td>{{ $item->measuring_range }}</td>
                <td>@if (!is_null($item->user))<div class="user-tag-sm"><a href="{{ action('MeasuringEquipmentsController@edit', $item->id) }}">@if ($item->user->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $item->user->photo)) }}" alt="{{ $item->user->lastname }} {{ $item->user->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($item->user->id % count($colors)) + 1]) ? $colors[($item->user->id % count($colors)) + 1] : '' }}">{{ substr($item->user->lastname, 0, 1) }}{{ substr($item->user->firstname, 0, 1) }}</span>@endif{{ !is_null($item->user) ? $item->user->name() : ''  }}</a></div>@endif</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="13">{{ trans('Nu există înregistrări') }}</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="text-center">
    {!! $items->render() !!}
</div>
