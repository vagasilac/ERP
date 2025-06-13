@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-striped table-bordered table-calculation table-materials" id="standards-table">
    <thead>
    <tr>
        <th width="40" rowspan="2">
            <div class="checkbox-inline">
                {!! Form::checkbox('select_all' , 1, false, ['class' => 'select'] ) !!}{!! Form::label('select_all', '&nbsp;', ['class' => 'marginB0']) !!}
            </div>
        </th>
        <th class="sortable text-left" rowspan="2"><a data-field="EN" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "EN") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "EN")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif EN</a></th>
        <th class="sortable text-left" rowspan="2"><a data-field="DIN_SEW" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "DIN_SEW") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "DIN_SEW")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif DIN/SEW</a></th>
        <th class="sortable text-left" rowspan="2"><a data-field="number" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "number") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "number")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Număr material') }}</a></th>


    </tr>
    </thead>
    <tbody>

    @if (count($standards) > 0)
        @foreach ($standards as $k => $standard)
            <tr>
                <td>{!! Form::checkbox('select_' . $standard->id , $standard->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $standard->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                <td><div class="user-tag-sm"><a href="{{ action('SettingsController@standards_edit', $standard->id) }}">{{ $standard->EN }}</a></div></td>
                <td><div class="user-tag-sm"><a href="{{ action('SettingsController@standards_edit', $standard->id) }}">{{ $standard->DIN_SEW }}</a></div></td>
                <td><div class="user-tag-sm"><a href="{{ action('SettingsController@standards_edit', $standard->id) }}">{{ $standard->number  }}</a></div></td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="13">{{ trans('Nu există standarde') }}</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="text-center">
    {!! $standards->render() !!}
</div>