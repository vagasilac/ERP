@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

@set ('total_net_weight', 0)
<table class="table table-bordered table-condensed table-calculation" id="subassemblies-table">
    <thead>
    <tr>
        <th width="40"></th>
        <th>{{ trans('Nume A') }}</th>
        <th>{{ trans('Grupa') }}</th>
        <th>{{ trans('Q A') }} ({{ trans('buc') }})</th>
        <th>{{ trans('Nume SA') }}</th>
        <th>{{ trans('Q SA') }} ({{ trans('buc') }})</th>
        <th>{{ trans('Reper') }}</th>
        <th><span class="nowrap">{{ trans('Q reper/SA') }}</span> ({{ trans('buc') }})</th>
        <th>{{ trans('Calitate') }}</th>
        <th>{{  trans('Profil') }}</th>
        <th>{{ trans('G') }} <span class="nowrap">(kg.m<sup>-1</sup>)</span></th>
        <th><span class="nowrap">{!! trans('A<sub>L</sub>') !!}</span> <span class="nowrap">(m<sup>2</sup>.m<sup>-1</sup>)</span></th>
        <th>{{ trans('L') }} (mm)</th>
        <th>{{ trans('l') }} (mm)</th>
        <th>{{ trans('Q total') }} ({{ trans('buc') }})</th>
        <th>{{ trans('S') }} (m<sup>2</sup>)</th>
        <th>{{ trans('L total') }} (ml)</th>
        <th>{{ trans('M total') }} (kg)</th>
    </tr>
    </thead>
    <tbody>
    @if (count($project->subassemblies) > 0)
        @foreach ($assemblies as $assembly)
                <tr class="assemblies-row" data-id="{{ $assembly->id }}">
                    <td class="valign-middle"><a data-toggle="modal" data-target="#subassembly-delete-modal-{{ $assembly->id }}" id="subassembly-remove-icon-{{ $assembly->id }}" class="remove-icon"><span class="fa fa-trash-o"></span></a></td>
                    <td>{!! Form::text('subassemblies[' . $assembly->id . '][name]', $assembly->name, ['class' => 'form-control without-label']) !!}</td>
                    <td>{!! Form::select('subassemblies[' . $assembly->id . '][group_id]', $groups, $assembly->group_id, ['class' => 'form-control without-label', 'data-id' => $assembly->id]) !!}</td>
                    <td>
                        <div class="form-group">
                            {!! Form::text('subassemblies[' . $assembly->id . '][subassembly_quantity]', $assembly->quantity, ['class' => 'form-control without-label', 'data-id' => $assembly->id]) !!}
                        </div>
                    </td>
                    <td colspan="14" class="valign-middle">
                        <a class="subassemblies-clone" data-target=".subassemblies-row" data-parent-id="{{ $assembly->id }}">+ {{ trans('Adaugă subansamblu') }}</a>
                    </td>
                </tr>
            @if (count($assembly->children) > 0)
                @foreach ($assembly->children as $subassembly)
                    <tr class="subassemblies-row child" data-id="{{ $subassembly->id }}" data-parent-id="{{ $subassembly->parent->id }}">
                        <td class="valign-middle"><a data-toggle="modal" data-target="#subassembly-delete-modal-{{ $subassembly->id }}" id="subassembly-remove-icon-{{ $subassembly->id }}" class="remove-icon"><span class="fa fa-trash-o"></span></a></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            {!! Form::text('subassemblies[' . $subassembly->id . '][name]', $subassembly->name, ['class' => 'form-control without-label']) !!}
                            {!! Form::hidden('subassemblies[' . $subassembly->id . '][parent]', $subassembly->parent->id) !!}
                        </td>
                        <td>
                            <div class="form-group">
                                {!! Form::text('subassemblies[' . $subassembly->id . '][subassembly_quantity]', $subassembly->quantity, ['class' => 'form-control without-label', 'data-id' => $subassembly->id]) !!}
                            </div>
                        </td>
                        <td colspan="12" class="valign-middle">
                            <a class="parts-clone" data-target=".parts-row" data-parent-id="{{ $subassembly->parent->id }}" data-subassembly-id="{{ $subassembly->id }}">+ {{ trans('Adaugă reper') }}</a>
                        </td>
                    </tr>

                    @if (count($subassembly->parts) > 0)
                        @foreach ($subassembly->parts as $k => $item)
                            <tr class="parts-row child" data-subassembly-id="{{ $subassembly->id }}" data-parent-id="{{ $subassembly->parent->id }}">
                                <td class="valign-middle"><a data-id="{{ $item->id }}" data-toggle="modal" data-target="#part-delete-modal-{{ $item->id }}" id="part-remove-icon-{{ $item->id }}" class="remove-icon"><span class="fa fa-trash-o"></span></a></td>
                                <td></td>
                                <td></td>
                                <td>{!! Form::hidden('subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][subassembly_quantity]', $subassembly->quantity, ['class' => 'form-control without-label', 'data-id' => $subassembly->id]) !!}</td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        {!! Form::text('subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][part]', $item->name, ['class' => 'form-control without-label']) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        {!! Form::text('subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][part_quantity]', $item->quantity, ['class' => 'form-control without-label']) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group @if (is_null($item->standard)) has-error @endif">
                                        {!! Form::text('subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][standard_name]', !is_null($item->standard) ? $item->standard->name() : $item->standard_name, ['class' => 'form-control without-label load-combobox', 'data-autocomplete-src' => action('SettingsController@get_standards'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => "id", 'data-autocomplete-value' => "name", 'data-input-name' => 'subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][standard_id]']) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group @if (is_null($item->material)) has-error @endif">
                                        {!! Form::text('subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][material_name]', !is_null($item->material) ? $item->material->name : $item->material_name, ['class' => 'form-control without-label load-combobox', 'data-autocomplete-src' => action('SettingsController@get_materials'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => "id", 'data-autocomplete-value' => "name", 'data-input-name' => 'subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][material_id]' ]) !!}
                                        {!! Form::hidden('subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][thickness]', !is_null($item->material) ? $item->material->thickness : 0, ['class' => 'form-control']) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <span class="input" data-target="subassemblies[{{ $subassembly->id }}][parts][{{ $item->id }}][G]">{{ (isset($item->G) ? $item->G : (isset($item->material) ? $item->material->G : '')) }}</span>
                                        {!! Form::hidden('subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][G]', (isset($item->G) ? $item->G : (isset($item->material) ? $item->material->G : ''))) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <span class="input" data-target="subassemblies[{{ $subassembly->id }}][parts][{{ $item->id }}][AL]">{{ (isset($item->AL) ? $item->AL : (isset($item->material) ? $item->material->AL : ''))  }}</span>
                                        {!! Form::hidden('subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][AL]', (isset($item->AL) ? $item->AL : (isset($item->material) ? $item->material->AL : ''))) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        {!! Form::text('subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][length]', $item->length, ['class' => 'form-control without-label']) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        {!! Form::text('subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][width]', $item->width, ['class' => 'form-control without-label']) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <span class="input" data-target="subassemblies[{{ $subassembly->id }}][parts][{{ $item->id }}][total_quantity]">{{ $item->quantity * $subassembly->quantity * $assembly->quantity }}</span>
                                        {!! Form::hidden('subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][total_quantity]', $item->quantity * $subassembly->quantity * $assembly->quantity) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <span class="input" data-target="subassemblies[{{ $subassembly->id }}][parts]{{ $item->id }}][surface]">{{ number_format((float) ($item->quantity * $subassembly->quantity * $assembly->quantity * $item->width * $item->length / 1000000), 2, '.', '') }}</span>
                                        {!! Form::hidden('subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][surface]', number_format((float) ($item->quantity * $subassembly->quantity * $assembly->quantity * $item->width * $item->length / 1000000), 2, '.', ''), ['class' => 'form-control']) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <span class="input" data-target="subassemblies[{{ $subassembly->id }}][parts]{{ $item->id }}][total_length]">{{ number_format((float) ($item->quantity * $subassembly->quantity * $assembly->quantity * $item->length / 1000), 2, '.', '') }}</span>
                                        {!! Form::hidden('subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][total_length]', number_format((float) ($item->quantity * $subassembly->quantity * $assembly->quantity * $item->length / 1000), 2, '.', '')) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        @set ('net_weight', number_format((float) (($item->width == 0 || $item == '') ? ($item->quantity * $subassembly->quantity * $assembly->quantity * $item->length * (isset($item->G) ? $item->G : (isset($item->material) ? $item->material->G : 0)) / 1000) : ($item->quantity * $subassembly->quantity * $assembly->quantity * $item->width * $item->length * (!is_null($item->material) ? $item->material->thickness : 0) * 8 / 1000000)), 2, '.', ''))
                                        <span class="input" data-target="subassemblies[{{ $subassembly->id }}][parts]{{ $item->id }}][total_weight]">{{ $net_weight }}</span>
                                        {!! Form::hidden('subassemblies[' . $subassembly->id . '][parts][' . $item->id . '][total_weight]', $net_weight) !!}
                                        @php $total_net_weight = $total_net_weight + $net_weight @endphp
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            @endif
        @endforeach
    @else
        <tr class="assemblies-row" data-id="0">
            <td class="valign-middle"><a data-toggle="modal" data-target="#subassembly-delete-modal-0" id="subassembly-remove-icon-0" class="remove-icon"><span class="fa fa-trash-o"></span></a></td>
            <td>{!! Form::text('new_subassemblies[0][name]', null, ['class' => 'form-control without-label']) !!}</td>
            <td>{!! Form::select('new_subassemblies[0][group_id]', $groups, null, ['class' => 'form-control without-label']) !!}</td>
            <td>
                <div class="form-group">
                    {!! Form::text('new_subassemblies[0][subassembly_quantity]', null, ['class' => 'form-control without-label']) !!}
                </div>
            </td>
            <td colspan="14" class="valign-middle">
                <a class="subassemblies-clone" data-target=".subassemblies-row" data-parent-id="new-0">+ {{ trans('Adaugă subansamblu') }}</a>
            </td>
        </tr>
    @endif
    <tr class="subassemblies-row child hide" data-id="0" data-parent-id="new-0">
        <td class="valign-middle"><a data-toggle="modal" data-target="#subassembly-delete-modal-0" id="subassembly-remove-icon-0" class="remove-icon"><span class="fa fa-trash-o"></span></a></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            {!! Form::text('new_subassemblies[temp][name]', null, ['class' => 'form-control without-label']) !!}
            {!! Form::hidden('new_subassemblies[temp][parent]', 0) !!}
        </td>
        <td>
            <div class="form-group">
                {!! Form::text('new_subassemblies[temp][subassembly_quantity]', null, ['class' => 'form-control without-label']) !!}
            </div>
        </td>
        <td colspan="12" class="valign-middle">
            <a class="parts-clone" data-target=".parts-row" data-parent-id="" data-subassembly-id="">+ {{ trans('Adaugă reper') }}</a>
        </td>
    </tr>
    <tr class="parts-row child hide" data-subassembly-id="0" data-parent-id="0">
        <td class="valign-middle"><a data-id="0" data-toggle="modal" data-target="#part-delete-modal-0" id="part-remove-icon-0" class="remove-icon"><span class="fa fa-trash-o"></span></a></td>
        <td></td>
        <td></td>
        <td>
            <div class="form-group">
                {!! Form::hidden('new_subassemblies[temp][new_parts][0][subassembly_quantity]', null, ['class' => 'form-control without-label', 'data-id' => 0]) !!}
            </div>
        </td>
        <td></td>
        <td></td>
        <td>
            <div class="form-group">
                {!! Form::text('new_subassemblies[temp][new_parts][0][part]', null, ['class' => 'form-control without-label']) !!}
            </div>
        </td>
        <td>
            <div class="form-group">
                {!! Form::text('new_subassemblies[temp][new_parts][0][part_quantity]', null, ['class' => 'form-control without-label']) !!}
            </div>
        </td>
        <td>
            <div class="form-group">
                {!! Form::text('new_subassemblies[temp][new_parts][0][standard_name]', null, ['class' => 'form-control without-label load-combobox', 'data-autocomplete-src' => action('SettingsController@get_standards'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => "id", 'data-autocomplete-value' => "name", 'data-input-name' => 'new_subassemblies[temp][new_parts][0][standard_id]']) !!}
            </div>
        </td>
        <td>
            <div class="form-group">
                {!! Form::text('new_subassemblies[temp][new_parts][0][material_name]', null, ['class' => 'form-control without-label load-combobox', 'data-autocomplete-src' => action('SettingsController@get_materials'), 'data-autocomplete-data' => "data", 'data-autocomplete-id' => "id", 'data-autocomplete-value' => "name", 'data-input-name' => 'new_subassemblies[temp][new_parts][0][material_id]']) !!}
                {!! Form::hidden('new_subassemblies[temp][new_parts][0][thickness]', 0, ['class' => 'form-control']) !!}
            </div>
        </td>
        <td>
            <div class="form-group">
                <span class="input" data-target="new_subassemblies[temp][new_parts][0][G]"></span>
                {!! Form::hidden('new_subassemblies[temp][new_parts][0][G]', null) !!}
            </div>
        </td>
        <td>
            <div class="form-group">
                <span class="input" data-target="new_subassemblies[temp][new_parts][0][AL]"></span>
                {!! Form::hidden('new_subassemblies[temp][new_parts][0][AL]', null) !!}
            </div>
        </td>
        <td>
            <div class="form-group">
                {!! Form::text('new_subassemblies[temp][new_parts][0][length]', null, ['class' => 'form-control without-label']) !!}
            </div>
        </td>
        <td>
            <div class="form-group">
                {!! Form::text('new_subassemblies[temp][new_parts][0][width]', null, ['class' => 'form-control without-label']) !!}
            </div>
        </td>
        <td>
            <div class="form-group">
                <span class="input" data-target="new_subassemblies[temp][new_parts][0][total_quantity]"></span>
                {!! Form::hidden('new_subassemblies[temp][new_parts][0][total_quantity]', null) !!}
            </div>
        </td>
        <td>
            <div class="form-group">
                <span class="input" data-target="new_subassemblies[temp][new_parts][0][surface]"></span>
                {!! Form::hidden('new_subassemblies[temp][new_parts][0][surface]', null) !!}
            </div>
        </td>
        <td>
            <div class="form-group">
                <span class="input" data-target="new_subassemblies[temp][new_parts][0][total_length]"></span>
                {!! Form::hidden('new_subassemblies[temp][new_parts][0][total_length]', null) !!}
            </div>
        </td>
        <td>
            <div class="form-group">
                <span class="input" data-target="new_subassemblies[temp][new_parts][0][total_weight]"></span>
                {!! Form::hidden('new_subassemblies[temp][new_parts][0][total_weight]', null) !!}
            </div>
        </td>
    </tr>

    </tbody>
</table>
{!! Form::hidden('net_weight', $total_net_weight, ['id' => 'net_weight']) !!}

@section('content-modals')
    @parent

    @if (count($project->subassemblies) > 0)
        @foreach ($project->subassemblies as $subassembly)
            <div class="modal fade subassembly-delete-modal" id="subassembly-delete-modal-{{ $subassembly->id }}">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" >{{ trans('Ștergere (sub)ansamblu') }}</h4>
                        </div>
                        <div class="modal-body">
                            {{ trans('Doriți să ștergeți acest (sub)ansamblu?') }}
                            <div class="inputs-container"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                            <a class="remove-table-row btn btn-danger" data-id="{{ $subassembly->id }}" data-remove-icon="#subassembly-remove-icon-{{ $subassembly->id }}">{{ trans('Șterge') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            @if (count($subassembly->parts) > 0)
                @foreach ($subassembly->parts as $k => $item)
                    <div class="modal fade part-delete-modal" id="part-delete-modal-{{ $item->id }}">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" >{{ trans('Ștergere reper') }}</h4>
                                </div>
                                <div class="modal-body">
                                    {{ trans('Doriți să ștergeți acest reper?') }}
                                    <div class="inputs-container"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                                    <a class="remove-table-row btn btn-danger" data-id="{{ $item->id }}" data-remove-icon="#part-remove-icon-{{ $item->id }}">{{ trans('Șterge') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @endforeach
    @else
        <div class="modal fade subassembly-delete-modal" id="subassembly-delete-modal-0">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" >{{ trans('Ștergere (sub)ansamblu') }}</h4>
                    </div>
                    <div class="modal-body">
                        {{ trans('Doriți să ștergeți acest (sub)ansamblu?') }}
                        <div class="inputs-container"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                        <a class="remove-table-row btn btn-danger" data-id="0" data-remove-icon="#subassembly-remove-icon-0">{{ trans('Șterge') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade part-delete-modal" id="part-delete-modal-0">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" >{{ trans('Ștergere reper') }}</h4>
                    </div>
                    <div class="modal-body">
                        {{ trans('Doriți să ștergeți acest reper?') }}
                        <div class="inputs-container"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                        <a class="remove-table-row btn btn-danger" data-id="0" data-remove-icon="#part-remove-icon-0">{{ trans('Șterge') }}</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
