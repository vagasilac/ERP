@if ( app('request')->input('sort') != '')
@set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-striped" id="customers-table">
    <thead>
    <tr>
        <th width="40">
            <div class="checkbox-inline">
                {!! Form::checkbox('select_all' , 1, false, ['class' => 'select'] ) !!}{!! Form::label('select_all', '&nbsp;', ['class' => 'marginB0']) !!}
            </div>
        </th>
        <th class="sortable"><a data-field="name" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Denumire') }}</a></th>
        <th class="sortable"><a data-field="short_name" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "short_name") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "short_name")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Denumire scurtă') }}</a></th>
        <th class="sortable"><a data-field="vat_number" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "vat_number") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "vat_number")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('CUI') }}</a></th>
        <th class="sortable"><a data-field="company_number" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "company_number") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "company_number")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Nr. registrul comerțului') }}</a></th>
        <th class="sortable"><a data-field="office_email" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "office_email") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "office_email")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('E-mail') }}</a></th>
        <th class="sortable"><a data-field="office_phone" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "office_phone") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "office_phone")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Telefon') }}</a></th>
    </tr>
    </thead>
    <tbody>

    @if (count($customers) > 0)
        @foreach ($customers as $k => $customer)
            <tr>
                <td>{!! Form::checkbox('select_' . $customer->id , $customer->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $customer->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                <td><div class="user-tag-sm"><a href="{{ action('CustomersController@edit', $customer->id) }}">@if ($customer->logo != '')<img src="{{ action('FilesController@image', base64_encode('customers/thumbs/' . $customer->logo)) }}" alt="{{ $customer->name }}" />@else <img src="{{ asset('img/placeholder-company-profile.png') }}" alt="{{ $customer->name }}" /> @endif {{ $customer->name }}</a></div></td>
                <td>{{ $customer->short_name }}</td>
                <td>{{ $customer->vat_number }}</td>
                <td>{{ $customer->company_number }}</td>
                <td>{{ $customer->office_email }}</td>
                <td>{{ $customer->office_phone }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">{{ trans('Nu există clienți') }}</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="text-center">
    {!! $customers->render() !!}
</div>