@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-bordered table-calculation table-materials" id="materials-table">
    <thead>
    <tr>
        <th width="40" rowspan="2" colspan="2">
            <div class="checkbox-inline">
                {!! Form::checkbox('select_all' , 1, false, ['class' => 'select'] ) !!}{!! Form::label('select_all', '&nbsp;', ['class' => 'marginB0']) !!}
            </div>
        </th>
        <th rowspan="2" width="190">{{ trans('Status') }}</th>
        <th rowspan="2">{{ trans('Denumire') }}</th>
        <th colspan="2">{{ trans('Calitate') }}</th>
        <th rowspan="2">{{ trans('Cod producție') }}</th>
        <th rowspan="2">{{ trans('Data') }}</th>
        <th class="text-center" rowspan="2">{{ trans('Cantitate în stoc') }}</th>
        <th class="text-center" rowspan="2">{{ trans('Cerere') }}</th>
        <th class="text-center" rowspan="2">{{ trans('Cantitate necesară') }}</th>
        <th colspan="3">{{ trans('Preț unitar') }}</th>
        <th rowspan="2">{{ trans('Nr. COM.') }}</th>
        <th rowspan="2">{{ trans('Furnizor aprobat') }}</th>
        <th rowspan="2">{{ trans("Acțiuni") }}</th>
    </tr>
    <tr>
        <th class="text-center">{{ 'Cerută' }}</th>
        <th class="text-center">{{ 'Certificată' }}</th>
        <th class="text-center">{{ trans('Min.') }}</th>
        <th class="text-center">{{ trans('Max.') }}</th>
        <th class="text-center">{{ trans('Comanda') }}</th>
    </tr>
    </thead>
    <tbody>
        @foreach($project_materials as $index=>$pm)
            @php
                $next = $index + 1;
                $prev = $index - 1;
                $nextMaterial = $project_materials[$next];
                $prevMaterial = $project_materials[$prev];
                if($nextMaterial){
                    if($nextMaterial['material_id'] == $pm->material_id && $nextMaterial['standard_id'] == $pm->standard_id){
                        $sameMaterial = true;
                    }
                    else{
                        $sameMaterial = false;
                    }

                }
                else{
                    $sameMaterial = false;
                }
                if (isset($project_materials_summaries[$pm->material_id . '-' . $pm->standard_id . '-' . $pm->project_id])) {
                    $summary = $project_materials_summaries[$pm->material_id . '-' . $pm->standard_id . '-' . $pm->project_id];
                }
                else {
                    $summary = [];
                }
            @endphp
            @if(((($lastStandard === false || $lastStandard != $pm->standard_id) || ($lastMaterial === false || $lastMaterial != $pm->material_id)) && $sameMaterial))
                <tr class="parent first-level">
                    <td colspan="2">{!! Form::checkbox('select_'.$pm->id , '', false, ['class' => 'select-parent', 'data-children' => 'p'.$pm->material_id.'-'.$pm->standard_id] ) !!}{!! Form::label('select_'.$pm->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                    <td></td>
                    <td>{{ $pm->material_info->name }}</td>
                    <td>@if (!is_null($pm->standard)) @if($pm->standard->EN) {{ $pm->standard->EN }} @elseif($pm->standard->DIN_SEW) {{ $pm->standard->DIN_SEW }}@endif @endif</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center nowrap">
                        {{ $pm->material_info->in_stock->sum('quantity') }} @if($pm->material_info->in_stock->count() > 1)buc.@elseif($pm->material_info->in_stock->count() == 1 && $pm->material_info->in_stock->first()->pieces > 1) buc. @else {{ $pm->material_info->unit }} @endif
                    </td>
                    <td class="text-center">
                        {{ number_format( (float) $sum[$pm->material_id][$pm->standard_id], 2, '.', '') }} {{ $pm->material_info->unit }}
                    </td>
                    <td class="text-center">
                        @if($sum[$pm->material_id][$pm->standard_id] - $pm->material_info->in_stock->sum('quantity') > 0)
                            <strong class="text-success">+{{$sum[$pm->material_id][$pm->standard_id] - $pm->material_info->in_stock->sum('quantity')}}</strong>
                        @else
                            <strong class="text-muted">{{ $sum[$pm->material_id][$pm->standard_id] - $pm->material_info->in_stock->sum('quantity') }}</strong>
                        @endif
                        {{ $pm->material_info->unit }}
                    </td>
                    <td colspan="6"></td>
                </tr>
            @endif

            @if(((($lastStandard === false || $lastStandard != $pm->standard_id) || ($lastMaterial === false || $lastMaterial != $pm->material_id)) && $sameMaterial) || ($prevMaterial && $prevMaterial['project_id'] != $pm->project_id))
                @if (isset($project_materials_summaries[$pm->material_id . '-' . $pm->standard_id . '-' . $pm->project_id]))
                    <tr class="child second-level">
                        <td class="paddingR5" width="80">{!! Form::checkbox('select_'.$pm->id , '', false, ['class' => 'select-parent p'.$pm->material_id.'-'.$pm->standard_id, 'data-children' => 'p'.$pm->material_id.'-'.$pm->standard_id.'-'.$pm->project_id] ) !!}{!! Form::label('select_'.$pm->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                        <td class="padding0"><div data-toggle="tooltip" title="{{ trans('Arată în detaliu') }}"><a href=".third-level-{{$pm->material_id}}-{{$pm->standard_id}}-{{$pm->project_id}}" data-toggle="collapse" class="collapsed show-details"><i class="material-icons show-icon">&#xE313;</i><i class="material-icons hide-icon">&#xE316;</i></a></div></td>
                        <td class="nowrap">
                            @if (isset($summary['statuses']) && count($summary['statuses']) > 0)
                                @foreach ($summary['statuses'] as $status)
                                    <span class="status marginR5" style="background-color: {{$status_colors[$status] }}" data-toggle="tooltip" title="{{ trans($purchasing_statuses[$status]) }}">
                                        {{ trans($purchasing_short_statuses[$status]) }}
                                    </span>
                                @endforeach
                            @endif
                            @if ($pm->order_request == 1 && (!$pm->offer || !in_array($pm->offer->status, ['order_sent', 'production', 'stock'])))
                                <span class="cursor-default shop-icon" data-toggle="tooltip" title="{{ trans('Poate fi comandat') }}"><i class="material-icons">&#xE854;</i></span>
                            @endif
                        </td>
                        <td>
                            {{ $summary['material_info']['name'] }}
                        </td>
                        <td>@if (!is_null($pm->standard)) @if($summary['standard']['EN']) {{ $summary['standard']['EN'] }} @elseif($summary['standard']['DIN_SEW']) {{ $summary['standard']['DIN_SEW'] }}@endif @endif</td>
                        <td></td>
                        <td class="text-center"><span class="cursor-default" data-toggle="tooltip" title="{{ sprintf("%02d", $pm->project->primary_code) }}.{{ sprintf("%02d", $pm->project->secondary_code) }}. {{ $pm->project->name }} {{ date('d.m.Y', strtotime($pm->project->created_at)) }}">{{ $pm->project->production_name() }}</span></td>
                        <td></td>
                        <td class="text-center nowrap">
                            {{ $pm->material_info->in_stock->sum('quantity') }} @if($pm->material_info->in_stock->count() > 1)buc.@elseif($pm->material_info->in_stock->count() == 1 && $pm->material_info->in_stock->first()->pieces > 1) buc. @else {{ $pm->material_info->unit }} @endif
                        </td>
                        <td class="text-center">
                            @if (count($summary['gross_info'] > 0))
                                <span class="custom-label">{{ trans('BRUT') }}:</span> {{ $summary['quantity'] }}{{ $pm->material_info->unit }} @if ($summary['quantity'] != 0)= @endif
                                @set ('iteration', 0)
                                @foreach ($summary['gross_info'] as $item)
                                    @if ($iteration != 0) + @endif {{ $item['pieces'] }} * @if ($summary['material_type'] == 'plate')({{ $item['size'] }} = @endif {{ $item['quantity'] }} {{ $pm->material_info->unit }}@if ($summary['material_type'] == 'plate')) @endif
                                    @set ('iteration', $iteration + 1)
                                @endforeach
                            @endif
                            <br>
                            @if (count($summary['net_info'] > 0))
                                <span class="custom-label">{{ trans('NET') }}:</span> {{ $summary['net_quantity'] }}{{ $pm->material_info->unit }} @if ($summary['net_quantity'] != 0)= @endif
                                @set ('iteration', 0)
                                @foreach ($summary['net_info'] as $item)
                                    @if ($iteration != 0) + @endif {{ $item['pieces'] }} * @if ($summary['material_type'] == 'plate')({{ $item['size'] }} = @endif {{ $item['quantity'] }} {{ $pm->material_info->unit }}@if ($summary['material_type'] == 'plate')) @endif
                                    @set ('iteration', $iteration + 1)
                                @endforeach
                            @endif
                        </td>
                        <td class="text-center">
                            @if($summary['quantity'] - $pm->material_info->in_stock->sum('quantity') > 0)
                                <strong class="text-success">+{{$summary['quantity'] - $pm->material_info->in_stock->sum('quantity')}}</strong>
                            @else
                                <strong class="text-muted">{{ $summary['quantity'] - $pm->material_info->in_stock->sum('quantity') }}</strong>
                            @endif
                            {{ $pm->material_info->unit }}
                        </td>
                        <td colspan="6"></td>
                    </tr>
                @endif
            @endif

            @if(((($lastStandard === false || $lastStandard != $pm->standard_id) || ($lastMaterial === false || $lastMaterial != $pm->material_id) || (isset($is_utilizat[$pm->material_id][$pm->standard_id]) && $is_utilizat[$pm->material_id][$pm->standard_id] === true)) && $sameMaterial))
                @php
                $lastStandard = $pm->standard_id;
                $lastMaterial = $pm->material_id;
                @endphp
            @endif

            @if(($lastStandard == $pm->standard_id && $lastMaterial == $pm->material_id) || ($lastStandard == false && $lastMaterial == false && $sameMaterial))
                @if($pm->offer)
                    @if($pm->offer->status == 'stock')
                        <tr class="child utilizat{{$pm->material_id}}{{$pm->standard_id}} used-row collapse third-level">
                    @else
                        <tr class="child third-level third-level-{{$pm->material_id}}-{{$pm->standard_id}}-{{$pm->project_id}} collapse">
                    @endif
                @else
                    <tr class="child third-level third-level-{{$pm->material_id}}-{{$pm->standard_id}}-{{$pm->project_id}} collapse">
                @endif
            @else
                <tr class="first-level">
            @endif
            <td colspan="2">
                @if(!$pm->offer || $pm->offer->status != 'stock')
                    @if($pm->canceled != 1)
                    {!! Form::checkbox('select_'.$pm->id , '', false, ['class' => 'select p'.$pm->material_id.'-'.$pm->standard_id.' p'.$pm->material_id.'-'.$pm->standard_id.'-'.$pm->project_id, 'data-id' => $pm->id, 'data-status' => $pm->offer ? $pm->offer->status : 'necesar'] ) !!}{!! Form::label('select_'.$pm->id, '&nbsp;', ['class' => 'marginB0']) !!}

                    @endif
                @endif
            </td>
            <td class="nowrap">
                <span class="status marginR5" style="background-color: @if($pm->offer){{ $status_colors[$pm->offer->status] }}@elseif($pm->canceled == 1){{ $status_colors['canceled'] }}@else{{ $status_colors['required'] }}@endif">
                    @if($pm->offer)
                        @if($pm->offer->status == 'offer_sent')
                            {{ trans('Cerere de ofertă trimisă') }}
                        @elseif($pm->offer->status == 'offer_received')
                            {{ trans('Ofertă primită') }}
                        @elseif($pm->offer->status == 'order_sent')
                            {{ trans("Comandă trimisă") }}
                        @elseif($pm->offer->status == 'production')
                            {{ trans("În producție") }}
                        @else($pm->offer->status == 'stock')
                            {{ trans("Utilizat") }}
                        @endif
                    @else
                        @if($pm->canceled == 1)
                            {{ trans('Anulat') }}
                        @else
                            {{ trans('Necesar') }}
                        @endif
                    @endif
                </span>
                @if ($pm->order_request == 1 && (!$pm->offer || !in_array($pm->offer->status, ['order_sent', 'production', 'stock'])))
                    <span class="cursor-default shop-icon" data-toggle="tooltip" title="{{ trans('Poate fi comandat') }}"><i class="material-icons">&#xE854;</i></span>
                @endif
            </td>
            <td>{{ $pm->material_info->name }}</td>
            <td>@if (!is_null($pm->standard)) @if($pm->standard->EN) {{ $pm->standard->EN }} @elseif($pm->standard->DIN_SEW) {{ $pm->standard->DIN_SEW }}@endif @endif</td>
            <td>@if (!is_null($pm->certificate)) @if($pm->certificate->EN) {{ $pm->certificate->EN }} @elseif($pm->certificate->DIN_SEW) {{ $pm->certificate->DIN_SEW }}@endif @endif</td>
            <td class="text-center"><span class="cursor-default" data-toggle="tooltip" title="{{ sprintf("%02d", $pm->project->primary_code) }}.{{ sprintf("%02d", $pm->project->secondary_code) }}. {{ $pm->project->name }} {{ date('d.m.Y', strtotime($pm->project->created_at)) }}">{{ $pm->project->production_name() }}</span>  @php /* <a class="info-icon-container demand-info-open" data-id="{{ $pm->id }}"><i class="material-icons">&#xE88F;</i></a> */ @endphp</td>
            <td class="nowrap">
                @if($pm->offer)
                    @if($pm->offer->status == 'offer_sent')
                        <span class="custom-label">{{ trans('Data cererii') }}</span><br>{{ $pm->offer->created_at->format('d-m-Y') }}
                    @elseif($pm->offer->status == 'offer_received')
                        <span class="custom-label marginR5">{{ trans('Data ofertei') }}</span>
                        <a class="info-icon-container" data-toggle="tooltip" title="@foreach($pm->offer->offer_suppliers_received as $of)  {{ $of->offer_received_at }} - {{ $of->supplier->name }} <br/ > @endforeach"><i class="material-icons">&#xE88F;</i></a>
                    @elseif($pm->offer->status == 'order_sent')
                        <span class="custom-label">{{ trans('Data comenzii') }}</span><br>{{ date('d-m-Y', strtotime($pm->offer->date_ordered)) }}
                    @elseif($pm->offer->status == 'production')
                        <span class="custom-label">{{ trans('Data recepției') }}</span><br>{{ date('d-m-Y', strtotime($pm->offer->date_received)) }}
                    @elseif($pm->offer->status == 'stock')
                        <span class="custom-label">{{ trans('Data restituirii') }}</span><br/>{{ date('d-m-Y', strtotime($pm->offer->date_stocked)) }}
                    @endif
                @elseif($pm->canceled != 1)
                    <span class="custom-label">{{ trans('Data scadentă') }}</span><br>{{ $pm->project_deadline() }}
                @endif
            </td>
            @if(!isset($is_utilizat[$pm->material_id][$pm->standard_id]) || $is_utilizat[$pm->material_id][$pm->standard_id] !== true)
            <td class="text-center nowrap">
                {{ $pm->material_info->in_stock->sum('quantity') }} @if($pm->material_info->in_stock->count() > 1)buc.@elseif($pm->material_info->in_stock->count() == 1 && $pm->material_info->in_stock->first()->pieces > 1) buc. @else {{ $pm->material_info->unit }} @endif
            </td>
            @else
            <td></td>
            @endif
            @if(!$pm->offer || $pm->offer->status != 'stock')
                <td class="text-center">
                    @if (count($summary) > 0 && !(($lastStandard == $pm->standard_id && $lastMaterial == $pm->material_id) || ($lastStandard == false && $lastMaterial == false && $sameMaterial)))
                        @if (count($summary['gross_info'] > 0))
                            <span class="custom-label">{{ trans('BRUT') }}:</span> {{ $summary['quantity'] }}{{ $pm->material_info->unit }} =
                            @set ('iteration', 0)
                            @foreach ($summary['gross_info'] as $item)
                                @if ($iteration != 0) + @endif {{ $item['pieces'] }} * @if ($summary['material_type'] == 'plate')({{ $item['size'] }} = @endif {{ $item['quantity'] }} {{ $pm->material_info->unit }}@if ($summary['material_type'] == 'plate')) @endif
                                @set ('iteration', $iteration + 1)
                            @endforeach
                        @endif
                        <br>
                        @if (count($summary['net_info'] > 0))
                            <span class="custom-label">{{ trans('NET') }}:</span> {{ $summary['net_quantity'] }}{{ $pm->material_info->unit }} =
                            @set ('iteration', 0)
                            @foreach ($summary['net_info'] as $item)
                                @if ($iteration != 0) + @endif {{ $item['pieces'] }} * @if ($summary['material_type'] == 'plate')({{ $item['size'] }} = @endif {{ $item['quantity'] }} {{ $pm->material_info->unit }}@if ($summary['material_type'] == 'plate')) @endif
                                @set ('iteration', $iteration + 1)
                            @endforeach
                        @endif
                    @else
                        {{ $pm->quantity }} {{ $pm->material_info->unit }}
                    @endif
                </td>
            @else
                <td class="text-center">0</td>
            @endif

            <td class="text-center">
                @if(!$pm->offer || $pm->offer->status != 'stock')
                    @if($pm->quantity - $pm->material_info->in_stock->sum('quantity') > 0)
                        <strong class="text-success">+{{$pm->quantity - $pm->material_info->in_stock->sum('quantity')}}</strong>
                    @else
                        <strong class="text-muted">{{ $pm->quantity - $pm->material_info->in_stock->sum('quantity') }}</strong>
                    @endif
                @else
                    <strong class="text-muted">0</strong>
                @endif
                {{ $pm->material_info->unit }}
            </td>
            <td>
                @if($pm->offer)
                    @if($pm->offer->status == 'offer_received' || $pm->offer->status == 'order_sent' || $pm->offer->status == 'production')
                        @if($pm->offer->offer_suppliers->count() > 0)
                            {{$pm->offer->offer_suppliers->min('price')}} EUR
                        @endif
                    @endif
                @endif
            </td>
            <td>
                @if($pm->offer)
                    @if($pm->offer->status == 'offer_received' || $pm->offer->status == 'order_sent' || $pm->offer->status == 'production')
                        @if($pm->offer->offer_suppliers->count() > 0)
                            {{$pm->offer->offer_suppliers->max('price')}} EUR
                        @endif
                    @endif
                @endif
            </td>
            <td>
                @if($pm->offer)
                    @if($pm->offer->status == 'order_sent' || $pm->offer->status == 'production')
                        @if($pm->offer->offer_supplier_accepted->count() > 0)
                        {{$pm->offer->offer_supplier_accepted->first()->price}} EUR
                        @endif
                    @endif
                @endif
            </td>
            <td>
                @if($pm->offer)
                    @if($pm->offer->ioOrder)
                        {{$pm->offer->ioOrder->number}}/{{date('d.m.Y', strtotime($pm->offer->ioOrder->date)) }}
                    @endif
                @endif
            </td>
            <td>
                @if($pm->offer)
                    @if($pm->offer->status == 'production' || $pm->offer->status == 'stock' || $pm->offer->status == 'order_sent')
                        @if($pm->offer->supplier)
                            {{ $pm->offer->supplier->name }}
                        @else
                             <span class="nowrap">{{ trans('din stoc') }}</span>
                        @endif
                    @endif
                @endif
            </td>
            <td>
                @if($pm->offer)
                    @if($pm->offer->status == 'offer_sent' || $pm->offer->status == 'offer_received')
                        <a class="btn btn-xs btn-success offer-received" data-id="{{ $pm->id }}">{{ trans('Editare prețuri') }}</a>
                    @elseif($pm->offer->status == 'production')
                        <a class="btn btn-xs btn-success marginR10 register-stock marginB5" data-id="{{ $pm->id }}">{{ trans('Înregistrare în stoc') }} </a>
                        <a class="btn btn-xs btn-success ctc-btn" data-id="{{ $pm->offer->id }}">{{ trans("Date CTC") }}</a>
                    @endif
                @endif
            </td>
        </tr>
        @if(isset($is_utilizat[$pm->material_id][$pm->standard_id]) && $is_utilizat[$pm->material_id][$pm->standard_id] === true && ($nextMaterial && $nextMaterial->offer && $nextMaterial->offer->status == 'stock') && (!$prevMaterial || !$prevMaterial->offer || ($prevMaterial && $prevMaterial->offer && $prevMaterial->offer->status != 'stock')))
            <tr class="child third-level third-level-{{$pm->material_id}}-{{$pm->standard_id}}-{{$pm->project_id}} collapse show-row">
                <td colspan="20"><a href=".utilizat{{$pm->material_id}}{{$pm->standard_id}}" data-toggle="collapse" class="collapsed show-hidden-rows">{{ trans('Materiale utilizate') }} <i class="material-icons show-icon">&#xE313;</i><i class="material-icons hide-icon">&#xE316;</i></a></td>
            </tr>
        @endif
        @php
            $lastStandard = $pm->standard_id;
            $lastMaterial = $pm->material_id;
        @endphp
        @endforeach
        </tbody>
    </table>
<div class="text-center">
    {!! $project_materials->render() !!}
</div>
