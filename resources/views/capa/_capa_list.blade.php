@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-striped" id="capa-table">
    <thead>
    <tr>
        <th width="40" rowspan="2">
            <div class="checkbox-inline">
                {!! Form::checkbox('select_all' , 1, false, ['class' => 'select'] ) !!}{!! Form::label('select_all', '&nbsp;', ['class' => 'marginB0']) !!}
            </div>
        </th>

        <th class="sortable text-left"><a data-field="id" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "id") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "id")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('ID') }}</a></th>
        <th class="sortable text-left"><a data-field="date_submitted" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "date_submitted") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "date_submitted")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Data prezentată') }}</a></th>
        <th class="sortable text-left"><a data-field="type" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "type") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "type")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Tip') }}</a></th>
        <th class="sortable text-left"><a data-field="source" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "source") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "source")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Sursă') }}</a></th>
        <th class="sortable text-left"><a data-field="process" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "process") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "process")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Proces') }}</a></th>
        <th class="sortable text-left"><a data-field="name_of_person_submitting" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name_of_person_submitting") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name_of_person_submitting")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Numele persoanei care trimite') }}</a></th>
        <th class="sortable text-left"><a data-field="description" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "description") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "description")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Descriere scurta') }}</a></th>
        <th class="sortable text-left"><a data-field="assigned_to" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "assigned_to") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "assigned_to")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Atribuit') }}</a></th>
        <th class="sortable text-left"><a data-field="date_assigned" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "date_assigned") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "date_assigned")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Data atribuită') }}</a></th>
        <th class="sortable text-left"><a data-field="respond" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "respond") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "respond")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Data solicitată a acțiunii solicitate') }}</a></th>
        <th class="sortable text-left"><a data-field="overdue" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "overdue") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "overdue")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Restante?') }}</a></th>
        <th class="sortable text-left"><a data-field="action_complete_date" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "action_complete_date") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "action_complete_date")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Data completă a acțiunii') }}</a></th>

    </tr>
    </thead>
    <tbody>

    @if (count($items) > 0)
        @foreach ($items as $k => $item)
            <tr>
                <td>{!! Form::checkbox('select_' . $item->id , $item->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $item->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                <td><div class="user-tag-sm"><a href="{{ action('CapasController@edit', $item->id) }}">{{ $item->id }}</a>@if (!is_null($item->respond)) @if ($item->respond <= Carbon\Carbon::now() && is_null($item->action_complete_date)) <i class="material-icons alert-icon cursor-default" data-toggle="tooltip" data-placement="top" title="{{ trans('Termen limită depășit')  }}">&#xE002;</i> @endif @endif</div></td>
                <td>{{ Carbon\Carbon::parse($item->date_submitted)->format('d-m-Y') }}</td>
                <td>{{ trans((string)Config::get('capa.capa_form.capa_create.type.' . $item->type)) }}</td>
                <td>@if ($item->other_source != ''){{ $item->other_source }}@else{{ trans((string)Config::get('capa.capa_form.capa_create.source.' . $item->source)) }}@endif</td>
                <td>@if ($item->other_process !=''){{ $item->other_process }}@else{{ $item->process->name }}@endif</td>
                <td>@if (!is_null($item->user))<div class="user-tag-sm">@if ($item->user->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $item->user->photo)) }}" alt="{{ $item->user->lastname }} {{ $item->user->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($item->user->id % count($colors)) + 1]) ? $colors[($item->user->id % count($colors)) + 1] : '' }}">{{ substr($item->user->lastname, 0, 1) }}{{ substr($item->user->firstname, 0, 1) }}</span>@endif{{ !is_null($item->user) ? $item->user->name() : ''  }}</div>@endif</td>
                <td>{{ $item->description }}</td>
                <td>@if (!is_null($item->assignment))<div class="user-tag-sm">@if ($item->assignment->user->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $item->assignment->user->photo)) }}" alt="{{ $item->assignment->user->lastname }} {{ $item->assignment->user->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($item->assignment->user->id % count($colors)) + 1]) ? $colors[($item->assignment->user->id % count($colors)) + 1] : '' }}">{{ substr($item->assignment->user->lastname, 0, 1) }}{{ substr($item->assignment->user->firstname, 0, 1) }}</span>@endif{{ !is_null($item->assignment->user) ? $item->assignment->user->name() : ''  }}</div>@endif</td>
                <td>@if (!is_null($item->date_assigned)){{ Carbon\Carbon::parse($item->date_assigned)->format('d-m-Y') }}@endif</td>
                <td>@if (!is_null($item->respond)){{ Carbon\Carbon::parse($item->respond)->format('d-m-Y') }}@endif</td>
                <td>@if (!is_null($item->respond)) @if ($item->respond <= Carbon\Carbon::now() && is_null($item->action_complete_date)) {{ trans('Da') }} @else @if ($item->respond < $item->action_complete_date) {{ trans('târziu') }} @else {{ trans('nu') }} @endif @endif @endif</td>
                <td>@if (!is_null($item->action_complete_date)){{ Carbon\Carbon::parse($item->action_complete_date)->format('d-m-Y') }}@endif</td>
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
