@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-striped" id="roles-table">
    <thead>
    <tr>
        <th width="40">
            <div class="checkbox-inline">
                {!! Form::checkbox('select_all' , 1, false, ['class' => 'select'] ) !!}{!! Form::label('select_all', '&nbsp;', ['class' => 'marginB0']) !!}
            </div>
        </th>
        <th class="sortable"><a data-field="name" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Rol') }}</a></th>
    </tr>
    </thead>
    <tbody>

    @if (count($roles) > 0)
        @foreach ($roles as $k => $role)
            <tr>
                <td>{!! Form::checkbox('select_' . $role->id , $role->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $role->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                <td><div class="user-tag-sm"><a href="{{ action('RolesController@edit', $role->id) }}">{{ $role->name }}</a></div></td>
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
    {!! $roles->render() !!}
</div>