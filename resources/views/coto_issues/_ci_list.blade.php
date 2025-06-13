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
        <th class="sortable text-left"><a data-field="issues_concern" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "issues_concern") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "issues_concern")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Aspectul') }}</a></th>
        <th class="sortable text-left"><a data-field="bias" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "bias") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "bias")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Tip') }}</a></th>
        <th class="sortable text-left"><a data-field="name" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Proces') }}</a></th>
        <th class="sortable text-left"><a data-field="priority" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "priority") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "priority")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Prioritate') }}</a></th>
        <th class="sortable text-left"><a data-field="treatment_method" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "treatment_method") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "treatment_method")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Metoda de tratare') }}</a></th>
        <th class="sortable text-left"><a data-field="record_reference" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "record_reference") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "record_reference")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Înregistrare / notă') }}</a></th>
        <th class="sortable text-left"><a data-field="user_id" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "user_id") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "user_id")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Utilizator') }}</a></th>
    </tr>
    </thead>
    <tbody>

    @if (count($items) > 0)
        @foreach ($items as $k => $item)
            <tr>
                <td>{!! Form::checkbox('select_' . $item->id , $item->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $item->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                <td><div class="user-tag-sm"><a href="{{ action('CotoIssuesController@edit', $item->id) }}">{{ $item->interested_party }}</a></div></td>
                <td>{{ $item->issues_concern  }}</td>
                <td>{{ trans((string)Config::get('coto.issues.bias.' . $item->bias)) }}</td>
                <td>@if ($item->name != ''){{ $item->name }}@else{{ trans('Toate procesele') }}@endif</td>
                <td>{{ trans((string)Config::get('coto.issues.priority.' . $item->priority)) }}</td>
                <td>{{ $item->treatment_method }}</td>
                <td>{{ $item->record_reference }}</td>
                <td>@if (!is_null($item->user))<div class="user-tag-sm"><a href="{{ action('CotoIssuesController@edit', $item->id) }}">@if ($item->user->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $item->user->photo)) }}" alt="{{ $item->user->lastname }} {{ $item->user->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($item->user->id % count($colors)) + 1]) ? $colors[($item->user->id % count($colors)) + 1] : '' }}">{{ substr($item->user->lastname, 0, 1) }}{{ substr($item->user->firstname, 0, 1) }}</span>@endif{{ !is_null($item->user) ? $item->user->name() : ''  }}</a></div>@endif</td>
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
