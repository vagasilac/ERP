@if(count($rooms) > 0)
    @foreach($rooms as $k => $room)
        <li>
            <a data-href="{{ action('MessagesController@index', $room->id) }}" data-id="{{ $room->id }}" class="user-message @if($room->id == $activeRoom->id) active @endif">
                <span class="user-image">
                    @if($room->participants->count() > 1)
                        <img src="{{ asset('img/group.png') }}"/>
                    @else
                        @if ($room->participants->first()->user->photo != '')
                            <img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $room->participants->first()->user->photo)) }}" alt="{{ $room->participants->first()->user->lastname }} {{ $room->participants->first()->user->firstname }}" />
                        @else
                            <span class="placeholder" style="background-color: {{ isset($colors[($room->participants->first()->user->id % count($colors)) + 1]) ? $colors[($room->participants->first()->user->id % count($colors)) + 1] : '' }}">{{ substr($room->participants->first()->user->lastname, 0, 1) }}{{ substr($room->participants->first()->user->firstname, 0, 1) }}</span>
                        @endif
                    @endif
                </span>
                <span class="message">
                    <span class="name room" @if($room->participants->count() > 1) data-trigger="hover" data-placement="bottom" data-popover-content="#room_popover_{{ $room->id }}" data-toggle="popover" data-trigger="focus" href="#" tabindex="0" @endif>
                    @if( $room->name )
                            {{ $room->name }}
                        @else
                            {{ $room->participants->first()->user->firstname }} {{ $room->participants->first()->user->lastname }}
                            @if($room->participants->count() > 1)
                                and {{ $room->participants->count() - 1 }} others
                            @endif
                        @endif
                    </span>

                    @if($room->participants->count() > 1)
                    <!-- Content for Popover -->
                    <div class="hidden room-popover" id="room_popover_{{ $room->id }}">
                      <div class="popover-heading" >
                        <span style="color: #333 !important;">Users in this room</span>
                      </div>

                      <div class="popover-body">
                        @foreach($room->participants as $participant)
                            <div class="popover-item" style="width: 300px; margin-bottom: 10px; display: table;">
                                <span class="user-image pull-left">
                                    @if ($participant->user->photo != '')
                                        <img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $participant->user->photo)) }}" alt="{{ $participant->user->lastname }} {{ $participant->user->firstname }}" />
                                    @else
                                        <span class="placeholder" style="background-color: {{ isset($colors[($participant->user->id % count($colors)) + 1]) ? $colors[($participant->user->id % count($colors)) + 1] : '' }}">{{ substr($participant->user->lastname, 0, 1) }}{{ substr($participant->user->firstname, 0, 1) }}</span>
                                    @endif
                                </span>
                                <span class="popover-name" style="width: 250px; color: #333 !important; display: table-cell; vertical-align: middle; text-align: left;">
                                    {{ $participant->user->firstname }} {{ $participant->user->lastname }}
                                </span>
                                <div class="clearfix"></div>
                            </div>
                        @endforeach
                      </div>
                    </div>
                    @endif

                    <br/>
                    @if( $room->lastMessage()->seen(\Illuminate\Support\Facades\Auth::user()->id)->count() > 0)
                        <b>{{ str_limit($room->lastMessage()->message, 80) }}</b>
                    @else
                        {{ str_limit($room->lastMessage()->message, 80) }}
                    @endif
                    <span class="time">{{ $room->messages()->first()->created_at->format('d/m/Y H:i') }}</span>
                </span>
            </a>
        </li>
    @endforeach
@endif
