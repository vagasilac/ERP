@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-striped" id="ru-table">
    <thead>
    <tr>
        <th></th>
        <th class="sortable text-left"><a data-field="name" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Proces') }}</a></th>
        <th class="sortable text-left"><a data-field="opportunity" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "opportunity") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "opportunity")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Oportunitate') }}</a></th>
        <th class="sortable text-left"><a data-field="likelihood" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "likelihood") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "likelihood")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Probabilitate') }}</a></th>
        <th class="sortable text-left"><a data-field="occurrences" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "occurrences") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "occurrences")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Apariţie') }}</a></th>
        <th class="sortable text-left"><a data-field="prob_rating" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "prob_rating") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "prob_rating")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Nota de probabilitate') }}</a></th>
        <th class="sortable text-left"><a data-field="potential_for_new_business" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "potential_for_new_business") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "potential_for_new_business")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Posibilitate de afacere nouă') }}</a></th>
        <th class="sortable text-left"><a data-field="potential_expansion_of_current_business" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "potential_expansion_of_current_business") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "potential_expansion_of_current_business")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Extinderea afacerii existente') }}</a></th>
        <th class="sortable text-left"><a data-field="potential_improvement_in_satisfying_regulations" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "potential_improvement_in_satisfying_regulations") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "potential_improvement_in_satisfying_regulations")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Dezvoltarea potențială a capacităților de conformare la cerințele legislative') }}</a></th>
        <th class="sortable text-left"><a data-field="potential_improvement_to_internal_qms_processes" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "potential_improvement_to_internal_qms_processes") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "potential_improvement_to_internal_qms_processes")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Dezvoltarea potențială a SMI') }}</a></th>
        <th class="sortable text-left"><a data-field="improvement_to_company_reputation" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "improvement_to_company_reputation") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "improvement_to_company_reputation")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Îmbunătățirea reputației organizației') }}</a></th>
        <th class="sortable text-left"><a data-field="potential_cost_of_implementation" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "potential_cost_of_implementation") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "potential_cost_of_implementation")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Costul estimat de implementare') }}</a></th>
        <th class="sortable text-left"><a data-field="ben_rating" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "ben_rating") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "ben_rating")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Nota de beneficiu') }}</a></th>
        <th class="sortable text-left"><a data-field="opp_factor" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "opp_factor") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "opp_factor")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Factor de oportunitate') }}</a></th>
        <th class="sortable text-left"><a data-field="opportunity_pursuit_plan" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "opportunity_pursuit_plan") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "opportunity_pursuit_plan")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Plan de urmărire a oportunităților') }}</a></th>
        <th class="sortable text-left"><a data-field="post_implementation_success" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "post_implementation_success") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "post_implementation_success")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Post succes de implementare') }}</a></th>
        <th class="sortable text-left"><a data-field="status" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "status") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "status")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Stare') }}</a></th>
    </tr>
    </thead>
    <tbody>

    @if (count($items) > 0)
        @foreach ($items as $k => $item)
            <tr>
                <td class="paddingL0 paddingR0">@if ($item->document) <i class="material-icons">&#xE24D;</i> @endif</td>
                <td><div class="user-tag-sm"><a href="{{ action('CotoOpportunityRegistersController@edit', $item->id) }}">{{ $item->name }}</a></div></td>
                <td>{{ $item->opportunity }}</td>
                <td>{{ trans((string)Config::get('coto.opportunity_registers.likelihood.' . $item->likelihood)) }}</td>
                <td>{{ trans((string)Config::get('coto.opportunity_registers.occurrences.' . $item->occurrences)) }}</td>
                <td>{{ $item->prob_rating }}</td>
                <td>{{ trans((string)Config::get('coto.opportunity_registers.potential_for_new_business.' . $item->potential_for_new_business)) }}</td>
                <td>{{ trans((string)Config::get('coto.opportunity_registers.potential_expansion_of_current_business.' . $item->potential_expansion_of_current_business)) }}</td>
                <td>{{ trans((string)Config::get('coto.opportunity_registers.potential_improvement_in_satisfying_regulations.' . $item->potential_improvement_in_satisfying_regulations)) }}</td>
                <td>{{ trans((string)Config::get('coto.opportunity_registers.potential_improvement_to_internal_qms_processes.' . $item->potential_improvement_to_internal_qms_processes)) }}</td>
                <td>{{ trans((string)Config::get('coto.opportunity_registers.improvement_to_company_reputation.' . $item->improvement_to_company_reputation)) }}</td>
                <td>{{ trans((string)Config::get('coto.opportunity_registers.potential_cost_of_implementation.' . $item->potential_cost_of_implementation)) }}</td>
                <td>{{ $item->ben_rating }}</td>
                <td @if ($item->opp_factor > 8) style="background-color: #35c500" @else style="background-color: initial" @endif>{{ $item->opp_factor }}</td>
                <td>{{ $item->opportunity_pursuit_plan }}</td>
                <td>{{ trans((string)Config::get('coto.opportunity_registers.post_implementation_success.' . $item->post_implementation_success)) }}</td>
                <td>{{ trans((string)Config::get('coto.opportunity_registers.status.' . $item->status)) }}</td>
            </tr>
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
