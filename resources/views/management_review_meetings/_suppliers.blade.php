<table class="table marginT30">
    <thead>
        <th class="text-left">{{ trans('Denumire') }}</th>
        <th class="text-left">{{ trans('Denumire scurtă') }}</th>
        <th class="text-left">{{ trans('CUI') }}</th>
        <th class="text-left">{{ trans('Nr. registrul comerțului') }}</th>
        <th class="text-left">{{ trans('E-mail') }}</th>
        <th class="text-left">{{ trans('Telefon') }}</th>
        <th class="text-left">{{ trans('Evaluare') }}</th>
    </thead>
    <tbody>
        @if (count($suppliers) > 0)
        @foreach ($suppliers as $supplier)
            <tr>
                <td class="text-left"><div class="user-tag-sm">@if ($supplier->logo != '')<img src="{{ action('FilesController@image', base64_encode('suppliers/thumbs/' . $supplier->logo)) }}" alt="{{ $supplier->name }}" />@else <img src="{{ asset('img/placeholder-company-profile.png') }}" alt="{{ $supplier->name }}" /> @endif {{ $supplier->name }}</div></td>
                <td class="text-left">{{ $supplier->short_name }}</td>
                <td class="text-left">{{ $supplier->vat_number }}</td>
                <td class="text-left">{{ $supplier->company_number }}</td>
                <td class="text-left">{{ $supplier->office_email }}</td>
                <td class="text-left">{{ $supplier->office_phone }}</td>
                <td class="text-left">@if (!is_null($supplier->average_rating) && $supplier->average_rating != '') <span class="label @if ($supplier->average_rating < 2) label-danger @elseif ($supplier->average_rating < 4) label-warning @else label-success @endif"><i class="material-icons">&#xE838;</i> {{ $supplier->average_rating }}</span>@endif</td>
            </tr>
        @endforeach
        @else
            <tr>
                <td colspan="13">{{ trans('Nu există înregistrări') }}</td>
            </tr>
        @endif
    </tbody>
</table>
