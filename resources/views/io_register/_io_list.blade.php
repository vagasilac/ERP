@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-striped" id="io-table">
    <thead>
    <tr>
        <th width="40" rowspan="2">
            <div class="checkbox-inline">
                {!! Form::checkbox('select_all' , 1, false, ['class' => 'select'] ) !!}{!! Form::label('select_all', '&nbsp;', ['class' => 'marginB0']) !!}
            </div>
        </th>
        <th class="paddingL0 paddingR0" width="10"></th>
        <th class="sortable text-left"><a data-field="date" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "date") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "date")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Data ieșirii') }}</a></th>
        <th class="sortable text-left"><a data-field="number" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "number") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "number")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Nr. înreg.') }}</a></th>
        <th class="sortable text-left"><a data-field="description" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "description") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "description")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Denumire/Conținut') }}</a></th>
        <th class="sortable text-left"><a data-field="receiver" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "receiver") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "receiver")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Destinatar') }}</a></th>
        <th class="sortable text-left"><a data-field="target" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "target") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "target")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Proiect(e) aferent(e)') }}</a></th>
        <th class="sortable text-left with-right-border"><a data-field="user" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "user") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "user")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Completat de către') }}</a></th>
        <th class="sortable text-left"><a data-field="received_date" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "received_date") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "received_date")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Data rezolvării') }}</a></th>
        <th class="sortable text-left"><a data-field="invoice_number" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "invoice_number") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "invoice_number")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Nr. factură') }}</a></th>
        <th class="sortable text-left"><a data-field="notice_number" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "notice_number") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "notice_number")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Nr. aviz') }}</a></th>
    </tr>
    </thead>
    <tbody>

    @if (count($items) > 0)
        @foreach ($items as $k => $item)
            <tr>
                <td>{!! Form::checkbox('select_' . $item->id , $item->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $item->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                <td class="paddingL0 paddingR0" >@if (count($item->documents) > 0) <i class="material-icons">&#xE24D;</i> @endif</td>
                <td><div class="user-tag-sm"><a href="{{ action('InputsOutputsRegisterController@edit', $item->id) }}">{{ $item->date->format('d/m/Y') }}</a></div></td>
                <td><div class="user-tag-sm"><a href="{{ action('InputsOutputsRegisterController@edit', $item->id) }}">{{ $item->number }}</a></div></td>
                <td><div class="user-tag-sm"><a href="{{ action('InputsOutputsRegisterController@edit', $item->id) }}">{{ $item->description  }}</a></div></td>
                <td><div class="user-tag-sm"><a href="{{ action('InputsOutputsRegisterController@edit', $item->id) }}">{{ $item->receiver  }}</a></div></td>
                <td><div class="user-tag-sm"><a href="{{ action('InputsOutputsRegisterController@edit', $item->id) }}">{{ $item->target  }}</a></div></td>
                <td class="with-right-border"><div class="user-tag-sm"><a href="{{ action('InputsOutputsRegisterController@edit', $item->id) }}">{{ !is_null($item->user) ? $item->user->name() : ''  }}</a></div></td>
                <td><div class="user-tag-sm"><a href="{{ action('InputsOutputsRegisterController@edit', $item->id) }}">{{ !is_null($item->received_date) ? $item->received_date->format('d/m/Y') : '' }}</a></div></td>
                <td><div class="user-tag-sm"><a href="{{ action('InputsOutputsRegisterController@edit', $item->id) }}">{{ $item->invoice_number  }}</a></div></td>
                <td><div class="user-tag-sm"><a href="{{ action('InputsOutputsRegisterController@edit', $item->id) }}">{{ $item->notice_number  }}</a></div></td>
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