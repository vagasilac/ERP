<table class="table table-striped" id="ed-table">
    <thead>
    <tr>
        <th rowspan="2" class="text-left">{{ trans('ID') }}</th>
        <th rowspan="2" class="text-left">{{ trans('Descriere program / Tematica instruirii') }}</th>
        <th rowspan="2" class="text-left">{{ trans('Trainer') }}</th>
        <th colspan="2" class="text-center">{{ trans('Planificat') }}</th>
        <th colspan="2" class="text-center">{{ trans('Realizat') }}</th>
        <th colspan="2" class="text-center">{{ trans('Confirmare') }}</th>
        <th rowspan="2" class="text-left">{{ trans('Mod Evaluare') }}</th>
        <th rowspan="2" class="text-left">{{ trans('Trebuie repetata?') }}</th>
        <th colspan="2" class="text-center">{{ trans('Dovada (diploma)') }}</th>
    </tr>
    <tr>
        <th class="text-left">{{ trans('Data') }}</th>
        <th class="text-left">{{ trans('Durată') }}</th>
        <th class="text-left">{{ trans('Data') }}</th>
        <th class="text-left">{{ trans('Durată') }}</th>
        <th class="text-left">{{ trans('Angajat') }}</th>
        <th class="text-left">{{ trans('Trainer') }}</th>
        <th class="text-left">{{ trans('Diploma') }}</th>
        <th class="text-left">{{ trans('Nr Serie') }}</th>
    </tr>
    </thead>
    <tbody>
        @if (count($participant) > 0)
            @foreach ($participant as $k => $item)
                <tr>
                    <td>{{ $item->education->nr }}</td>
                    <td>@if (hasPermission('Education edit'))<div class="user-tag-sm"><a class="open-edit-modal" data-id="{{ $item->education_id }}">{{ $item->education->description }}</a></div> @else {{ $item->education->description }} @endif </td>
                    <td>@if (!is_null($item->education->role_id)){{ $item->education->role->name }} @elseif (!is_null($item->education->supplier_id)) {{ $item->education->supplier->name }} @endif</td>
                    <td>{{ $item->education->planned_start_date . ' - ' . $item->education->planned_finish_date }}</td>
                    <td>@if (!is_null($item->education->planned_start_date) && !is_null($item->education->planned_finish_date)) {{ $item->education->get_planned_duration() }} @endif</td>
                    <td>{{ $item->education->accomplished_start_date . ' - ' . $item->education->accomplished_finish_date }}</td>
                    <td>@if (!is_null($item->education->accomplished_start_date) && !is_null($item->education->accomplished_finish_date)) {{ $item->education->get_accomplished_duration() }} @endif</td>
                    <td>@if ($item->user_confirmed) <i class="material-icons active">&#xE86C;</i> @elseif ($item->user_id == \Auth::user()->id) <a class="btn btn-xs btn-success control-plan-submit" href="{{ action('UsersController@confirmed', $item->education_id) }}">{{ trans('Confirm') }}</a> @else <i class="material-icons disabled">&#xE15C;</i> @endif</td>
                    <td>@if ($item->education->trainer_confirmed) <i class="material-icons active">&#xE86C;</i> @else <i class="material-icons disabled">&#xE15C;</i> @endif </td>
                    <td>{{ Config::get('education.rating_mode.' . $item->education->rating_mode) }}</td>
                    <td>{{ Config::get('education.repeat.' . $item->education->repeat) }}</td>
                    <td>@if (!is_null($item->education->certificate_id)) <a href="{{ action('FilesController@show', ['id' => $item->education->certificate_id, 'name' => $item->education->certificate->name]) }}">{{ $item->education->certificate->name }}</a> @endif</td>
                    <td>{{ $item->education->certificate_nr }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="13">{{ trans('Nu există înregistrări') }}</td>
            </tr>
        @endif
    </tbody>
</table>
