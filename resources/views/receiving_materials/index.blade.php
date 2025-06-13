@extends('app')

@section('title') {{ trans('Recepția materialelor') }} @endsection

@section('content')
    <div class="content-fluid">
        <div class="table-responsive marginT30 list-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left" rowspan="2">{{ trans('Denumire') }}</th>
                        <th class="text-left" rowspan="2">{{ trans('Nr Comanda/Data') }}</th>
                        <th class="text-left" rowspan="2">{{ trans('Calitatea') }}</th>
                        <th class="text-left" colspan="2">{{ trans('Cantitatea') }}</th>
                        <th class="text-left" rowspan="2">{{ trans('Proiect') }}</th>
                        <th class="text-left" rowspan="2">{{ trans('Furnizor aprobat') }}</th>
                        <th class="text-left" rowspan="2">{{ trans('Data recepției') }}</th>
                        <th class="text-left" rowspan="2">{{ trans('Aviz sau Factura') }}</th>
                        <th class="text-left" colspan="2">{{ trans('Cantitatea') }}</th>
                        <th class="text-left" rowspan="2">{{ trans('Certificatul de calitate') }}</th>
                        <th class="text-left" rowspan="2">{{ trans('Calitatea certificata') }}</th>
                        <th class="text-left" rowspan="2">{{ trans('Sarja') }}</th>
                        <th class="text-left" rowspan="2">{{ trans('Nr intern al certificatului') }}</th>
                    </tr>
                    <tr>
                        <th class="text-left">{{ trans('buc') }}</th>
                        <th class="text-left">{{ trans('kg') }}</th>
                        <th class="text-left">{{ trans('m') }}</th>
                        <th class="text-left">{{ trans('kg') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($materials) > 0)
                        @foreach ($materials as $material)
                            <tr>
                                <td class="text-left">{{ $material->name }}</td>
                                <td class="text-left">{{ $material->no_order }}</td>
                                <td class="text-left">{{ $material->quality }}</td>
                                <td class="text-left">{{ $material->amount }}</td>
                                <td class="text-left">{{ $material->amount_kg }}</td>
                                <td class="text-left">{{ $material->project }}</td>
                                <td class="text-left">{{ $material->supplier }}</td>
                                <td class="text-left">{{ $material->date_of_reception }}</td>
                                <td class="text-left">{{ $material->opinion_or_invoice }}</td>
                                <td class="text-left">{{ $material->amount_2_m }}</td>
                                <td class="text-left">{{ $material->amount_2_kg }}</td>
                                <td class="text-left">{{ $material->quality_certificate }}</td>
                                <td class="text-left">{{ $material->certified_quality }}</td>
                                <td class="text-left">{{ $material->sarja }}</td>
                                <td class="text-left">{{ $material->internal_certificate_number }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="13">{{ trans('Nu există înregistrări') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
