<table class="table marginT30">
    <thead>
        <tr>
            <th class="text-left">{{ trans('Partea interesată') }}</th>
            <th class="text-left">{{ trans('Probleme de îngrijorare') }}</th>
            <th class="text-left">{{ trans('Părtinire') }}</th>
            <th class="text-left">{{ trans('Proces') }}</th>
            <th class="text-left">{{ trans('Prioritate') }}</th>
            <th class="text-left">{{ trans('Metoda de tratament') }}</th>
            <th class="text-left">{{ trans('Înregistrare de referință') }}</th>
            <th class="text-left">{{ trans('Utilizator') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (count($coto_issues) > 0)
        @foreach ($coto_issues as $coto_issue)
        <tr class="parent first-level">
            <td class="text-left">{{ $coto_issue->coto_party->interested_party }}</td>
            <td class="text-left">{{ $coto_issue->issues_concern }}</td>
            <td class="text-left">{{ Config::get('coto.issues.bias.' . $coto_issue->bias) }}</td>
            <td class="text-left">@if ($coto_issue->processes_id != null){{ $coto_issue->process->name }} @else {{ trans('Toate procesele') }} @endif</td>
            <td class="text-left">{{ Config::get('coto.issues.priority.' . $coto_issue->priority) }}</td>
            <td class="text-left">@if ($coto_issue->treatment_method != 'other'){{ Config::get('coto.issues.treatment_method.' . $coto_issue->treatment_method) }} @else {{ $coto_issue->other_treatment_method }} @endif</td>
            <td class="text-left">{{ $coto_issue->record_reference }}</td>
            <td>@if (!is_null($coto_issue->user))<div class="user-tag-sm">@if ($coto_issue->user->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $coto_issue->user->photo)) }}" alt="{{ $coto_issue->user->lastname }} {{ $coto_issue->user->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($coto_issue->user->id % count($colors)) + 1]) ? $colors[($coto_issue->user->id % count($colors)) + 1] : '' }}">{{ substr($coto_issue->user->lastname, 0, 1) }}{{ substr($coto_issue->user->firstname, 0, 1) }}</span>@endif{{ !is_null($coto_issue->user) ? $coto_issue->user->name() : ''  }}</div>@endif</td>
        </tr>
        @endforeach
        @else
            <tr>
                <td colspan="13">{{ trans('Nu există înregistrări') }}</td>
            </tr>
        @endif
    </tbody>
</table>
