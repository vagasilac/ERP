@if ( app('request')->input('sort') != '')
@set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table table-striped" id="users-table">
    <thead>
    <tr>
        <th width="40">
            <div class="checkbox-inline">
                {!! Form::checkbox('select_all' , 1, false, ['class' => 'select'] ) !!}{!! Form::label('select_all', '&nbsp;', ['class' => 'marginB0']) !!}
            </div>
        </th>
        <th class="sortable"><a data-field="name" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif> @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "name")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Nume') }}</a></th>
        <th class="sortable"><a data-field="email" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "email") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "email")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('E-mail') }}</a></th>
        <th class="sortable"><a data-field="phone" @if ( app('request')->input('sort') != '' && app('request')->input('sort') == "phone") data-sort-direction="{{ $sort_direction }}" @else data-sort-direction="ASC" @endif>@if ( app('request')->input('sort') != '' && app('request')->input('sort') == "phone")<span class="{{ strtolower(app('request')->input('sort_direction')) }} marginR10"></span> @endif{{ trans('Telefon') }}</a></th>
        <th>{{ trans('Rol') }}</th>
    </tr>
    </thead>
    <tbody>
    @if (count($users) > 0)
        @foreach ($users as $k => $user)
            <tr>
                <td>{!! Form::checkbox('select_' . $user->id , $user->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $user->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                <td><div class="user-tag-sm"><a href="{{ action('UsersController@edit', $user->id) }}">@if ($user->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $user->photo)) }}" alt="{{ $user->lastname }} {{ $user->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($user->id % count($colors)) + 1]) ? $colors[($user->id % count($colors)) + 1] : '' }}">{{ substr($user->lastname, 0, 1) }}{{ substr($user->firstname, 0, 1) }}</span>@endif {{ $user->lastname }} {{ $user->firstname }}</a></div></td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>
                    @if (count($users) > 0)
                        @foreach ($user->roles as $role)
                            <span class="status" style="background-color: {{ $role_colors[$role->id] }}">{{ $role->name }}</span>
                        @endforeach
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">{{ trans('Nu există angajați') }}</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="text-center">
    {!! $users->render() !!}
</div>