@if ( app('request')->input('sort') != '')
    @set ('sort_direction', app('request')->input('sort_direction') == 'ASC' ? 'DESC' : 'ASC')
@endif

<table class="table" id="notifications-table">
    <tbody>

    @if (count($notifications) > 0)
        @foreach ($notifications as $k => $notification)
            <tr class="@if (!$notification->getReadAttribute()) new @endif">
                <td data-toggle="notification" data-action="{{ action('NotificationsController@mark_read', $notification->id) }}">{!! substr_replace($notification->message, '<span class="date">' . $notification->timestamp->format('d/m/Y h:i') . '</span>', strpos($notification->message, '</a>'), 0) !!}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">{{ trans('Nu există notificări') }}</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="text-center">
    {!! $notifications->render() !!}
</div>