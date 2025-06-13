@if(isset($user))
    <li id="participant{{ $user->id }}" class="participant check">
        {!! Form::checkbox('participants[]', $user->id, false, ['class' => 'user-select', 'checked' => 'checked'] ) !!}
        {!! Form::label('user', $user->lastname . ' ' . $user->firstname, ['class' => 'marginB0 paddingL30']) !!}
    </li>
@endif