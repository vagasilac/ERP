@extends('app')

@section('title') {{ trans('Reclamații') }} <a href="{{ /*action('ComplaintsController@create')*/'#' }}" class="action pull-right"><i class="fa fa-plus"></i> {{ trans('Adăugare') }}</a> @endsection

@section('content')
    <div class="content-fluid">
        <div class="table-responsive marginT30 list-container">
            <table class="table table-striped" id="capa-table">
                <thead>
                <tr>
                    <th class="sortable text-left" rowspan="2"><a data-field="id" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "id") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "id")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('ID') }}</a></th>
                    <th class="sortable text-left" rowspan="2"><a data-field="date" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "date") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "date")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Data') }}</a></th>
                    <th class="sortable text-left" rowspan="2"><a data-field="customer" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "customer") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "customer")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Reclamant') }}</a></th>
                    <th class="sortable text-left" rowspan="2"><a data-field="related_project" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "related_project") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "related_project")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Legat de proiect') }}</a></th>
                    <th class="sortable text-left" rowspan="2"><a data-field="description" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "description") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "description")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Descriere reclamație') }}</a></th>
                    <th class="sortable text-left" rowspan="2"><a data-field="solution" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "solution") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "solution")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Mod de rezolvare') }}</a></th>
                    <th class="text-center" colspan="4">{{ trans('Reclamație')  }}</th>
                    <th class="sortable text-left" rowspan="2"><a data-field="person_takeover" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "person_takeover") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "person_takeover")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('Cine a preluat reclamația') }}</a></th>
                </tr>
                <tr>
                    <th class="sortable text-left"><a data-field="status_reasoned" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "status_reasoned") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "status_reasoned")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('întemeiată') }}</a></th>
                    <th class="sortable text-left"><a data-field="status_unreasoned" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "status_unreasoned") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "status_unreasoned")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('neîntemeiată') }}</a></th>
                    <th class="sortable text-left"><a data-field="claim" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "claim") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "claim")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('sesizare') }}</a></th>
                    <th class="sortable text-left"><a data-field="acp_nr" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "acp_nr") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "acp_nr")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif {{ trans('nr. ACP') }}</a></th>
                </tr>
                </thead>
                <tbody>

                @if (count($items) > 0)
                    @foreach ($items as $k => $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                            <td><div class="user-tag-sm"><a href="{{ action('CustomersController@show', $item->customer->id) }}">@if ($item->customer->logo != '')<img src="{{ action('FilesController@image', base64_encode('customers/thumbs/' . $item->customer->logo)) }}" alt="{{ $item->customer->name }}" />@else <img src="{{ asset('img/placeholder-company-profile.png') }}" alt="{{ $item->customer->name }}" /> @endif {{ $item->customer->name }}</a></div></td>
                            <td>{{ $item->related_project }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->solution }}</td>
                            <td class="text-center">{{ $item->status_reasoned ? '&times;' : '' }}</td>
                            <td class="text-center">{{ $item->status_unreasoned ? '&times;' : '' }}</td>
                            <td class="text-center">{{ $item->claim ? '&times;' : '' }}</td>
                            <td class="text-center">{{ $item->acp_no }}</td>
                            <td><div class="user-tag-sm" data-toggle="tooltip" title="{{ $item->person_takeover->lastname }} {{ $item->person_takeover->firstname }}"><a href="{{ action('UsersController@show', $item->person_takeover->id) }}">@if ($item->person_takeover->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $item->person_takeover->photo)) }}" alt="{{ $item->person_takeover->lastname }} {{ $item->person_takeover->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($item->person_takeover->id % count($colors)) + 1]) ? $colors[($item->person_takeover->id % count($colors)) + 1] : '' }}">{{ substr($item->person_takeover->lastname, 0, 1) }}{{ substr($item->person_takeover->firstname, 0, 1) }}</span>@endif {{ substr($item->person_takeover->firstname, 0, 1) }}</a></div></td>
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