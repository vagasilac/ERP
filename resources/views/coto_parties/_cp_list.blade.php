@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-striped" id="ru-table">
    <thead>
    <tr>
        <th width="40" rowspan="2">
            <div class="checkbox-inline">
                {!! Form::checkbox('select_all' , 1, false, ['class' => 'select'] ) !!}{!! Form::label('select_all', '&nbsp;', ['class' => 'marginB0']) !!}
            </div>
        </th>

        <th class="sortable text-left"><a data-field="interested_party" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "interested_party") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "interested_party")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Partea interesată') }}</a></th>
        <th class="sortable text-left"><a data-field="int_ext" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "int_ext") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "int_ext")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Internal/External') }}</a></th>
        <th class="sortable text-left"><a data-field="reason_for_inclusion" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "reason_for_inclusion") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "reason_for_inclusion")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Motiv pentru includere') }}</a></th>

    </tr>
    </thead>
    <tbody>

    @if (count($items) > 0)
        @foreach ($items as $k => $item)
            <tr>
                <td>{!! Form::checkbox('select_' . $item->id , $item->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $item->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                <td><div class="user-tag-sm"><a href="{{ action('CotoPartiesController@edit', $item->id) }}">{{ $item->interested_party }}</a></div></td>
                <td>{{ $item->int_ext  }}</td>
                <td>{{ $item->reason_for_inclusion }}</td>
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
