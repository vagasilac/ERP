@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-striped" id="suppliers-table">
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
        <th class="sortable"><a data-field="average_rating" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "average_rating") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "average_rating")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Evaluare') }}</a></th>

    </tr>
    </thead>
    <tbody>

    @if (count($suppliers) > 0)
        @foreach ($suppliers as $k => $supplier)
            <tr>
                <td>{!! Form::checkbox('select_' . $supplier->id , $supplier->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $supplier->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                <td><div class="user-tag-sm"><a href="{{ action('SuppliersController@edit', $supplier->id) }}">@if ($supplier->logo != '')<img src="{{ action('FilesController@image', base64_encode('suppliers/thumbs/' . $supplier->logo)) }}" alt="{{ $supplier->name }}" />@else <img src="{{ asset('img/placeholder-company-profile.png') }}" alt="{{ $supplier->name }}" /> @endif {{ $supplier->name }}</a></div></td>
                <td>{{ $supplier->short_name }}</td>
                <td>{{ $supplier->vat_number }}</td>
                <td>{{ $supplier->company_number }}</td>
                <td>{{ $supplier->office_email }}</td>
                <td>{{ $supplier->office_phone }}</td>
                <td>@if (!is_null($supplier->average_rating) && $supplier->average_rating != '') <span class="label @if ($supplier->average_rating < 2) label-danger @elseif ($supplier->average_rating < 4) label-warning @else label-success @endif"><i class="material-icons">&#xE838;</i> {{ $supplier->average_rating }}</span>@endif</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">{{ trans('Nu există furnizori aprobați') }}</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="text-center">
    {!! $suppliers->render() !!}
</div>
