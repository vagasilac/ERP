@if(isset($material))
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ $material->material_info->name }}</h4>
    </div>
    <div class="modal-body">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th rowspan="2">{{ trans('Proiect') }}</th>
                <th rowspan="2">{{ trans('Tehnolog') }}</th>
                <th rowspan="2">{{ trans('Data scadentă') }}</th>
                <th class="text-center" colspan="2">{{ trans('Cantitate') }}</th>
            </tr>
            <tr>
                <th class="text-center">{{ trans('NET') }}</th>
                <th class="text-center">{{ trans('BRUT') }}</th>
            </tr>
            </thead>
            <tbody>
                @if(isset($dmaterials))
                    @if($dmaterials->count() > 0)
                        @foreach($dmaterials as $dmaterial)
                        <tr>
                            <td>{{ $dmaterial->project->name }}</td>
                            <td>@if (!is_null($dmaterial->project->primary_responsible_user)) {{ $dmaterial->project->primary_responsible_user->firstname }} {{ $dmaterial->project->primary_responsible_user->lastname }} @endif</td>
                            <td>{{ $dmaterial->project->deadline }}</td>
                            <td class="text-center">
                                @set('material_name_with_standard', str_replace(' ', '-', $dmaterial->material_info->name) . '-' . str_replace(' ', '-', $dmaterial->standard->name()))
                                @if (!is_null($dmaterial->project->calculation->data->materials) && !is_null($dmaterial->project->calculation->data->materials->{$dmaterial->material_info->material_type()}->{$material_name_with_standard}))
                                    @if ($dmaterial->material_info->material_type() == 'profile')
                                        {{ $dmaterial->project->calculation->data->materials->{$dmaterial->material_info->material_type()}->{$material_name_with_standard}->length_net }}
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">{{ $dmaterial->quantity }} {{ $dmaterial->material_info->unit }}</td>
                        </tr>
                        @endforeach
                    @endif
                @endif
            </tbody>
        </table>
    </div>

@endif
