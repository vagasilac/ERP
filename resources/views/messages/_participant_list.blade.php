@if($users->count() > 0)
    @foreach($users as $user)
        <li>
            <a href="#" class="participant-add" data-id="{{ $user->id }}">
                <span>{{ $user->firstname }} {{ $user->lastname }}</span>
            </a>
        </li>
    @endforeach
@else
    <li>No user found</li>
@endif