<div id="materials-actions-bar-before"></div>
<div class="actions-bar clearfix" id="materials-actions-bar">
    <div class="col-xs-12 paddingT5 paddingB5 clearfix">
        <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>
        <div class="pull-left marginL5"><button class="btn btn-default submit-form" name="send-to-purchasing">{{ trans('Trimite către aprovizionare') }}</button></div>
        <div class="pull-left marginL10"><button class="btn btn-default submit-form" name="send-order-request">{{ trans('Solicită trimiterea comenzii') }}</button></div>
    </div>
</div>

<h4>{{ trans('Profile') }}</h4>
<div class="table-responsive">
    <table class="table table-bordered table-calculation" id="profiles-table">
        <thead class="text-center">
        <tr>
            <th class="with-right-border" colspan="2">{{ trans('Material') }}</th>
            <th>{{ trans('Calitate') }}</th>
            <th>{{ trans('Lungime') }} (m)</th>
            <th>{{ trans('Greutate specif.') }} (kg/m)</th>
            <th>{{ trans('Greutate') }} (kg)</th>
            <th>{!! trans('M<sup>2</sup> Vops/UM') !!}</th>
            <th>{{ trans('MP Vopsire/Total') }}</th>
            <th>{{ trans('Pret') }} (&euro;/kg)</th>
            <th>{{ trans('Pret') }} (&euro;)</th>
            <th class="lighter">{{ trans('Pierderi') }} (%)</th>
        </tr>
        </thead>
        <tbody>
        @if (!is_null($project->calculation) && isset($project->calculation->data->materials) && isset($project->calculation->data->materials->profile) && count($project->calculation->data->materials->profile) > 0 )
            @set ('profile_materials', (array) $project->calculation->data->materials->profile)
            @php ksort($profile_materials) @endphp
            @foreach ($profile_materials as $k => $material)
                <tr @if (!isset($material->length_gross) || $material->length_gross == '') class="bg-warning" @endif >
                    <td class="paddingL5 paddingR5" width="20"><a class="collapse-icon-container collapsed" data-toggle="collapse" data-target="#profile-sizes-{{ str_replace('.', '-', $k) }}, #profile-prices-{{ str_replace('.', '-', $k) }}, .profile-empty-{{ str_replace('.', '-', $k) }}"  aria-expanded="false"><i class="material-icons icon-plus">&#xE145;</i><i class="material-icons icon-minus">&#xE15B;</i></a></td>
                    <td class="padding0 with-right-border">
                        <table>
                            <tr>
                                <td>
                                    <div class="form-group pull-left">
                                        <span class="input with-label" data-target="materials[profile][{{ $k }}][name]">{{ $material->name }}</span>
                                        {!! Form::hidden('materials[profile][' . $k . '][name]', null) !!}
                                        {!! Form::hidden('materials[profile][' . $k . '][project_material_id]', null) !!}
                                    </div>
                                    @if(isset($material->material) && \App\Models\SettingsMaterial::find($material->material->id)->in_stock->count() > 0)
                                        <a class="info-icon-container stock-info-modal inline-block marginT15 marginL5" data-material-id="{{ $material->material->id }}" data-standard-id="{{ $material->standard->id }}" data-project-id="{{ $project->id }}"><i class="material-icons" data-toggle="tooltip" data-original-title="{{ trans('Rezervare din stock') }}">&#xE1BD;</i></a>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <div class="collapse profile-empty-{{ str_replace('.', '-', $k) }}">
                            <table>
                                <tbody>
                                @if (isset($material->net_sizes) && count($material->net_sizes) > 0)
                                    <tr><td>&nbsp;</td></tr>
                                    @foreach ($material->net_sizes as $i => $net_size)
                                        <tr class="profile-row-{{ $k }}-{{ $i }} profile-row">
                                            <td class="valign-middle">
                                                @foreach ($project->project_materials as $pm)
                                                    @if (isset($material->material) && !is_null($material->material) && !is_null($material->standard) && $pm->material_id == $material->material->id && $pm->standard_id == $material->standard->id && $pm->material_no == $i && $pm->canceled != 1)
                                                        @if ($pm->offer)
                                                            <span class="status" style="background-color: {{ $status_colors[$pm->offer->status] }}">
                                                                {{ $purchasing_statuses[$pm->offer->status] }}
                                                            </span>
                                                        @else
                                                            <span class="status" style="background-color: {{ $status_colors['required'] }}">{{ trans('Necesar') }}</span>
                                                        @endif
                                                        @if ($pm->order_request == 1 && (!$pm->offer || !in_array($pm->offer->status, ['order_sent', 'production', 'stock'])))
                                                            <span class="cursor-default shop-icon" data-toggle="tooltip" title="{{ trans('Poate fi comandat') }}"><i class="material-icons">&#xE854;</i></span>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td class="padding0 text-center">
                        <table>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <span class="input with-label" data-target="materials[profile][{{ $k }}][quality]">{{ $material->quality }}</span>
                                        {!! Form::hidden('materials[profile][' . $k . '][quality]', null) !!}
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="collapse profile-empty-{{ str_replace('.', '-', $k) }}">
                            <table>
                                <tbody>
                                @if (isset($material->net_sizes) && count($material->net_sizes) > 0)
                                    <tr><td>&nbsp;</td></tr>
                                    @foreach ($material->net_sizes as $i => $net_size)
                                        <tr class="profile-row-{{ $k }}-{{ $i }} profile-row">
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td class="padding0">
                        <table>
                            <tr>
                                <td class="paddingR10" width="130">
                                    <div class="form-group focused">
                                        {!! Form::label('materials[profile][' . $k . '][length_net]', trans('NET total'), ['class'=> 'control-label output-label']) !!}
                                        <span class="input with-label" data-target="materials[profile][{{ $k }}][length_net]">{{ $material->length_net }}</span>
                                        {!! Form::hidden('materials[profile][' . $k . '][length_net]', null) !!}
                                    </div>
                                </td>
                                <td class="paddingL0 paddingR15">
                                    <div class="form-group">
                                        {!! Form::label('materials[profile][' . $k . '][length_gross]', trans('BRUT total'), ['class'=> 'control-label']) !!}
                                        {!! Form::number('materials[profile][' . $k . '][length_gross]', null, ['class' => 'form-control profile-gross-length-total', 'min' => '0', 'step' => "0.01"]) !!}
                                        <i class="material-icons alert-icon cursor-default gross-alert" data-toggle="tooltip" data-placement="top" title="{{ trans('BRUT total < SUM (BRUT)')  }}">&#xE002;</i>
                                        <i class="material-icons alert-icon cursor-default gross-net-alert" data-toggle="tooltip" data-placement="top" title="{{ trans('BRUT total < NET total')  }}">&#xE002;</i>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div id="profile-sizes-{{ str_replace('.', '-', $k) }}" class="collapse">
                            <table class="marginB10">
                                @if (isset($material->net_sizes) && count($material->net_sizes) > 0)
                                    <tr>
                                        <td class="paddingT0 paddingB0 paddingR0 valign-middle" width="20">{!! Form::checkbox('select_all_rows' , 1, false, ['class' => '', 'data-target' => '.profile-row'] ) !!}{!! Form::label('select_all_rows', '&nbsp;', ['class' => 'marginB0']) !!}</td>
                                        <td class="padding0" width="80">{!! Form::label('materials[profile][' . $k . '][net_sizes]', trans('NET'), ['class'=> 'control-label output-label']) !!}</td>
                                        <td class="paddingT0 paddingB0 paddingL0" colspan="2">{!! Form::label('materials[profile][' . $k . '][gross_sizes]', trans('BRUT'), ['class'=> 'control-label output-label']) !!}</td>
                                    </tr>
                                    @foreach ($material->net_sizes as $i => $net_size)
                                        <tr class="profile-row-{{ $k }}-{{ $i }} profile-row">
                                            <td class="paddingT0 paddingB0 paddingR10 valign-middle">{!! Form::checkbox('selected_materials[profile][' . $k . '][' . $i . ']', 1, false, ['class' => 'select', 'data-target' => '.profile-row-' . $k . '-' . $i] ) !!}{!! Form::label('selected_materials[profile]' . $k . '][' . $i . ']', '&nbsp;', ['class' => 'marginB0']) !!}</td>
                                            <td class="padding0 paddingR10" width="60">
                                                <div class="form-group focused">
                                                    {!! Form::label('materials[profile][' . $k . '][net_sizes]', trans('NET'), ['class'=> 'control-label output-label']) !!}
                                                    <span class="input with-label" data-target="materials[profile][{{ $k }}][net_sizes][{{ $i }}][length]">{{ $net_size->length }}</span>
                                                    {!! Form::hidden('materials[profile][' . $k . '][net_sizes][' . $i . '][length]', $net_size->length) !!}
                                                </div>
                                            </td>
                                            <td class="padding0 paddingR15">
                                                <div class="form-group">
                                                    {!! Form::label('materials[profile][' . $k . '][gross_sizes]', trans('BRUT'), ['class'=> 'control-label']) !!}
                                                    {!! Form::text('materials[profile][' . $k . '][gross_sizes][' . $i . '][length]', isset($material->gross_sizes[$i]) ? $material->gross_sizes[$i]->length : null, ['class' => 'form-control profile-gross-length']) !!}
                                                    <i class="material-icons alert-icon info-icon cursor-default extension-alert" data-toggle="tooltip" data-placement="top" title="{{ trans('Este necesară înnădirea materialelor')  }}">&#xE8F3;</i>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </td>
                    <td class="padding0">
                        <table>
                            <tr>
                                <td>
                                    <div class="form-group focused">
                                        {!! Form::label('materials[profile][' . $k . '][specific_weight]', trans('NET'), ['class'=> 'control-label output-label']) !!}
                                        <span class="input with-label" data-target="materials[profile][{{ $k }}][specific_weight]">{{ (isset($material->specific_weight) ? $material->specific_weight : (isset($material->material) ? $material->material->G : '')) }}</span>
                                        {!! Form::hidden('materials[profile][' . $k . '][specific_weight]', (isset($material->specific_weight) ? $material->specific_weight : (isset($material->material) ? $material->material->G : ''))) !!}
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="collapse profile-empty-{{ str_replace('.', '-', $k) }}">
                            <table>
                                <tbody>
                                @if (isset($material->net_sizes) && count($material->net_sizes) > 0)
                                    <tr><td>&nbsp;</td></tr>
                                    @foreach ($material->net_sizes as $i => $net_size)
                                        <tr class="profile-row-{{ $k }}-{{ $i }} profile-row"profile>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td class="padding0">
                        <table>
                            <tr>
                                <td>
                                    <div class="form-group focused">
                                        {!! Form::label('materials[profile][' . $k . '][weight_net]', trans ('NET'), ['class'=> 'control-label output-label']) !!}
                                        @set ('weight_net', number_format((float) $material->length_net * (isset($material->specific_weight) ? $material->specific_weight : (isset($material->material) ? $material->material->G : 0)), 2, '.', ''))
                                        <span class="input with-label" data-target="materials[profile][{{ $k }}][weight_net]">{{ $weight_net }}</span>
                                        {!! Form::hidden('materials[profile][' . $k . '][weight_net]', $weight_net) !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group focused">
                                        {!! Form::label('materials[profile][' . $k . '][weight_gross]', trans ('BRUT'), ['class'=> 'control-label output-label']) !!}
                                        @set ('weight_gross', number_format((float) (isset($material->length_gross) ? $material->length_gross : 0) * (isset($material->specific_weight) ? $material->specific_weight : (isset($material->material) ? $material->material->G : 0)), 2, '.', ''))
                                        <span class="input with-label" data-target="materials[profile][{{ $k }}][weight_gross]">{{ $weight_gross }}</span>
                                        {!! Form::hidden('materials[profile][' . $k . '][weight_gross]', null) !!}
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="collapse profile-empty-{{ str_replace('.', '-', $k) }}">
                            <table>
                                <tbody>
                                @if (isset($material->net_sizes) && count($material->net_sizes) > 0)
                                    <tr><td>&nbsp;</td></tr>
                                    @foreach ($material->net_sizes as $i => $net_size)
                                        <tr class="profile-row-{{ $k }}-{{ $i }} profile-row"profile>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td class="padding0">
                        <table>
                            <tr>
                                <td>
                                    <div class="form-group focused">
                                        {!! Form::label('materials[profile][' . $k . '][paint_um]', trans('NET'), ['class'=> 'control-label output-label']) !!}
                                        <span class="input with-label" data-target="materials[profile][{{ $k }}][paint_um]">{{ (isset($material->paint_um) ? $material->paint_um : (isset($material->material) ? $material->material->AL : '')) }}</span>
                                        {!! Form::hidden('materials[profile][' . $k . '][paint_um]', (isset($material->paint_um) ? $material->paint_um : (isset($material->material) ? $material->material->AL : ''))) !!}
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="collapse profile-empty-{{ str_replace('.', '-', $k) }}">
                            <table>
                                <tbody>
                                @if (isset($material->net_sizes) && count($material->net_sizes) > 0)
                                    <tr><td>&nbsp;</td></tr>
                                    @foreach ($material->net_sizes as $i => $net_size)
                                        <tr class="profile-row-{{ $k }}-{{ $i }} profile-row"profile>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td class="padding0">
                        <table>
                            <tr>
                                <td>
                                    <div class="form-group focused">
                                        {!! Form::label('materials[profile][' . $k . '][paint_total]', trans('NET'), ['class'=> 'control-label output-label']) !!}
                                        @set ('paint_total', number_format((float) $material->length_net * (isset($material->paint_um) ? $material->paint_um : (isset($material->material) ? $material->material->AL : 0)), 2, '.', ''))
                                        <span class="input with-label" data-target="materials[profile][{{ $k }}][paint_total]">{{ $paint_total }}</span>
                                        {!! Form::hidden('materials[profile][' . $k . '][paint_total]', $paint_total) !!}
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="collapse profile-empty-{{ str_replace('.', '-', $k) }}">
                            <table>
                                <tbody>
                                @if (isset($material->net_sizes) && count($material->net_sizes) > 0)
                                    <tr><td>&nbsp;</td></tr>
                                    @foreach ($material->net_sizes as $i => $net_size)
                                        <tr class="profile-row-{{ $k }}-{{ $i }} profile-row"profile>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td class="padding0">
                        <table>
                            <tr>
                                <td class="paddingR0">
                                    <div class="form-group">
                                        {!! Form::label('materials[profile][' . $k . '][price_per_kg]', 'EUR', ['class'=> 'control-label']) !!}
                                        {!! Form::number('materials[profile][' . $k . '][price_per_kg]', null, ['class' => 'form-control profile-price-per-kg']) !!}
                                    </div>
                                </td>
                                <td class="padding0 valign-middle">
                                    @set ('offers', [])
                                    @if (!is_null($project->materials_offer))
                                        @set ('offers', $project->materials_offer()->where('project_material_id', isset($material->project_material_id) ? $material->project_material_id : '' )->get())
                                    @endif

                                    @if (count($offers) == 0)
                                        @set ('project_materials', \App\Models\ProjectMaterial::select('id')->where('material_id', isset($material->material) ? $material->material->id : 0)->get())
                                        @set ('project_material_ids', [])
                                        @foreach ($project_materials as $project_material)
                                            @set ($project_material_ids[], $project_material->id)
                                        @endforeach
                                        @set ('offers', \App\Models\ProjectOffer::join('project_offer_supplier', 'project_offers.id', '=', 'project_offer_supplier.project_offer_id')->whereIn('project_offers.project_material_id', $project_material_ids)->orderBy('project_offer_supplier.offer_received_at', 'desc')->take(5)->get())
                                    @endif

                                    @if (count($offers) > 0)
                                        @set('prices_popover_content', '<table class="table-condensed">')
                                        @foreach ($offers as $offer)
                                            @if (!is_null($offer->offer_suppliers) && count($offer->offer_suppliers) > 0)
                                                @foreach ($offer->offer_suppliers as $offer_supplier)
                                                    @set('prices_popover_content', $prices_popover_content . '<tr><td>' . $offer_supplier->offer_received_at . '</td><td>' . $offer_supplier->supplier->name . '</td><td>' . $offer_supplier->price . '</td><td><a class="set-price" data-value="' . $offer_supplier->price . '" data-target="materials[profile][' . $k . '][price_per_kg]">Selectează acest preț</a></td></tr>')
                                                @endforeach
                                            @endif
                                        @endforeach
                                        @set('prices_popover_content', $prices_popover_content . '</table>')

                                        <div data-toggle="tooltip" title="{{ trans('Prețuri') }}"><a class="view-prices marginT5 inline-block" data-toggle="popover"  tabindex="0" role="button" data-trigger="focus" data-placement="left" data-content='{!! $prices_popover_content !!}'><i class="material-icons">&#xE263;</i></a></div>
                                    @endif
                                </td>
                            </tr>
                        </table>


                        <div class="collapse" id="profile-prices-{{ str_replace('.', '-', $k) }}">
                            <table>
                                <tbody>
                                @if (isset($material->net_sizes) && count($material->net_sizes) > 0)
                                    <tr><td colspan="2">&nbsp;</td></tr>
                                    @foreach ($material->net_sizes as $i => $net_size)
                                        <tr class="profile-row-{{ $k }}-{{ $i }} profile-row"profile>
                                            <td class="paddingT0 paddingB0 paddingR0">
                                                <div class="form-group">
                                                    {!! Form::label('materials[profile][' . $k . '][gross_sizes][' . $i . '][price_per_kg]', 'EUR', ['class'=> 'control-label']) !!}
                                                    {!! Form::number('materials[profile][' . $k . '][gross_sizes][' . $i . '][price_per_kg]', null, ['class' => 'form-control profile-row-price']) !!}

                                                </div>
                                            </td>
                                            <td class="paddingL0 paddingR0">
                                                @if (!is_null($project->materials_offer) && count($offers) > 0)
                                                    @set('prices_popover_content', '<table class="table-condensed">')
                                                    @foreach ($offers as $offer)
                                                        @if (!is_null($offer->offer_suppliers) && count($offer->offer_suppliers) > 0)
                                                            @foreach ($offer->offer_suppliers as $offer_supplier)
                                                                @set('prices_popover_content', $prices_popover_content . '<tr><td>' . $offer_supplier->offer_received_at . '</td><td>' . $offer_supplier->supplier->name . '</td><td>' . $offer_supplier->price . '</td><td><a class="set-price" data-value="' . $offer_supplier->price . '" data-target="materials[profile][' . $k . '][gross_sizes][' . $i . '][price_per_kg]">Selectează acest preț</a></td></tr>')
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    @set('prices_popover_content', $prices_popover_content . '</table>')
                                                    <div data-toggle="tooltip" title="{{ trans('Prețuri') }}"><a class="view-prices marginT5 inline-block" data-toggle="popover"  tabindex="0" role="button" data-trigger="focus" data-placement="left" data-content='{!! $prices_popover_content !!}'><i class="material-icons">&#xE263;</i></a></div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div class="form-group focused">
                            {!! Form::label('materials[profile][' . $k . '][price]', trans('BRUT'), ['class'=> 'control-label output-label']) !!}
                            @set ('price', number_format((float) (isset($material->price_per_kg) ? $material->price_per_kg : 0) * $weight_gross, 2, '.', ''))
                            <span class="input with-label" data-target="materials[profile][{{ $k }}][price]">{{ $price }}</span>
                            {!! Form::hidden('materials[profile][' . $k . '][price]', $price) !!}
                        </div>
                    </td>
                    <td class="lighter">
                        <div class="form-group">
                            @set ('verify_value', number_format((float) (isset($material->length_gross) && $material->length_gross != 0 ? ($material->length_gross - (isset($material->length_net) ? $material->length_net : 0)) * 100 / $material->length_gross : 0), 2, '.', ''))
                            <span class="input with-label" data-target="materials[profile][{{ $k }}][verify]">{{ $verify_value }}</span>
                            {!! Form::hidden('materials[profile][' . $k . '][verify]', $verify_value) !!}
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
        <tfoot>
        <tr>
            <th class="text-right" colspan="2" ><h4>{{ trans('Totaluri profile') }}</h4></th>
            <th class="text-center"></th>
            <th>{{ trans('Lungime') }} (m)</th>
            <th></th>
            <th>{{ trans('Greutate') }} (kg)</th>
            <th></th>
            <th>{{ trans('MP Vopsire/Total') }}</th>
            <th></th>
            <th>{{ trans('Pret') }} (&euro;)</th>
            <th></th>
        </tr>
        <tr>
            <td class="row-title" colspan="2">{{ strtoupper(trans('NET')) }}</td>
            <td></td>
            <td><span class="materials-profile-total-length-net"></span></td>
            <td></td>
            <td><span class="materials-profile-total-weight-net"></span></td>
            <td></td>
            <td><span class="materials-profile-total-paint-net"></span></td>
            <td></td>
            <td><span class="materials-profile-total-price-net"></span></td>
            <td></td>
        </tr>
        <tr>
            <td class="row-title" colspan="2">{{ strtoupper(trans('BRUT')) }}</td>
            <td></td>
            <td><span class="materials-profile-total-length-gross"></span></td>
            <td></td>
            <td><span class="materials-profile-total-weight-gross"></span></td>
            <td></td>
            <td><span class="materials-profile-total-paint-gross"></span></td>
            <td></td>
            <td><span class="materials-profile-total-price-gross"></span></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</div>

<h4>{{ trans('Table') }}</h4>
<div class="table-responsive">
    <table class="table table-bordered table-calculation" id="plates-table">
        <thead class="text-center">
        <tr>
            <th class="with-right-border" colspan="2">{{ trans('Material') }}</th>
            <th>{{ trans('Calitate') }}</th>
            <th>{{ trans('Mărimi') }}</th>
            <th>S (m<sup>2</sup>)</th>
            <th>{{ trans('Greutate') }} (kg)</th>
            <th>{{ trans('MP Vopsire/Total') }}</th>
            <th>{{ trans('Pret') }} (&euro;/kg)</th>
            <th>{{ trans('Pret') }} (&euro;)</th>
            <th class="lighter">{{ trans('Pierderi') }} (%)</th>
        </tr>
        </thead>
        <tbody>
        @if (!is_null($project->calculation) && isset($project->calculation->data->materials) && isset($project->calculation->data->materials->plate) && count($project->calculation->data->materials->plate) > 0 )
            @set ('plate_materials', (array) $project->calculation->data->materials->plate)
            @php ksort($plate_materials) @endphp
            @foreach ($plate_materials as $k => $material)
                <tr @if (!isset($material->necessary_gross) || $material->necessary_gross == '') class="bg-warning" @endif>
                    <td class="paddingL5 paddingR5" width="20"><a class="collapse-icon-container collapsed" data-toggle="collapse" data-target="#plate-sizes-{{ str_replace('.', '-', $k) }}, #plate-surfaces-{{ str_replace('.', '-', $k) }}, #plate-weights-{{ str_replace('.', '-', $k)  }}, #plate-empty-{{ str_replace('.', '-', $k) }}, #plate-prices-{{ str_replace('.', '-', $k) }}" aria-controls="plate-sizes-{{ str_replace('.', '-', $k) }}, plate-surfaces-{{ str_replace('.', '-', $k) }}, plate-weights-{{ str_replace('.', '-', $k) }}, plate-empty-{{ str_replace('.', '-', $k) }}, plate-prices-{{ str_replace('.', '-', $k)  }}"  aria-expanded="false"><i class="material-icons icon-plus">&#xE145;</i><i class="material-icons icon-minus">&#xE15B;</i></a></td>
                    <td class="with-right-border padding0">
                        <table>
                            <tr>
                                <td>
                                    <div class="form-group pull-left">
                                        <span class="input with-label" data-target="materials[plate][{{ $k }}][name]">{{ $material->name }}</span>
                                        {!! Form::hidden('materials[plate][' . $k . '][name]', null) !!}
                                        {!! Form::hidden('materials[plate][' . $k . '][project_material_id]', null) !!}
                                        {!! Form::hidden('materials[plate][' . $k . '][thickness]', (isset($material->thickness) ? $material->thickness : (isset($material->material) ? $material->material->thickness : ''))) !!}
                                    </div>
                                    @if(isset($material->material) && \App\Models\SettingsMaterial::find($material->material->id)->in_stock->count() > 0)
                                        <a class="info-icon-container stock-info-modal inline-block marginT15 marginL5" data-material-id="{{ $material->material->id }}" data-standard-id="{{ $material->standard->id }}" data-project-id="{{ $project->id }}"><i class="material-icons" data-toggle="tooltip" data-original-title="{{ trans('Rezervare din stock') }}">&#xE1BD;</i></a>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <div class="collapse plate-empty-{{ str_replace('.', '-', $k) }}">
                            <table>
                                <tbody>
                                @if (isset($material->net_sizes) && count($material->net_sizes) > 0)
                                    <tr><td>&nbsp;</td></tr>
                                    @foreach ($material->net_sizes as $i => $net_size)
                                        <tr class="plate-row-{{ $k }}-{{ $i }} plate-row">
                                            <td class="valign-middle">
                                                @foreach ($project->project_materials as $pm)
                                                    @if (isset($material->material) && !is_null($material->material) && !is_null($material->standard) && $pm->material_id == $material->material->id && $pm->standard_id == $material->standard->id && $pm->material_no == $i && $pm->canceled != 1)
                                                        @if ($pm->offer)
                                                            <span class="status" style="background-color: {{ $status_colors[$pm->offer->status] }}">
                                                                {{ $purchasing_statuses[$pm->offer->status] }}
                                                            </span>
                                                        @else
                                                            <span class="status" style="background-color: {{ $status_colors['required'] }}">{{ trans('Necesar') }}</span>
                                                        @endif
                                                        @if ($pm->order_request == 1 && (!$pm->offer || !in_array($pm->offer->status, ['order_sent', 'production', 'stock'])))
                                                            <span class="cursor-default shop-icon" data-toggle="tooltip" title="{{ trans('Poate fi comandat') }}"><i class="material-icons">&#xE854;</i></span>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td class="text-center padding0">
                        <table>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <span class="input with-label" data-target="materials[plate][{{ $k }}][quality]">{{ $material->quality }}</span>
                                        {!! Form::hidden('materials[plate][' . $k . '][quality]', null) !!}
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="collapse" id="plate-empty-{{ str_replace('.', '-', $k) }}">
                            <table>
                                @if (isset($material->net_sizes) && count($material->net_sizes) > 0)
                                    <tr><td>&nbsp;</td></tr>
                                    @foreach ($material->net_sizes as $i => $net_size)
                                        <tr class="plate-row-{{ $k }}-{{ $i }} plate-row"><td>&nbsp;</td></tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </td>
                    <td width="350" class="padding0">
                        <div class="collapse" id="plate-sizes-{{ str_replace('.', '-', $k) }}">
                            <table class="marginB10">
                                <tbody>
                                <tr><td colspan="5">{!! Form::text('', null, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}</td></tr>
                                @if (isset($material->net_sizes) && count($material->net_sizes) > 0)
                                    <tr>
                                        <td class="paddingT0 paddingB0 paddingR0 valign-middle">{!! Form::checkbox('select_all_rows' , 1, false, ['class' => '', 'data-target' => '.plate-row'] ) !!}{!! Form::label('select_all_rows', '&nbsp;', ['class' => 'marginB0']) !!}</td>
                                        <td class="padding0" colspan="2">{!! Form::label('materials[plate][' . $k . '][net_sizes]', trans('NET'), ['class'=> 'control-label output-label']) !!}</td>
                                        <td class="paddingT0 paddingB0 paddingL0" colspan="2">{!! Form::label('materials[plate][' . $k . '][gross_sizes]', trans('BRUT'), ['class'=> 'control-label output-label']) !!}</td>
                                    </tr>
                                    @foreach ($material->net_sizes as $i => $net_size)
                                        <tr class="plate-row-{{ $k }}-{{ $i }} plate-row">
                                            <td class="paddingT0 paddingB0 paddingR10 valign-middle">{!! Form::checkbox('selected_materials[plate][' . $k . '][' . $i . ']', 1, false, ['class' => 'select', 'data-target' => '.plate-row-' . $k . '-' . $i] ) !!}{!! Form::label('selected_materials[plate][' . $k . '][' . $i . ']', '&nbsp;', ['class' => 'marginB0']) !!}</td>
                                            <td class="padding0 paddingR10">
                                                <div class="form-group focused">
                                                    {!! Form::label('materials[plate][' . $k . '][net_sizes]', 'L (mm)', ['class'=> 'control-label output-label']) !!}
                                                    <span class="input with-label" data-target="materials[plate][{{ $k }}][net_sizes][{{ $i }}][length]">{{ $net_size->length }}</span>
                                                    {!! Form::hidden('materials[plate][' . $k . '][net_sizes][' . $i . '][length]', $net_size->length) !!}
                                                </div>
                                            </td>
                                            <td class="padding0 paddingR10">
                                                <div class="form-group focused">
                                                    {!! Form::label('materials[plate][' . $k . '][net_sizes]', 'l (mm)', ['class'=> 'control-label output-label']) !!}
                                                    <span class="input with-label" data-target="materials[plate][{{ $k }}][net_sizes][{{ $i }}][width]">{{ $net_size->width }}</span>
                                                    {!! Form::hidden('materials[plate][' . $k . '][net_sizes][' . $i . '][width]', $net_size->width) !!}
                                                </div>
                                            </td>
                                            <td class="padding0 paddingR10">
                                                <div class="form-group">
                                                    {!! Form::label('materials[plate][' . $k . '][gross_sizes]', 'L (mm)', ['class'=> 'control-label']) !!}
                                                    {!! Form::text('materials[plate][' . $k . '][gross_sizes][' . $i . '][length]', (isset($material->gross_sizes) && count($material->gross_sizes) > 0 && isset($material->gross_sizes[$i])) ? $material->gross_sizes[$i]->length : null, ['class' => 'form-control gross-size', 'data-index' => $i]) !!}
                                                </div>
                                            </td>
                                            <td class="paddingT0 paddingB0 paddingL0">
                                                <div class="form-group">
                                                    {!! Form::label('materials[plate][' . $k . '][gross_sizes]', 'l (mm)', ['class'=> 'control-label']) !!}
                                                    {!! Form::text('materials[plate][' . $k . '][gross_sizes][' . $i . '][width]', (isset($material->gross_sizes) && count($material->gross_sizes) > 0 && isset($material->gross_sizes[$i])) ? $material->gross_sizes[$i]->width : null, ['class' => 'form-control gross-size', 'data-index' => $i]) !!}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td class="padding0">
                        <table>
                            <tbody>
                            <tr>
                                <td class="paddingR0">
                                    <div class="form-group paddingR10 focused">
                                        @set ('necessary_net', 0)
                                        @set ('weight_net', 0)
                                        {{--
                                        @if (!isset($material->necessary_net) || !isset($material->weight_net))
                                            @foreach ($material->net_sizes as $gross_size)
                                                @set ('necessary_net', $necessary_net + round(($gross_size->length / 1000) * ($gross_size->width / 1000), 2))
                                                @set ('weight_net', $weight_net + round(($gross_size->length / 1000) * ($gross_size->width / 1000) * $material->material->thickness, 2) * 8)
                                            @endforeach
                                        @else
                                            @set ('necessary_net', $material->necessary_net)
                                            @set ('weight_net', $material->weight_net)
                                        @endif
                                        --}}
                                        @foreach ($material->net_sizes as $gross_size)
                                            @set ('necessary_net', $necessary_net + round(($gross_size->length / 1000) * ($gross_size->width / 1000), 2))
                                            @set ('weight_net', $weight_net + round(($gross_size->length / 1000) * ($gross_size->width / 1000) * $material->material->thickness, 2) * 8)
                                        @endforeach
                                        {!! Form::label('materials[plate][' . $k . '][necessary_net]', trans('NET total'), ['class'=> 'control-label output-label']) !!}
                                        <span class="input with-label" data-target="materials[plate][{{ $k }}][necessary_net]">{{ number_format($necessary_net, 2, '.', '') }}</span>
                                        {!! Form::hidden('materials[plate][' . $k . '][necessary_net]', $necessary_net) !!}
                                    </div>
                                </td>
                                <td class="paddingL15">
                                    <div class="form-group focused">
                                        @set ('necessary_gross', 0)
                                        @set ('weight_gross', 0)
                                        @if (!isset($material->necessary_gross) || !isset($material->weight_gross))
                                            @foreach ($material->gross_sizes as $gross_size)
                                                @set ('necessary_gross', $necessary_gross + round(($gross_size->length / 1000) * ($gross_size->width / 1000), 2))
                                                @set ('weight_gross', $weight_gross + round(($gross_size->length / 1000) * ($gross_size->width / 1000) * $material->material->thickness, 2))
                                            @endforeach
                                        @else
                                            @set ('necessary_gross', $material->necessary_gross)
                                            @set ('weight_gross', $material->weight_gross)
                                        @endif
                                        {!! Form::label('materials[plate][' . $k . '][necessary_gross]', trans('BRUT total'), ['class'=> 'control-label output-label']) !!}

                                        <span class="input with-label" data-target="materials[plate][{{ $k }}][necessary_gross]">{{ number_format($necessary_gross, 2, '.', '') }}</span>
                                        {!! Form::hidden('materials[plate][' . $k . '][necessary_gross]', $necessary_gross) !!}
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="collapse" id="plate-surfaces-{{ str_replace('.', '-', $k) }}">
                            <table>
                                <tbody>
                                @if (isset($material->net_sizes) && count($material->net_sizes) > 0)
                                    <tr>
                                        <td class="paddingT0 paddingB0 paddingR10">{!! Form::label('', trans('NET'), ['class'=> 'control-label output-label']) !!}</td>
                                        <td class="paddingT0 paddingB0 paddingL15">{!! Form::label('', trans('BRUT'), ['class'=> 'control-label output-label']) !!}</td>
                                    </tr>
                                    @foreach ($material->net_sizes as $i => $net_size)
                                        <tr class="plate-row-{{ $k }}-{{ $i }} plate-row">
                                            <td class="paddingT0 paddingB0 paddingR10">
                                                <div class="form-group">
                                                    <span class="input with-label" data-target="materials[plate][{{ $k }}][net_sizes][{{ $i }}][surface]">{{ round(($net_size->length / 1000) * ($net_size->width / 1000), 2) }}</span>
                                                    {!! Form::hidden('materials[plate][' . $k . '][net_sizes][' . $i . '][surface]', round(($net_size->length / 1000) * ($net_size->width / 1000), 2)) !!}
                                                </div>
                                            </td>
                                            <td class="paddingT0 paddingB0 paddingL15">
                                                <div class="form-group">
                                                    <span class="input with-label gross-surface" data-target="materials[plate][{{ $k }}][gross_sizes][{{ $i }}][surface]" data-index="{{ $i }}">{{ (isset($material->gross_sizes) && count($material->gross_sizes) > 0 && isset($material->gross_sizes[$i])) ? round(($material->gross_sizes[$i]->length / 1000) * ($material->gross_sizes[$i]->width / 1000), 2) : null }}</span>
                                                    {!! Form::hidden('materials[plate][' . $k . '][gross_sizes][' . $i . '][surface]', (isset($material->gross_sizes) && count($material->gross_sizes) > 0 && isset($material->gross_sizes[$i])) ? round(($material->gross_sizes[$i]->length / 1000) * ($material->gross_sizes[$i]->width / 1000), 2) : null, ['class' => 'gross-surface', 'data-index' => $i]) !!}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td class="padding0">
                        <table>
                            <tbody>
                            <tr>
                                <td class="paddingR10">
                                    <div class="form-group focused">
                                        {!! Form::label('materials[plate][' . $k . '][weight_net]', trans ('NET total'), ['class'=> 'control-label output-label']) !!}
                                        <span class="input with-label" data-target="materials[plate][{{ $k }}][weight_net]">{{ number_format($weight_net, 2, '.', '') }}</span>
                                        {!! Form::hidden('materials[plate][' . $k . '][weight_net]', $weight_net) !!}
                                    </div>
                                </td>
                                <td class="paddingL10">
                                    <div class="form-group focused">
                                        {!! Form::label('materials[plate][' . $k . '][weight_gross]', trans ('BRUT total'), ['class'=> 'control-label output-label']) !!}
                                        <span class="input with-label" data-target="materials[plate][{{ $k }}][weight_gross]">{{ number_format($weight_gross, 2, '.', '') }}</span>
                                        {!! Form::hidden('materials[plate][' . $k . '][weight_gross]', $weight_gross) !!}
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="collapse" id="plate-weights-{{ str_replace('.', '-', $k) }}">
                            <table>
                                <tbody>
                                @if (isset($material->net_sizes) && count($material->net_sizes) > 0)
                                    <tr>
                                        <td class="paddingT0 paddingB0 paddingR10">{!! Form::label('', trans('NET'), ['class'=> 'control-label output-label']) !!}</td>
                                        <td class="paddingT0 paddingB0 paddingL10">{!! Form::label('', trans('BRUT'), ['class'=> 'control-label output-label']) !!}</td>
                                    </tr>
                                    @foreach ($material->net_sizes as $i => $net_size)
                                        <tr class="plate-row-{{ $k }}-{{ $i }} plate-row">
                                            <td class="paddingT0 paddingB0 paddingR10">
                                                <div class="form-group">
                                                    <span class="input with-label" data-target="materials[plate][{{ $k }}][net_sizes][{{ $i }}][weight]">{{ round(($net_size->length / 1000) * ($net_size->width / 1000) * $material->thickness * 8, 2) }}</span>
                                                    {!! Form::hidden('materials[plate][' . $k . '][net_sizes][' . $i . '][weight]', round(($net_size->length / 1000) * ($net_size->width / 1000) * $material->thickness * 8, 2)) !!}
                                                </div>
                                            </td>
                                            <td class="paddingT0 paddingB0 paddingL10">
                                                <div class="form-group">
                                                    <span class="input with-label weight-gross" data-target="materials[plate][{{ $k }}][gross_sizes][{{ $i }}][weight]" data-index="{{ $i }}">{{ (isset($material->gross_sizes) && count($material->gross_sizes) > 0 && isset($material->gross_sizes[$i])) ? round(($material->gross_sizes[$i]->length / 1000) * ($material->gross_sizes[$i]->width / 1000) * $material->thickness * 8, 2) : null }}</span>
                                                    {!! Form::hidden('materials[plate][' . $k . '][gross_sizes][' . $i . '][weight]', (isset($material->gross_sizes) && count($material->gross_sizes) > 0 && isset($material->gross_sizes[$i])) ? round(($material->gross_sizes[$i]->length / 1000) * ($material->gross_sizes[$i]->width / 1000) * $material->thickness * 8, 2) : null, ['class' => 'weight-gross', 'data-index' => $i]) !!}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td class="padding0">
                        <table>
                            <tr>
                                <td>
                                    <div class="form-group focused">
                                        {!! Form::label('materials[plate][' . $k . '][paint_total]', trans('NET'), ['class'=> 'control-label output-label']) !!}
                                        <span class="input with-label" data-target="materials[plate][{{ $k }}][paint_total]">{{ number_format((float) $necessary_net * 2, 2 ,'.','') }}</span>
                                        {!! Form::hidden('materials[plate][' . $k . '][paint_total]', null) !!}
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="collapse" id="plate-empty-{{ str_replace('.', '-', $k) }}">
                            <table>
                                @if (isset($material->net_sizes) && count($material->net_sizes) > 0)
                                    <tr><td>&nbsp;</td></tr>
                                    @foreach ($material->net_sizes as $i => $net_size)
                                        <tr class="plate-row-{{ $k }}-{{ $i }} plate-row"><td>&nbsp;</td></tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </td>
                    <td class="padding0">
                        <table>
                            <tr>
                                <td class="paddingR0">
                                    <div class="form-group">
                                        {!! Form::label('materials[plate][' . $k . '][price_per_kg]', 'EUR', ['class'=> 'control-label']) !!}
                                        {!! Form::number('materials[plate][' . $k . '][price_per_kg]', null, ['class' => 'form-control plate-price-per-kg']) !!}
                                    </div>
                                </td>
                                <td class="paddingL0 valign-middle">
                                    @if (!is_null($project->materials_offer))
                                        @set ('offers', $project->materials_offer()->where('project_material_id', isset($material->project_material_id) ? $material->project_material_id : '')->get())
                                        @if (count($offers) > 0)
                                            @set('prices_popover_content', '<table class="table-condensed">')
                                            @foreach ($offers as $offer)
                                                @if (!is_null($offer->offer_suppliers) && count($offer->offer_suppliers) > 0)
                                                    @foreach ($offer->offer_suppliers as $offer_supplier)
                                                        @set('prices_popover_content', $prices_popover_content . '<tr><td>' . $offer_supplier->supplier->name . '</td><td>' . $offer_supplier->price . '</td><td><a class="set-price" data-value="' . $offer_supplier->price . '" data-target="materials[plate][' . $k . '][price_per_kg]">Selectează acest preț</a></td></tr>')
                                                    @endforeach
                                                @endif
                                            @endforeach
                                            @set('prices_popover_content', $prices_popover_content . '</table>')

                                            <div data-toggle="tooltip" title="{{ trans('Prețuri') }}"><a class="view-prices marginT5 inline-block" data-toggle="popover"  tabindex="0" role="button" data-trigger="focus" data-placement="left" data-content='{!! $prices_popover_content !!}'><i class="material-icons">&#xE263;</i></a></div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <div class="collapse" id="plate-prices-{{ str_replace('.', '-', $k) }}">
                            <table>
                                <tbody>
                                @if (isset($material->net_sizes) && count($material->net_sizes) > 0)
                                    <tr><td>&nbsp;</td></tr>
                                    @foreach ($material->net_sizes as $i => $net_size)
                                        <tr class="plate-row-{{ $k }}-{{ $i }} plate-row"profile>
                                            <td class="paddingT0 paddingB0 paddingR0">
                                                <div class="form-group">
                                                    {!! Form::label('materials[plate][' . $k . '][gross_sizes][' . $i . '][price_per_kg]', 'EUR', ['class'=> 'control-label']) !!}
                                                    {!! Form::number('materials[plate][' . $k . '][gross_sizes][' . $i . '][price_per_kg]', null, ['class' => 'form-control plate-row-price']) !!}

                                                </div>
                                            </td>
                                            <td class="paddingL0">
                                                @if (!is_null($project->materials_offer) && count($offers) > 0)
                                                    @set('prices_popover_content', '<table class="table-condensed">')
                                                    @foreach ($offers as $offer)
                                                        @if (!is_null($offer->offer_suppliers) && count($offer->offer_suppliers) > 0)
                                                            @foreach ($offer->offer_suppliers as $offer_supplier)
                                                                @set('prices_popover_content', $prices_popover_content . '<tr><td>' . $offer_supplier->supplier->name . '</td><td>' . $offer_supplier->price . '</td><td><a class="set-price" data-value="' . $offer_supplier->price . '" data-target="materials[plate][' . $k . '][gross_sizes][' . $i . '][price_per_kg]">Selectează acest preț</a></td></tr>')
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    @set('prices_popover_content', $prices_popover_content . '</table>')
                                                    <div data-toggle="tooltip" title="{{ trans('Prețuri') }}"><a class="view-prices marginT5 inline-block" data-toggle="popover"  tabindex="0" role="button" data-trigger="focus" data-placement="left" data-content='{!! $prices_popover_content !!}'><i class="material-icons">&#xE263;</i></a></div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div class="form-group focused">
                            {!! Form::label('materials[plate][' . $k . '][price]', trans('BRUT'), ['class'=> 'control-label output-label']) !!}
                            <span class="input with-label" data-target="materials[plate][{{ $k }}][price]">{{ isset($material->price) ? $material->price : '' }}</span>
                            {!! Form::hidden('materials[plate][' . $k . '][price]', null) !!}
                        </div>
                    </td>
                    <td class="lighter">
                        <div class="form-group">
                            @set ('verify_value', number_format((float) ($necessary_gross != 0 ? ($necessary_gross - $necessary_net) * 100 / $necessary_gross : 0), 2, '.', ''))
                            <span class="input with-label" data-target="materials[plate][{{ $k }}][verify]">{{ $verify_value  }}</span>
                            {!! Form::hidden('materials[plate][' . $k . '][verify]', $verify_value) !!}
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
        <tfoot>
        <tr>
            <th class="text-right" colspan="2" ><h4>{{ trans('Totaluri table') }}</h4></th>
            <th></th>
            <th></th>
            <th>S (m<sup>2</sup>)</th>
            <th>{{ trans('Greutate') }} (kg)</th>
            <th>{{ trans('MP Vopsire/Total') }}</th>
            <th></th>
            <th>{{ trans('Pret') }} (&euro;)</th>
            <th></th>
        </tr>
        <tr>
            <td class="row-title" colspan="2">{{ strtoupper(trans('NET')) }}</td>
            <td></td>
            <td></td>
            <td><span class="materials-plates-total-necessary-net"></span></td>
            <td><span class="materials-plates-total-weight-net"></span></td>
            <td><span class="materials-plates-total-paint-net"></span></td>
            <td></td>
            <td><span class="materials-plates-total-price-net"></span></td>
            <td></td>
        </tr>
        <tr>
            <td class="row-title" colspan="2">{{ strtoupper(trans('BRUT')) }}</td>
            <td></td>
            <td></td>
            <td><span class="materials-plates-total-necessary-gross"></span></td>
            <td><span class="materials-plates-total-weight-gross"></span></td>
            <td><span class="materials-plates-total-paint-gross"></span></td>
            <td></td>
            <td><span class="materials-plates-total-price-gross"></span></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</div>

<h4>{{ trans('Alte materiale') }}</h4>
<div class="table-responsive">
    <table class="table table-bordered table-calculation" id="other-materials-table">
        <thead class="text-center">
        <tr>
            <th class="with-right-border" colspan="2">{{ trans('Material') }}</th>
            <th>{{ trans('Calitate') }}</th>
            <th>{{ trans('Cantitate') }} (m)</th>
            <th>{{ trans('Pret') }} (&euro;/buc)</th>
            <th>{{ trans('Pret total') }} (&euro;)</th>
        </tr>
        </thead>
        <tbody>
        @if (!is_null($project->calculation) && isset($project->calculation->data->materials) && isset($project->calculation->data->materials->other) && count($project->calculation->data->materials->other) > 0 )
            @foreach ($project->calculation->data->materials->other as $k => $material)
                <tr>
                    <td class="paddingT0 paddingB0 paddingR10 valign-middle" width="21">{!! Form::checkbox('selected_materials[other][' . $k . ']', 1, false, ['class' => 'select'] ) !!}{!! Form::label('selected_materials[other]' . $k . ']', '&nbsp;', ['class' => 'marginB0']) !!}</td>
                    <td class="with-right-border">
                        <div class="form-group">
                            {!! Form::text('materials[other][' . $k . '][name]', null, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                            {!! Form::hidden('materials[other][' . $k . '][project_material_id]', null) !!}
                        </div>
                        @if(\App\Models\SettingsMaterial::find($material->material->id)->in_stock->count() > 0)
                            <a class="info-icon-container stock-info-modal inline-block marginT15 marginL5" data-material-id="{{ $material->material->id }}" data-standard-id="{{ $material->standard->id }}" data-project-id="{{ $project->id }}"><i class="material-icons" data-toggle="tooltip" data-original-title="{{ trans('Rezervare din stock') }}">&#xE1BD;</i></a>
                        @endif
                        <div class="form-group marginT15">
                            @foreach ($project->project_materials as $pm)
                                @if (isset($material->material) && !is_null($material->material) && !is_null($material->standard) && $pm->material_id == $material->material->id && $pm->standard_id == $material->standard->id)
                                    @if ($pm->offer)
                                        <span class="status" style="background-color: {{ $status_colors[$pm->offer->status] }}">
                                            {{ $purchasing_statuses[$pm->offer->status] }}
                                        </span>
                                    @else
                                        <span class="status" style="background-color: {{ $status_colors['required'] }}">{{ trans('Necesar') }}</span>
                                    @endif
                                    @if ($pm->order_request == 1 && (!$pm->offer || !in_array($pm->offer->status, ['order_sent', 'production', 'stock'])))
                                        <span class="cursor-default shop-icon" data-toggle="tooltip" title="{{ trans('Poate fi comandat') }}"><i class="material-icons">&#xE854;</i></span>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-group">
                            {!! Form::text('materials[other][' . $k . '][quality]', null, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::label('materials[other][' . $k . '][quantity]', trans('BRUT'), ['class'=> 'control-label']) !!}
                            {!! Form::number('materials[other][' . $k . '][quantity]', null, ['class' => 'form-control ', 'min' => '0', 'step' => "0.01"]) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::label('materials[other][' . $k . '][price_per_piece]', trans('EUR'), ['class'=> 'control-label']) !!}
                            {!! Form::number('materials[other][' . $k . '][price_per_piece]', null, ['class' => 'form-control']) !!}
                            @if (!is_null($project->materials_offer))
                                @set ('offers', $project->materials_offer()->where('project_material_id', isset($material->project_material_id) ? $material->project_material_id : '')->get())
                                @if (count($offers) > 0)
                                    @set('prices_popover_content', '<table class="table-condensed">')
                                    @foreach ($offers as $offer)
                                        @if (!is_null($offer->offer_suppliers) && count($offer->offer_suppliers) > 0)
                                            @foreach ($offer->offer_suppliers as $offer_supplier)
                                                @set('prices_popover_content', $prices_popover_content . '<tr><td>' . $offer_supplier->supplier->name . '</td><td>' . $offer_supplier->price . '</td><td><a class="set-price" data-value="' . $offer_supplier->price . '" data-target="materials[other][' . $k . '][price_per_piece]">Selectează acest preț</a></td></tr>')
                                            @endforeach
                                        @endif
                                    @endforeach
                                    @set('prices_popover_content', $prices_popover_content . '</table>')

                                    <a class="view-prices marginT5 inline-block" data-toggle="popover"  tabindex="0" role="button" data-trigger="focus" data-placement="left" data-content='{!! $prices_popover_content !!}'><i class="material-icons">&#xE263;</i> {{ trans('prețuri') }}</a>
                                @endif
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::label('materials[other][' . $k . '][price]', trans('BRUT'), ['class'=> 'control-label output-label']) !!}
                            {!! Form::text('materials[other][' . $k . '][price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
        <tfoot>
        <tr>
            <th class="text-right" colspan="2" ><h4>{{ trans('Totaluri alte materiale') }}</h4></th>
            <th></th>
            <th></th>
            <th></th>
            <th>{{ trans('Pret total') }} (&euro;)</th>
        </tr>
        <tr>
            <td class="row-title" colspan="2">{{ strtoupper(trans('BRUT')) }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td><span class="materials-other-total-price"></span></td>
        </tr>
        </tfoot>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-calculation" id="main-materials-table">
        <tfoot>
        <tr>
            <th class="text-right" ><h4>{{ trans('Totaluri materiale principale') }}</h4></th>
            <th>{{ trans('Greutate') }} (kg)</th>
            <th>{{ trans('Pret') }} (&euro;/kg)</th>
            <th>{{ trans('Pret') }} (&euro;)</th>
            <th>{{ trans('Pierderi') }}</th>
        </tr>
        <tr>
            <td></td>
            <td><span class="materials-main-total-weight"></span></td>
            <td><span class="materials-main-total-price-per-kg"></span></td>
            <td><span class="materials-main-total-price"></span></td>
            <td><span class="materials-main-total-loss"></span></td>
        </tr>
        </tfoot>
    </table>
</div>

@if ($project->has_welding() || $project->has_painting())
    <h4>{{ trans('Materiale auxiliare') }}</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-calculation" id="auxiliary-materials-table">
            <thead class="text-center">
            <tr>
                <th class="with-right-border">{{ trans('Material') }}</th>
                <th>{{ trans('Consum') }}</th>
                <th>{{ trans('Pret') }}</th>
                <th>{{ trans('Necesar') }}</th>
                <th class="lighter">{{ trans('Valoare') }} (&euro;)</th>
            </tr>
            </thead>
            <tbody>
            @if (!is_null($project->calculation) && isset($project->calculation->data->materials) && isset($project->calculation->data->materials->auxiliary) && count($project->calculation->data->materials->auxiliary) > 0 )
                @foreach ($project->calculation->data->materials->auxiliary as $k => $material)
                    <tr>
                        <td>
                            <div class="form-group">
                                {!! Form::text('materials[auxiliary][' . $k . '][name]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                                {!! Form::hidden('materials[auxiliary][' . $k . '][project_material_id]', null) !!}
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                {!! Form::text('materials[auxiliary][' . $k . '][consumption]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                {!! Form::text('materials[auxiliary][' . $k . '][price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                {!! Form::text('materials[auxiliary][' . $k . '][necessary]', null, ['class' => 'form-control  output', 'disabled' => 'disabled', 'data-coefficient' => isset($material->material) ? $material->material->coefficient : '']) !!}
                            </div>
                        </td>
                        <td class="lighter">
                            <div class="form-group">
                                {!! Form::text('materials[auxiliary][' . $k . '][value]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                            </div>
                        </td>

                    </tr>
                @endforeach
            @else
                @set ('auxiliary_materials', App\Models\SettingsMaterial::where('type', 'auxiliary')->get())
                @if (!is_null($auxiliary_materials) && count($auxiliary_materials) > 0)
                    @foreach ($auxiliary_materials as $k => $material)
                        <tr>
                            <td>
                                <div class="form-group">
                                    {!! Form::text('materials[auxiliary][' . $k . '][name]', $material->name, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                                    {!! Form::hidden('materials[auxiliary][' . $k . '][project_material_id]', null) !!}
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    {!! Form::text('materials[auxiliary][' . $k . '][consumption]', $material->info, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    {!! Form::text('materials[auxiliary][' . $k . '][price]', $material->price, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    {!! Form::text('materials[auxiliary][' . $k . '][necessary]', '', ['class' => 'form-control  output', 'disabled' => 'disabled', 'data-coefficient' => $material->coefficient]) !!}
                                </div>
                            </td>
                            <td class="lighter">
                                <div class="form-group">
                                    {!! Form::text('materials[auxiliary][' . $k . '][value]', '', ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            @endif
            </tbody>
        </table>
    </div>
@endif

@if ($project->has_sanding() || $project->has_painting())

    <h4>{{ trans('Materiale pentru vopsire') }}</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-calculation" id="paint-materials-table">
            <thead class="text-center">
            <tr>
                <th class="with-right-border">{{ trans('Componenta') }}</th>
                <th>{{ trans('Consum') }}</th>
                <th>{{ trans('Pret') }}</th>
                <th>{{ trans('Necesar') }}</th>
                <th class="lighter">{{ trans('Valoare') }} (&euro;)</th>
            </tr>
            </thead>
            <tbody>
            @if (!is_null($project->calculation) && isset($project->calculation->data->materials) && isset($project->calculation->data->materials->paint) && count($project->calculation->data->materials->paint) > 0 )
                @foreach ($project->calculation->data->materials->paint as $k => $material)
                    <tr>
                        <td>
                            <div class="form-group">
                                {!! Form::text('materials[paint][' . $k . '][name]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                                {!! Form::hidden('materials[paint][' . $k . '][project_material_id]', null) !!}
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                {!! Form::text('materials[paint][' . $k . '][consumption]', null, ['class' => 'form-control']) !!}
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                {!! Form::text('materials[paint][' . $k . '][price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                {!! Form::text('materials[paint][' . $k . '][necessary]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                            </div>
                        </td>
                        <td class="lighter">
                            <div class="form-group">
                                {!! Form::text('materials[paint][' . $k . '][value]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                            </div>
                        </td>

                    </tr>
                @endforeach
            @else
                @set ('paint_materials', App\Models\SettingsMaterial::where('type', 'paint')->get())
                @if (!is_null($paint_materials) && count($paint_materials) > 0)
                    @foreach ($paint_materials as $k => $material)
                        <tr>
                            <td>
                                <div class="form-group">
                                    {!! Form::text('materials[paint][' . $k . '][name]', $material->name, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                                    {!! Form::hidden('materials[paint][' . $k . '][project_material_id]', null) !!}
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    {!! Form::text('materials[paint][' . $k . '][consumption]', '', ['class' => 'form-control']) !!}
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    {!! Form::text('materials[paint][' . $k . '][price]', $material->price, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    {!! Form::text('materials[paint][' . $k . '][necessary]', '', ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                                </div>
                            </td>
                            <td class="lighter">
                                <div class="form-group">
                                    {!! Form::text('materials[paint][' . $k . '][value]', '', ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            @endif
            </tbody>
        </table>
    </div>

@endif

<div class="table-responsive">
    <table class="table table-bordered table-calculation" id="materials-totals-table">
        <tfoot>
        <tr>
            <td class="text-right" >{{ trans('Materiale principale') }}</td>
            <td><span class="materials-totals-main"></span></td>
        </tr>
        <tr>
            <td class="text-right" >{{ trans('Materiale auxiliare') }}</td>
            <td><span class="materials-totals-auxiliary"></span></td>
        </tr>
        <tr>
            <td class="text-right" >{{ trans('Materiale pentru vopsire') }}</td>
            <td><span class="materials-totals-paint"></span></td>
        </tr>
        <tr>
            <th class="row-title"><h4>{{ trans('Total') }}</h4></th>
            <th><h4 class="materials-total"></h4></th>
        </tr>
        </tfoot>
    </table>
</div>

<h4>{{ trans('Materiale montaj') }}</h4>
<div class="table-responsive">
    <table class="table table-bordered table-calculation" id="assembly-materials-table">
        <thead class="text-center">
        <tr>
            <th class="with-right-border" colspan="2">{{ trans('Material') }}</th>
            <th>{{ trans('Grupa') }}</th>
            <th>{{ trans('Standard') }}</th>
            <th>M</th>
            <th>{{ trans('Lungime') }} (m)</th>
            <th>{{ trans('Cantitate') }}</th>
            <th>{{ trans('Pret') }} (&euro;/{{ trans('buc') }})</th>
            <th>{{ trans('Pret') }} (&euro;)</th>
        </tr>
        </thead>
        <tbody>
        @if (!is_null($project->calculation) && isset($project->calculation->data->materials) && isset($project->calculation->data->materials->assembly) && count($project->calculation->data->materials->assembly) > 0 )
            @foreach ($project->calculation->data->materials->assembly as $k => $material)
                <tr>
                    <td class="paddingT0 paddingB0 paddingR10 valign-middle" width="21">{!! Form::checkbox('selected_materials[assembly][' . $k . ']', 1, false, ['class' => 'select marginT15'] ) !!}{!! Form::label('selected_materials[assembly]' . $k . ']', '&nbsp;', ['class' => 'marginB0 marginT10']) !!}</td>
                    <td class="with-right-border">
                        <div class="form-group">
                            {!! Form::text('materials[assembly][' . $k . '][name]', null, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                            {!! Form::hidden('materials[assembly][' . $k . '][project_material_id]', null) !!}
                        </div>
                        @if(\App\Models\SettingsMaterial::find($material->material->id)->in_stock->count() > 0)
                            <a class="info-icon-container stock-info-modal inline-block marginT15 marginL5" data-material-id="{{ $material->material->id }}" data-standard-id="{{ $material->standard->id }}" data-project-id="{{ $project->id }}"><i class="material-icons" data-toggle="tooltip" data-original-title="{{ trans('Rezervare din stock') }}">&#xE1BD;</i></a>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="form-group">
                            {!! Form::text('materials[assembly][' . $k . '][group]', (isset($material->group) ? $material->group : (isset($material->material) ? $material->material->material_group : '')), ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::text('materials[assembly][' . $k . '][quality]', null, ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::text('materials[assembly][' . $k . '][M]', (isset($material->M) ? $material->M : (isset($material->material) ? $material->material->M : '')), ['class' => 'form-control output', 'disabled' => 'disabled']) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::label('materials[assembly][' . $k . '][length]', trans('BRUT'), ['class'=> 'control-label']) !!}
                            {!! Form::number('materials[assembly][' . $k . '][length]', null, ['class' => 'form-control ', 'min' => '0', 'step' => "0.01"]) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::label('materials[assembly][' . $k . '][quantity]', trans('Bucăți'), ['class'=> 'control-label']) !!}
                            {!! Form::number('materials[assembly][' . $k . '][quantity]', null, ['class' => 'form-control ', 'min' => '0', 'step' => "0.01"]) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::label('materials[assembly][' . $k . '][price_per_piece]', 'EUR', ['class'=> 'control-label']) !!}
                            {!! Form::number('materials[assembly][' . $k . '][price_per_piece]', null, ['class' => 'form-control']) !!}
                            @if (!is_null($project->materials_offer))
                                @set ('offers', $project->materials_offer()->where('project_material_id', isset($material->project_material_id) ? $material->project_material_id : '')->get())
                                @if (count($offers) > 0)
                                    @set('prices_popover_content', '<table class="table-condensed">')
                                    @foreach ($offers as $offer)
                                        @if (!is_null($offer->offer_suppliers) && count($offer->offer_suppliers) > 0)
                                            @foreach ($offer->offer_suppliers as $offer_supplier)
                                                @set('prices_popover_content', $prices_popover_content . '<tr><td>' . $offer_supplier->supplier->name . '</td><td>' . $offer_supplier->price . '</td><td><a class="set-price" data-value="' . $offer_supplier->price . '" data-target="materials[assembly][' . $k . '][price_per_piece]">Selectează acest preț</a></td></tr>')
                                            @endforeach
                                        @endif
                                    @endforeach
                                    @set('prices_popover_content', $prices_popover_content . '</table>')

                                    <a class="view-prices marginT5 inline-block" data-toggle="popover"  tabindex="0" role="button" data-trigger="focus" data-placement="left" data-content='{!! $prices_popover_content !!}'><i class="material-icons">&#xE263;</i> {{ trans('prețuri') }}</a>
                                @endif
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::label('materials[assembly][' . $k . '][price]', trans('BRUT'), ['class'=> 'control-label output-label']) !!}
                            {!! Form::text('materials[assembly][' . $k . '][price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
        <tfoot>
        <tr>
            <th class="text-right" colspan="2" ><h4>{{ trans('Totaluri materiale montaj') }}</h4></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>{{ trans('Pret') }} (&euro;)</th>
        </tr>
        <tr>
            <td class="row-title" colspan="2">{{ strtoupper(trans('BRUT')) }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><span class="materials-assembly-total-price"></span></td>
        </tr>
        </tfoot>
    </table>
</div>

@section('content-scripts')
    @parent

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            /**
             * Stock info modal
             **/
            $(document).on('click', '.stock-info-modal', function(e){
                var material_id = $(this).attr('data-material-id');
                var standard_id = $(this).attr('data-standard-id');
                var project_id = $(this).attr('data-project-id');

                $.ajax({
                    url: '{{ action('InventoryController@getStock') }}',
                    type: 'POST',
                    data: {
                        material_id: material_id,
                        standard_id: standard_id,
                        project_id: project_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response){
                        $('#stock-info-content').html(response);
                        $('#stock-info-modal').modal();
                    }
                });
                e.preventDefault();
            });

            /**
             * Reserve stock modal
             **/
            $(document).on('click', '.reserve-stock', function (e) {
                var id = $(this).data('id');
                var project_id = $(this).data('project-id');
                $.ajax({
                    url: '{{ action('InventoryController@generateReserveStockModal') }}',
                    type: 'POST',
                    data: {
                        id: id,
                        project_id: project_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#reserve-stock-body').html(response);
                        $('#reserve-stock-modal').modal();
                    }
                });

                e.preventDefault();
            });
        });
    </script>
@endsection
