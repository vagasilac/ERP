<table class="table table-striped" id="ed-table">
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
        @if (count($trainer) > 0)
            @foreach ($trainer as $k => $item)
                <tr>
                    <td>{{ $item->nr }}</td>
                    <td><div class="user-tag-sm">{{ $item->description }}</div></td>
                    <td>@if (!is_null($item->role_id)){{ $item->role->name }} @elseif (!is_null($item->supplier_id)) {{ $item->supplier->name }} @else {{ $item->other_trainer }} @endif</td>
                    <td>@if ($item->is_all_user()) {{ trans('Toți angajații') }} @else {{ $item->get_participants_name() }} @endif</td>
                    <td>{{ $item->planned_start_date . ' - ' . $item->planned_finish_date }}</td>
                    <td>@if (!is_null($item->planned_start_date) && !is_null($item->planned_finish_date)) {{ $item->get_planned_duration() }} @endif</td>
                    <td>{{ $item->accomplished_start_date . ' - ' . $item->accomplished_finish_date }}</td>
                    <td>@if (!is_null($item->accomplished_start_date) && !is_null($item->accomplished_finish_date)) {{ $item->get_accomplished_duration() }} @endif</td>
                    <td>{{ $item->get_user_confirmed_rating() }}</td>
                    <td>@if ($item->trainer_confirmed) <i class="material-icons active">&#xE86C;</i> @elseif (\Auth::user()->id == $user->id) <a class="btn btn-xs btn-success control-plan-submit" href="{{ action('EducationController@trainer_confirm', $item->id) }}">{{ trans('Confirm') }}</a> @else <i class="material-icons disabled">&#xE15C;</i> @endif </td>
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
