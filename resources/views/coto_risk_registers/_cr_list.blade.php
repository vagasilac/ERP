@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-striped" id="ru-table">
    <thead>
    <tr>
        <th></th>
        <th class="sortable text-left"><a data-field="name" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Proces') }}</a></th>
        <th class="sortable text-left"><a data-field="risk" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Risc') }}</a></th>
        <th class="sortable text-left"><a data-field="risk_likelihood" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_likelihood") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_likelihood")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Probabilitate') }}</a></th>
        <th class="sortable text-left"><a data-field="risk_occurrences" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_occurrences") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_occurrences")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Apariţie') }}</a></th>
        <th class="sortable text-left"><a data-field="risk_prob_rating" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_prob_rating") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_prob_rating")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Nota de probabilitate') }}</a></th>
        <th class="sortable text-left"><a data-field="risk_potential_loss_of_contracts" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_potential_loss_of_contracts") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_potential_loss_of_contracts")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Pierdere a contractelor') }}</a></th>
        <th class="sortable text-left"><a data-field="risk_potential_risk_to_human_health" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_potential_risk_to_human_health") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_potential_risk_to_human_health")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Risc potențial pentru sănătatea umană') }}</a></th>
        <th class="sortable text-left"><a data-field="risk_inability_to_meet_contract_terms" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_inability_to_meet_contract_terms") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_inability_to_meet_contract_terms")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Incapacitatea de a îndeplini condițiile contractuale') }}</a></th>
        <th class="sortable text-left"><a data-field="risk_potential_violation_of_regulations" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_potential_violation_of_regulations") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_potential_violation_of_regulations")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Încălcarea potențială a reglementărilor') }}</a></th>
        <th class="sortable text-left"><a data-field="risk_impact_on_company_reputation" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "irisk_mpact_on_company_reputation") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_impact_on_company_reputation")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Impact asupra reputației companiei') }}</a></th>
        <th class="sortable text-left"><a data-field="risk_est_cost_of_correction" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_est_cost_of_correction") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_est_cost_of_correction")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Costul corecției') }}</a></th>
        <th class="sortable text-left"><a data-field="risk_cons_rating" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_cons_rating") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "risk_cons_rating")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Nota de cons') }}</a></th>
        <th class="sortable text-left"><a data-field="mitigation_plan" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "mitigation_plan") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "mitigation_plan")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Metoda de atenuare') }}</a></th>
        <th class="sortable text-left"><a data-field="before_risk_factor" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "before_risk_factor") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "before_risk_factor")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Factor de risc') }}</a></th>

    </tr>
    </thead>
    <tbody>

    @if (count($items) > 0)
        @foreach ($items as $k => $item)
            <tr>
                <td class="paddingL0 paddingR0" @if ($item->mitigation_plan != '' || $item->document) rowspan="2" @endif>@if ($item->document) <i class="material-icons">&#xE24D;</i> @endif</td>
                <td @if ($item->mitigation_plan != '' || $item->document) rowspan="2" @endif><div class="user-tag-sm"><a href="{{ action('CotoRiskRegistersController@edit', $item->id) }}">{{ $item->name }}</a></div></td>
                <td @if ($item->mitigation_plan != '' || $item->document) rowspan="2" @endif>{{ $item->risk }}</td>
                <td>{{ trans((string)Config::get('coto.risk_registers.risk_likelihood.' . $item->risk_likelihood)) }}</td>
                <td>{{  trans((string)Config::get('coto.risk_registers.risk_occurrences.' . $item->risk_occurrences)) }}</td>
                <td>{{ $item->risk_prob_rating }}</td>
                <td>{{ trans((string)Config::get('coto.risk_registers.risk_potential_loss_of_contracts.' . $item->risk_potential_loss_of_contracts)) }}</td>
                <td>{{ trans((string)Config::get('coto.risk_registers.risk_potential_risk_to_human_health.' . $item->risk_potential_risk_to_human_health)) }}</td>
                <td>{{ trans((string)Config::get('coto.risk_registers.risk_inability_to_meet_contract_terms.' . $item->risk_inability_to_meet_contract_terms)) }}</td>
                <td>{{ trans((string)Config::get('coto.risk_registers.risk_potential_violation_of_regulations.' . $item->risk_potential_violation_of_regulations)) }}</td>
                <td>{{ trans((string)Config::get('coto.risk_registers.risk_impact_on_company_reputation.' . $item->risk_impact_on_company_reputation)) }}</td>
                <td>{{ trans((string)Config::get('coto.risk_registers.risk_est_cost_of_correction.' . $item->risk_est_cost_of_correction)) }}</td>
                <td>{{ $item->risk_cons_rating }}</td>
                <td @if ($item->before_risk_factor > 8) style="background-color: #e10909" @elseif ($item->before_risk_factor > 5) style="background-color: #ffe429" @else style="background-color: inherit" @endif>{{ $item->before_risk_factor }}</td>
                <td>{{ $item->mitigation_plan }}</td>
            </tr>
            @if ($item->mitigation_plan != '' || $item->document)
                <tr>
                    <td>{{ trans((string)Config::get('coto.risk_registers.mitigation_likelihood.' . $item->mitigation_likelihood)) }}</td>
                    <td>{{ trans((string)Config::get('coto.risk_registers.mitigation_occurrences.' . $item->mitigation_occurrences)) }}</td>
                    <td>{{ $item->mitigation_prob_rating }}</td>
                    <td>{{ trans((string)Config::get('coto.risk_registers.mitigation_potential_loss_of_contracts.' . $item->mitigation_potential_loss_of_contracts)) }}</td>
                    <td>{{ trans((string)Config::get('coto.risk_registers.mitigation_potential_risk_to_human_health.' . $item->mitigation_potential_risk_to_human_health)) }}</td>
                    <td>{{ trans((string)Config::get('coto.risk_registers.mitigation_inability_to_meet_contract_terms.' . $item->mitigation_inability_to_meet_contract_terms)) }}</td>
                    <td>{{ trans((string)Config::get('coto.risk_registers.mitigation_potential_violation_of_regulations.' . $item->mitigation_potential_violation_of_regulations)) }}</td>
                    <td>{{ trans((string)Config::get('coto.risk_registers.mitigation_impact_on_company_reputation.' . $item->mitigation_impact_on_company_reputation)) }}</td>
                    <td>{{ trans((string)Config::get('coto.risk_registers.mitigation_est_cost_of_correction.' . $item->mitigation_est_cost_of_correction)) }}</td>
                    <td>{{ $item->mitigation_cons_rating }}</td>
                    <td @if ($item->after_risk_factor > 8) style="background-color: #e10909" @elseif ($item->after_risk_factor > 5) style="background-color: #ffe429" @else style="background-color: inherit" @endif>{{ $item->after_risk_factor }}</td>
                    <td>{{ $item->mitigation_plan }}</td>
                </tr>
            @endif
        @endforeach
    @else
        <tr>
            <td colspan="13">{{ trans('Nu există înregistrări') }}</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="text-center">
    {!! $items->render() !!}
</div>
