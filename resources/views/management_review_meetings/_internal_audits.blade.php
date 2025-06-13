<table class="table marginT30">
    <thead>
        <tr>
            <th class="text-left">{{ trans('Audit nr') }}</th>
            <th class="text-left">{{ trans('Procese') }}</th>
            <th class="text-left">{{ trans('Data programată') }}</th>
            <th class="text-left">{{ trans('Data efectuată') }}</th>
            <th class="text-left">{{ trans('') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (count($internal_audits) > 0)
        @foreach ($internal_audits as $internal_audit)
        <tr class="parent first-level">
            <td class="text-left">{{ $internal_audit->audit }}</td>
            <td class="text-left">{{ $internal_audit->get_process_names() }}</td>
            <td class="text-left">{{ $internal_audit->date_scheduled }}</td>
            <td class="text-left">{{ $internal_audit->date_conducted }}</td>
        </tr>
        @foreach (App\Models\Standard::all() as $standard)
            <tr class="child">
                <td class="text-left">{{ $standard->name }}</td>
                <td class="text-left">{{ $internal_audit->get_chapters_nrs($standard->id) }}</td>
            </tr>
        @endforeach
        @endforeach
        @else
            <tr>
                <td colspan="13">{{ trans('Nu există înregistrări') }}</td>
            </tr>
        @endif
    </tbody>
</table>
