@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table" id="projects-table">
    <thead>
    <tr>
        <th width="60" class="paddingR0">
            <div class="checkbox-inline">
                {!! Form::checkbox('select_all' , 1, false, ['class' => 'select'] ) !!}{!! Form::label('select_all', '&nbsp;', ['class' => 'marginB0']) !!}
            </div>
        </th>
        <th width="25"class="padding0"></th>
        <th class="sortable"><a data-field="code" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "code") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "code")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Cod') }}</a></th>
        <th class="sortable"><a data-field="name" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Denumire') }}</a></th>
        <th class="sortable"><a data-field="type" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "type") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "type")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Tip') }}</a></th>
        <th class="sortable"><a data-field="customer" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "customer") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "customer")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Client') }}</a></th>
        <th class="sortable"><a data-field="responsible" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "responsible") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "responsible")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Responsabil') }}</a></th>
        <th class="sortable"><a data-field="deadline" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "deadline") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "deadline")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Termen') }}</a></th>
        <th class="sortable"><a data-field="created_at" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "created_at") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "created_at")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Data creării') }}</a></th>
        <th class="sortable"><a data-field="updated_at" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "updated_at") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "updated_at")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Ultima modificare') }}</a></th>
        <th>{{ trans('Status') }}</th>
    </tr>
    </thead>
    <tbody>

    @php
    @endphp
    @if (count($projects_with_children) > 0)
        @set ('i', 0)
        @foreach ($projects_with_children as $k => $project)
            @if (is_null($project->parent_id))
                @set ($i, $i+1)
            @endif
            <tr class="strip-{{ ($i - 1)%2 + 1 }} @if (!is_null($project->parent_id)) child child-{{ $project->parent_id }} collapse @endif">
                <td class="paddingR0">{!! Form::checkbox('select_' . $project->id , $project->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $project->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                <td class="padding0">@if (count($project->children) >0)<div data-toggle="tooltip" title="{{ trans('Arată/ascunde subproiectele') }}"><a href=".child-{{$project->id}}" data-toggle="collapse" class="show-details collapsed"><i class="material-icons show-icon">&#xE313;</i><i class="material-icons hide-icon">&#xE316;</i></a></div>@endif</td>
                <td>{{ $project->production_name() }}</td>
                <td><div class="user-tag-sm"><a href="{{ action('ProjectsController@general_info', $project->id) }}">{{ $project->customer->short_name }} {{ $project->name }}</a> @if ($project->has_rejected_folder()) <i class="material-icons alert-icon cursor-default" data-toggle="tooltip" data-placement="top" title="{{ trans('Acest proiect are cel puțin o secțiune respinsă')  }}">&#xE002;</i> @endif</div></td>
                <td><span class="inline-block cursor-default" data-toggle="tooltip" data-placement="top" title="{{ trans($primary_codes[$project->primary_code]) . '<br>' . trans($secondary_codes[$project->secondary_code]) }}">{{ sprintf("%02d", $project->primary_code) }}.{{ sprintf("%02d", $project->secondary_code) }}</span></td>
                <td><div class="user-tag-sm"><a href="{{ action('CustomersController@edit', $project->customer->id) }}">@if ($project->customer->logo != '')<img src="{{ action('FilesController@image', base64_encode('customers/thumbs/' . $project->customer->logo)) }}" alt="{{ $project->customer->name }}" />@else <img src="{{ asset('img/placeholder-company-profile.png') }}" alt="{{ $project->customer->name }}" /> @endif {{ $project->customer->name }}</a></div></td>
                <td><div class="user-tag-sm" data-toggle="tooltip" title="{{ $project->primary_responsible_user->lastname }} {{ $project->primary_responsible_user->firstname }}"><a href="{{ action('UsersController@edit', $project->primary_responsible_user->id) }}">@if ($project->primary_responsible_user->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $project->primary_responsible_user->photo)) }}" alt="{{ $project->primary_responsible_user->lastname }} {{ $project->primary_responsible_user->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($project->primary_responsible_user->id % count($colors)) + 1]) ? $colors[($project->primary_responsible_user->id % count($colors)) + 1] : '' }}">{{ substr($project->primary_responsible_user->lastname, 0, 1) }}{{ substr($project->primary_responsible_user->firstname, 0, 1) }}</span>@endif {{ substr($project->primary_responsible_user->firstname, 0, 1) }}</a></div></td>
                <td>
                    @if (count($project->deadlines) > 0)
                        @foreach ($project->deadlines as $deadline)
                            @if (strtotime($deadline) > time())
                                {{ $deadline }}
                                @php break @endphp
                            @endif
                        @endforeach
                    @endif
                </td>
                <td>{{ $project->created_at }}</td>
                <td>{{ $project->updated_at }}</td>
                <td class="valign-middle">
                    @if ($project->type == 'offer')
                        <div class="progress orange">
                            <span>{{ $project->get_offer_progress() . ' / 7' }}</span>
                            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $project->get_offer_progress() }}" aria-valuemin="0" aria-valuemax="7" style="width: {{ $project->get_offer_progress() * 100 / 7 }}%;"></div>

                        </div>
                    @elseif ($project->type == 'work')
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="{{ $project->progress_percentage() }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $project->progress_percentage() }}%;">
                            <span>{{ $project->progress_percentage() }}%</span>
                        </div>
                    </div>
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="11">{{ trans('Nu există proiecte') }}</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="text-center">
    {!! $projects->render() !!}
</div>