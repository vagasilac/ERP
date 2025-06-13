<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">{{ $materials_in_stock[0]->material_info->name }}</h4>
</div>
<div class="modal-body">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th class="text-center" colspan="2">{{ trans('Mărime') }}</th>
            <th class="text-center" rowspan="2">{{ trans('Bucăți') }}</th>
            <th class="text-center" rowspan="2">{{ trans('Locație') }}</th>
            <th class="text-center" rowspan="2">{{ trans('Număr intern al certificatului') }}</th>
            <th rowspan="2"></th>
        </tr>
        <tr>
            <th class="text-center">{{ trans('Valoare') }}</th>
            <th class="text-center">{{ trans('UM') }}</th>

        </tr>
        </thead>
        <tbody>
        @foreach($materials_in_stock as $m)
            <tr>
                <td class="text-center">{{ $m->quantity }}</td>
                <td class="text-center">{{ $m->material_info->unit }}</td>
                <td class="text-center">{{ $m->pieces }}</td>
                <td class="text-center">{{ $m->location }}</td>
                <td class="text-center">
                    @if($m->certificate)
                        @if($m->certificate->EN){{ $m->certificate->EN }}@else {{ $m->certificate->DIN_SEW }}@endif
                    @endif
                </td>
                <td><a class="btn btn-primary btn-sm reserve-stock" data-dismiss="modal" data-id="{{ $m->id }}" data-project-id="{{ $project_id }}">{{ trans('Rezervare') }}</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>