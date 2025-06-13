<table class="table marginT30">
    <thead>
    <tr>
        <th rowspan="2" class="text-left">{{ trans('ID') }}</th>
        <th rowspan="2" class="text-left">{{ trans('Descriere program / Tematica instruirii') }}</th>
        <th rowspan="2" class="text-left">{{ trans('Trainer') }}</th>
        <th rowspan="2" class="text-left">{{ trans('Participanți') }}</th>
        <th colspan="2" class="text-center">{{ trans('Planificat') }}</th>
        <th colspan="2" class="text-center">{{ trans('Realizat') }}</th>
        <th colspan="2" class="text-center">{{ trans('Confirmare') }}</th>
        <th rowspan="2" class="text-left">{{ trans('Mod Evaluare') }}</th>
    </tr>
    <tr>
        <th class="text-left">{{ trans('Data') }}</th>
        <th class="text-left">{{ trans('Durată') }}</th>
        <th class="text-left">{{ trans('Data') }}</th>
        <th class="text-left">{{ trans('Durată') }}</th>
        <th class="text-left">{{ trans('Angajat') }}</th>
        <th class="text-left">{{ trans('Trainer') }}</th>
    </tr>
    </thead>
    <tbody>
        @if (count($education) > 0)
            @foreach ($education as $k => $item)
                <tr>
                    <td>{{ $item->nr }}</td>
                    <td>@if (hasPermission('Education edit'))<div class="user-tag-sm"><a class="open-edit-modal" data-id="{{ $item->id }}">{{ $item->description }}</a></div> @else {{ $item->description }} @endif </td>
                    <td>@if (!is_null($item->role_id)){{ $item->role->name }} @else {{ $item->supplier->name }}  @endif</td>
                    <td>@if ($item->is_all_user()) {{ trans('Toți angajații') }} @else {{ $item->get_participants_name() }} @endif</td>
                    <td>{{ $item->planned_start_date . ' - ' . $item->planned_finish_date }}</td>
                    <td>@if (!is_null($item->planned_start_date) && !is_null($item->planned_finish_date)) {{ $item->get_planned_duration() }} @endif</td>
                    <td>{{ $item->accomplished_start_date . ' - ' . $item->accomplished_finish_date }}</td>
                    <td>@if (!is_null($item->accomplished_start_date) && !is_null($item->accomplished_finish_date)) {{ $item->get_accomplished_duration() }} @endif</td>
                    @php $is_user = false; @endphp
                    @foreach ($item->participant as $user)
                        @if ($user->user_id == \Auth::user()->id) @php $is_user = true; @endphp @endif
                    @endforeach
                    <td>{{ $item->get_user_confirmed_rating() }}</td>
                    <td>@if ($item->trainer_confirmed) <i class="material-icons active">&#xE86C;</i> @else <i class="material-icons disabled">&#xE15C;</i> @endif </td>
                    <td>{{ Config::get('education.rating_mode.' . $item->rating_mode) }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="13">{{ trans('Nu există înregistrări') }}</td>
            </tr>
        @endif
    </tbody>
</table>
