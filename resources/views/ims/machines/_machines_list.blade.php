@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-striped" id="machines-table">
    <thead>
    <tr>
        <th width="40" rowspan="2">
            <div class="checkbox-inline">
                {!! Form::checkbox('select_all' , 1, false, ['class' => 'select'] ) !!}{!! Form::label('select_all', '&nbsp;', ['class' => 'marginB0']) !!}
            </div>
        </th>
        <th class="sortable text-left"><a data-field="name" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Denumire') }}</a></th>
        <th class="sortable text-left"><a data-field="inventory_no" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "inventory_no") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "inventory_no")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Identificare') }}</a></th>
        <th class="sortable text-left"><a data-field="source" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "source") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "source")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Sursa') }}</a></th>
        <th class="sortable text-left"><a data-field="manufacturing_year" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "manufacturing_year") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "manufacturing_year")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Anul fabricației') }}</a></th>
        <th class="sortable text-left"><a data-field="type" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "type") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "type")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Tip') }}</a></th>
        <th class="sortable text-left"><a data-field="power" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "power") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "power")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Putere') . ' (kW)' }}</a></th>
        <th class="sortable text-left"><a data-field="operation" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "operation") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "operation")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Operație') }}</a></th>
        <th class="sortable text-left"><a data-field="maintenance_log" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "maintenance_log") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "maintenance_log")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Jurnal de mentenanta') }}</a></th>
        <th class="sortable text-left"><a data-field="hourly_rate" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "hourly_rate") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "hourly_rate")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Tarif manoperă') . ' (&euro;/h)' }}</a></th>
        <th class="sortable text-left"><a data-field="observation" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "observation") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "observation")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Obs.') }}</a></th>
    </tr>
    </thead>
    <tbody>

    @if (count($items) > 0)
        @foreach ($items as $k => $item)
            <tr>
                <td>{!! Form::checkbox('select_' . $item->id , $item->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $item->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                <td><div class="user-tag-sm"><a href="{{ action('MachinesController@edit', $item->id) }}">@if ($item->photo != '')<img src="{{ action('FilesController@image', base64_encode('ims/machines/' . $item->id . '/photos/thumbs/' . $item->photo)) }}" alt="{{ $item->name }}" />@else <span class="placeholder"><i class="material-icons">&#xE8B8;</i></span> @endif {{ $item->name }}</a></div></td>
                <td>{{ $item->inventory_no }}</td>
                <td>{{ $item->source }}</td>
                <td>{{ $item->manufacturing_year }}</td>
                <td>{{ $item->type }}</td>
                <td>{{ $item->power }}</td>
                <td>{{ !is_null($item->operation) ? $item->operation->name : '' }}</td>
                <td>{{ Config::get('machines.maintenance_log.' . $item->maintenance_log) }}</td>
                <td>{{ $item->hourly_rate }}</td>
                <td>{{ $item->observations }}</td>
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
