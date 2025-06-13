@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-striped" id="cr-table">
    <thead>
    <tr>
        <th width="40" rowspan="2">
            <div class="checkbox-inline">
                {!! Form::checkbox('select_all' , 1, false, ['class' => 'select'] ) !!}{!! Form::label('select_all', '&nbsp;', ['class' => 'marginB0']) !!}
            </div>
        </th>

        <th class="sortable text-left"><a data-field="id" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "id") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "id")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Nr Înregistrare') }}</a></th>
        <th class="sortable text-left"><a data-field="created_at" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "created_at") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "created_at")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Data înregistrării') }}</a></th>
        <th class="sortable text-left"><a data-field="nr_date_of_contract" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "nr_date_of_contract") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "nr_date_of_contract")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Nr. și data contractului') }}</a></th>
        <th class="text-left">{{ trans('Partener') }}</th>
        <th class="sortable text-left"><a data-field="user_id" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "user_id") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "user_id")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Încărcat de') }}</a></th>

    </tr>
    </thead>
    <tbody>

    @if (count($items) > 0)
        @foreach ($items as $k => $item)
            <tr>
                <td>{!! Form::checkbox('select_' . $item->id , $item->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $item->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                <td><div class="user-tag-sm"><a href="{{ action('ContractRegisterController@edit', $item->id) }}">{{ $item->id }}</a></div></td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                <td>{{ $item->nr_date_of_contract  }}</td>
                <td>@if ($item->supplier_id != null) {{ $item->supplier->name }} @else {{ $item->customer->name }} @endif</td>
                <td>@if (!is_null($item->user))<div class="user-tag-sm"><a href="{{ action('ContractRegisterController@edit', $item->id) }}">@if ($item->user->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $item->user->photo)) }}" alt="{{ $item->user->lastname }} {{ $item->user->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($item->user->id % count($colors)) + 1]) ? $colors[($item->user->id % count($colors)) + 1] : '' }}">{{ substr($item->user->lastname, 0, 1) }}{{ substr($item->user->firstname, 0, 1) }}</span>@endif{{ !is_null($item->user) ? $item->user->name() : ''  }}</a></div>@endif</td>
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
