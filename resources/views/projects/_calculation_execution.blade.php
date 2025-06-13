<h4>{{ trans('Manoperă') }}</h4>
@set ('operations', App\Models\ProjectCalculationsSetting::where('type', 'operation')->get())

<div class="table-responsive">
    <table class="table table-bordered table-condensed table-calculation" id="execution-operations-table">
        <thead class="text-center">
        <tr>
            <th class="with-right-border">{{ trans('Operație') }}</th>
            <th>{{ trans('Ore') }}</th>
            <th>{{ trans('Pret') }} (&euro;/{{ trans('ora') }})</th>
            <th>{{ trans('Total') }} (&euro;)</th>
            <th class="lighter">{{ trans('Ore') }}/t</th>
        </tr>
        </thead>
        <tbody>
        @if (count($operations) > 0)
            @foreach ($operations as $k => $operation)
                @if ($project->is_set($operation->slug))
                    <tr>
                        <td class="with-right-border">
                            <div class="form-group">
                                {!! Form::text('operations[' . $operation->id . '][name]', $operation->name, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                {!! Form::number('operations[' . $operation->id . '][hours]', null, ['class' => 'form-control']) !!}
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                {!! Form::text('operations[' . $operation->id . '][price]', $operation->value, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                {!! Form::text('operations[' . $operation->id . '][total_price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled', 'data-slug' => $operation->slug]) !!}
                            </div>
                        </td>
                        <td class="lighter">
                            <div class="form-group">
                                {!! Form::text('operations[' . $operation->id . '][hours_per_t]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
        @endif
        </tbody>
        <tfoot>
        <tr>
            <th><h4>{{ trans('Totaluri manoperă') }}</h4></th>
            <th>{{ trans('Ore') }}</th>
            <th></th>
            <th>{{ trans('Valoare') }} (&euro;)</th>
            <th></th>
        </tr>
        <tr>
            <td class="row-title">{{ strtoupper(trans('NET')) }}</td>
            <td><span class="execution-operations-total-hours"></span></td>
            <td></td>
            <td><span class="execution-operations-total-price"></span></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-condensed table-calculation" id="execution-labour-total-table">
        <tfoot>
        <tr>
            <td class="row-title">{{ trans('Manoperă om') }}</td>
            <td width="200"><span class="execution-workers-total" data-coefficient="{{ App\Models\ProjectCalculationsSetting::where('type', 'price')->where('slug', 'salary_per_hour')->first()->value }}"></span> (&euro;)</td>
        </tr>
        <tr>
            <td class="row-title">{{ trans('Amortisment utilaje') }}</td>
            <td><span class="execution-machinery-reduction-in-value"></span> (&euro;)</td>
        </tr>
        </tfoot>
    </table>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-condensed table-calculation" id="execution-on-black-table">
        <tfoot>
        <tr>
            <td class="row-title">{{ trans('Materiale') }}</td>
            <td width="200"><span class="execution-materials-total"></span> (&euro;)</td>
        </tr>
        <tr>
            <td class="row-title">{{ trans('Manoperă fabricație') }}</td>
            <td><span class="execution-operations-total"></span> (&euro;)</td>
        </tr>
        <tr>
            <th><h4>{{ trans('ON BLACK') }}</h4></th>
            <th><h4><span class="execution-on-black-total"></span> (&euro;)</h4></th>
        </tr>
        </tfoot>
    </table>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-condensed table-calculation" id="execution-paint-table">
        <tfoot>
        <tr>
            <td class="row-title">{{ trans('Materiale sablare-vopsire') }}</td>
            <td width="200"><span class="execution-paint-materials-total"></span> (&euro;)</td>
        </tr>
        <tr>
            <td class="row-title">{{ trans('Manoperă sablare-vopsire') }}</td>
            <td><span class="execution-paint-operations-total"></span> (&euro;)</td>
        </tr>
        <tr>
            <th><h4>{{ trans('TOTAL sablare-vopsire') }}</h4></th>
            <th><h4><span class="execution-paint-total"></span> (&euro;)</h4></th>
        </tr>
        </tfoot>
    </table>
</div>
<h4>{{ trans('Transport') }}</h4>
<div class="table-responsive">
    <table class="table table-bordered table-condensed table-calculation" id="transport-table">
        <thead class="text-center">
        <tr>
            <th>{{ trans('Nr. curse') }}</th>
            <th>{{ trans('Distanța') }} (km)</th>
            <th>{{ trans('Pret') }} (&euro;/km)</th>
            <th>{{ trans('Total') }} (&euro;)</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="form-group">
                    {!! Form::number('transport[no]', null, ['class' => 'form-control',]) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('transport[distance]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::number('transport[price]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group">
                    {!! Form::text('transport[total_price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>

@set ('exist_subcontractor_operations', 0)
@if (count($subcontractor_operations) > 0)
    @foreach ($subcontractor_operations as $k => $operation)
        @if ($project->is_set($operation['slug'] . '[type]') && $project->get_datasheet_variable_value($operation['slug'] . '[type]') == 1)
            @set ('exist_subcontractor_operations', 1)
        @endif
    @endforeach
@endif

@if ($exist_subcontractor_operations)
    <h4>{{ trans('Subcontractanți') }}</h4>
    @if (count($subcontractor_operations) > 0)
        @foreach ($subcontractor_operations as $k => $operation)
            @if ($project->is_set($operation['slug'] . '[type]') && $project->get_datasheet_variable_value($operation['slug'] . '[type]') == 1)
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-calculation subcontractor-table">
                        <thead class="text-center">
                        <tr class="gray">
                            <th colspan="3">{{ trans($operation['name']) }}</th>
                            <th colspan="3">{{ trans('Transport') }}</th>
                        </tr>
                        <tr>
                            <th>{{ trans('Greutate') }}</th>
                            <th>{{ trans('Pret') }} (&euro;/kg)</th>
                            <th class="with-right-border">{{ trans('Total') }} (&euro;)</th>
                            <th>{{ trans('Distanța') }} x 2 (km)</th>
                            <th>{{ trans('Pret') }} (&euro;/km)</th>
                            <th>{{ trans('Total') }} (&euro;)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="form-group">
                                    {!! Form::number('subcontractor[' . $k . '][weight]', null, ['class' => 'form-control',]) !!}
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    {!! Form::number('subcontractor[' . $k . '][price]', null, ['class' => 'form-control']) !!}
                                </div>
                            </td>
                            <td class="with-right-border">
                                <div class="form-group">
                                    {!! Form::text('subcontractor[' . $k . '][total_price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    {!! Form::number('subcontractor[' . $k . '][distance]', null, ['class' => 'form-control',]) !!}
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    {!! Form::number('subcontractor[' . $k . '][transport_price]', null, ['class' => 'form-control ']) !!}
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    {!! Form::text('subcontractor[' . $k . '][transport_total_price]', null, ['class' => 'form-control  output', 'disabled' => 'disabled']) !!}
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach
    @endif
    <div class="table-responsive">
        <table class="table table-bordered table-condensed table-calculation">
            <tfoot>
            @if (count($subcontractor_operations) > 0)
                @foreach ($subcontractor_operations as $k => $operation)
                    @if ($project->is_set($operation['slug'] . '[type]') && $project->get_datasheet_variable_value($operation['slug'] . '[type]') == 1)
                        <tr>
                            <td class="row-title">{{ trans($operation['name']) }} ({{ trans('transport inclus') }})</td>
                            <td><span class="subcontractor-operation-total" data-id="{{ $k }}">2700</span> (&euro;)</td>
                        </tr>
                    @endif
                @endforeach
            @endif
            <tr>
                <th><h4>{{ trans('Total') }}</h4></th>
                <th><h4><span class="subcontractors-operations-total"></span>(&euro;)</h4></th>
            </tr>
            </tfoot>
        </table>
    </div>
@endif

<div class="table-responsive">
    <table class="table table-bordered table-condensed table-calculation">
        <tfoot>
        <tr>
            <td class="row-title">{{ trans('Total fabricat-vopsit') }}</td>
            <td><span id="execution-total"></span> (&euro;)</td>
        </tr>
        <tr>
            <td class="row-title">+ {{ trans('Cheltuieli indirecte') }} 15%</td>
            <td><span id="execution-total-with-indirect-expences" data-coefficient="{{ App\Models\ProjectCalculationsSetting::where('type', 'price')->where('slug', 'overheads')->first()->value }}"></span> (&euro;)</td>
        </tr>
        <tr>
            <td class="row-title">+ {{ trans('Profit') }} 10%</td>
            <td><span id="execution-total-profit" data-coefficient="{{ App\Models\ProjectCalculationsSetting::where('type', 'price')->where('slug', 'profit')->first()->value }}"></span> (&euro;)</td>
        </tr>
        <tr>
            <td class="row-title">{{ trans('Total fabricat + cheltuieli indirecte + profit') }}</td>
            <td><span id="execution-total-with-profit"></span> (&euro;)</td>
        </tr>
        <tr>
            <th><h4>{{ trans('Total (cu transport)') }}</h4></th>
            <th><h4><span id="execution-total-with-transport"></span>(&euro;)</h4></th>
        </tr>
        </tfoot>
    </table>
</div>