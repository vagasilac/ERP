<table class="table marginT30">
    <thead>
        <tr>
            <th class="text-left">{{ trans('ID') }}</th>
            <th class="text-left">{{ trans('Data prezentată') }}</th>
            <th class="text-left">{{ trans('Tip') }}</th>
            <th class="text-left">{{ trans('Sursă') }}</th>
            <th class="text-left">{{ trans('Proces') }}</th>
            <th class="text-left">{{ trans('Numele persoanei care trimite') }}</th>
            <th class="text-left">{{ trans('Descriere scurta') }}</th>
            <th class="text-left">{{ trans('Atribuit') }}</th>
            <th class="text-left">{{ trans('Data atribuită') }}</th>
            <th class="text-left">{{ trans('Data solicitată a acțiunii solicitate') }}</th>
            <th class="text-left">{{ trans('Restante?') }}</th>
            <th class="text-left">{{ trans('Data completă a acțiunii') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (count($capas) > 0)
        @foreach ($capas as $capa)
            <tr>
                <td class="text-left">{{ $capa->id }}</td>
                <td class="text-left">{{ Carbon\Carbon::parse($capa->created_at)->format('d-m-Y') }}</td>
                <td class="text-left">{{ Config::get('capa.capa_form.capa_create.type.' . $capa->type) }}</td>
                <td class="text-left">@if ($capa->other_source != ''){{ $capa->other_source }}@else{{ trans((string)Config::get('capa.capa_form.capa_create.source.' . $capa->source)) }}@endif</td>
                <td class="text-left">@if ($capa->other_process !=''){{ $capa->other_process }}@else{{ $capa->process->name }}@endif</td>
                <td class="text-left">@if (!is_null($capa->user))<div class="user-tag-sm">@if ($capa->user->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $capa->user->photo)) }}" alt="{{ $capa->user->lastname }} {{ $capa->user->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($capa->user->id % count($colors)) + 1]) ? $colors[($capa->user->id % count($colors)) + 1] : '' }}">{{ substr($capa->user->lastname, 0, 1) }}{{ substr($capa->user->firstname, 0, 1) }}</span>@endif{{ !is_null($capa->user) ? $capa->user->name() : ''  }}</div>@endif</td>
                <td class="text-left">{{ $capa->description }}</td>
                <td class="text-left">@if (!is_null($capa->assignment))<div class="user-tag-sm">@if ($capa->assignment->user->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $capa->assignment->user->photo)) }}" alt="{{ $capa->assignment->user->lastname }} {{ $capa->assignment->user->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($capa->assignment->user->id % count($colors)) + 1]) ? $colors[($capa->assignment->user->id % count($colors)) + 1] : '' }}">{{ substr($capa->assignment->user->lastname, 0, 1) }}{{ substr($capa->assignment->user->firstname, 0, 1) }}</span>@endif{{ !is_null($capa->assignment->user) ? $capa->assignment->user->name() : ''  }}</div>@endif</td>
                <td class="text-left">@if (!is_null($capa->assignment)){{ Carbon\Carbon::parse($capa->assignment->created_at)->format('d-m-Y') }}@endif</td>
                <td class="text-left">@if (!is_null($capa->assignment)){{ Carbon\Carbon::parse($capa->assignment->respond)->format('d-m-Y') }}@endif</td>
                <td class="text-left">@if (!is_null($capa->assignment)) @if ($capa->assignment->respond <= Carbon\Carbon::now() && is_null($capa->result->action_complete_date)) {{ trans('Da') }} @else @if ($capa->assignment->respond < $capa->result->action_complete_date) {{ trans('târziu') }} @else {{ trans('nu') }} @endif @endif @endif</td>
                <td class="text-left">@if (!is_null($capa->result)){{ Carbon\Carbon::parse($capa->result->created_at)->format('d-m-Y') }}@endif</td>
            </tr>
        @endforeach
        @else
            <tr>
                <td colspan="13">{{ trans('Nu există înregistrări') }}</td>
            </tr>
        @endif
    </tbody>
</table>
