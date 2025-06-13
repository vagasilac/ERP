@if(!is_null($activeRoom))
    @if($activeRoom->messages()->count() > 0)
        @foreach($activeRoom->messages as $k => $message)
            @include('messages._message')
        @endforeach
    @endif
@endif
