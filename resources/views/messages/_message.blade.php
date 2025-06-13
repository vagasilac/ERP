@if ( $message->prevMessage() === false)
    <div class="separator"><span class="text">{{ $message->created_at->format('d/m/Y') }}</span></div>
@elseif( $message->prevMessage()->created_at->format('d/m/Y') !== $message->created_at->format('d/m/Y'))
    <div class="separator"><span class="text">{{ $message->created_at->format('d/m/Y') }}</span></div>
@endif
<div class="@if(\Illuminate\Support\Facades\Auth::user()->id == $message->user->id) my-message clearfix @else user-message @endif">
    @if(\Illuminate\Support\Facades\Auth::user()->id != $message->user->id)
        <span class="user-image">
                                    @if ($message->user->photo != '')
                <img src="{{ asset('media/users/thumbs/' . $message->user->photo) }}" alt="{{ $message->user->lastname }} {{ $message->user->firstname }}" />
            @else
                <span class="placeholder" style="background-color: {{ $colors[($k % count($colors)) + 1] }}">{{ substr($message->user->lastname, 0, 1) }}{{ substr($message->user->firstname, 0, 1) }}</span>
            @endif
                                </span>
    @endif
    <span class="message @if(\Illuminate\Support\Facades\Auth::user()->id == $message->user->id) pull-right @endif">
                                    @if(\Illuminate\Support\Facades\Auth::user()->id != $message->user->id)
            <span class="name">{{ $message->user->lastname }} {{ $message->user->firstname }}</span> <br />
        @endif
        {{ $message->message }}
        <span class="time">{{ $message->created_at->format('d/m/Y H:i') }}</span>
                                </span>
</div>