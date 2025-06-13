@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-striped" id="subassembly-groups-table">
    <thead>
    <tr>
        <th width="40"></th>
        <th>{{ trans('Nume') }}</th>
        <th>{{ trans('Responsabili') }}</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @if (count($subassembly_groups) > 0)
        @foreach ($subassembly_groups as $k => $item)
            <tr class="subassembly-groups-row">
                <td class="valign-middle"><a data-id="{{ $item->id }}" data-toggle="modal" data-target="#group-delete-modal-{{ $item->id }}" id="group-remove-icon-{{ $item->id }}" class="remove-icon"><span class="fa fa-trash-o"></span></a></td>
                <td width="300">{!! Form::text('subassembly_groups[' . $item->id . '][name]', $item->name, ['class' => 'form-control without-label']) !!}</td>
                <td>
                    @if (count($item->responsibles) > 0)
                        @foreach ($item->responsibles as $responsible)
                            @set ('user', $responsible->user)
                            <div class="user-tag-sm inline-block marginR15 text-nowrap"><a href="{{ action('UsersController@edit', $user->id) }}">@if ($user->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $user->photo)) }}" alt="{{ $user->lastname }} {{ $user->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($user->id % count($colors)) + 1]) ? $colors[($user->id % count($colors)) + 1] : '' }}">{{ substr($user->lastname, 0, 1) }}{{ substr($user->firstname, 0, 1) }}</span>@endif {{ $user->lastname }} {{ $user->firstname }}</a> <a class="text-danger" title="{{ trans('Șterge') }}" data-toggle="modal" data-target="#delete-responsible-modal-{{ $item->id }}-{{ $responsible->user->id }}"><i class="material-icons valign-middle marginB5">&#xE14C;</i></a></div>
                        @endforeach
                    @endif
                </td>
                <td width="200">
                    <a class="no-underline add-responsible" data-toggle="modal" data-target="#add-responsible-{{ $item->id }}"><span class="fa fa-plus-circle"></span> {{ trans('Adaugă responsabil') }}</a>
                </td>
            </tr>
        @endforeach
    @else
        <tr class="subassembly-groups-row">
            <td class="valign-middle"><a class="remove-table-row"><span class="fa fa-trash-o"></span></a></td>
            <td width="300">{!! Form::text('new_subassembly_groups[0][name]', null, ['class' => 'form-control without-label']) !!}</td>
            <td></td>
            <td >
            </td>
        </tr>
    @endif
    </tbody>
</table>

@section('content-modals')
    @parent

    @if (count($subassembly_groups) > 0)
        @foreach ($subassembly_groups as $k => $item)
            <div class="modal fade group-delete-modal" id="group-delete-modal-{{ $item->id }}">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" >{{ trans('Ștergere grup de (sub)ansamblu') }}</h4>
                        </div>
                        <div class="modal-body">
                            {{ trans('Doriți să ștergeți acest grup de (sub)ansamblu?') }}
                            <div class="inputs-container"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                            <a class="remove-table-row btn btn-danger" data-id="{{ $item->id }}" data-remove-icon="#group-remove-icon-{{ $item->id }}">{{ trans('Șterge') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
