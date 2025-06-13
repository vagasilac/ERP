<table class="table marginT30">
    <thead>
        <tr>
            <th class="text-left">{{ trans('ID') }}</th>
            <th class="text-left">{{ trans('Participanți') }}</th>
            <th class="text-left">{{ trans('Absenți') }}</th>
            <th class="text-left">{{ trans('Data') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (count($management_review_meetings) > 0)
        @foreach ($management_review_meetings as $management_review_meeting)
            <tr>
                <td class="text-left"><div class="user-tag-sm"><a href="{{ action('ManagementReviewMeetingsController@view', $management_review_meeting->id) }}">{{ $management_review_meeting->id }}</a></div</td>
                <td class="text-left">{{ $management_review_meeting->get_attendance_names() }}</td>
                <td class="text-left">{{ $management_review_meeting->get_absent_names() }}</td>
                <td class="text-left">{{ Carbon\Carbon::parse($management_review_meeting->created_at)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
        @else
            <tr>
                <td colspan="13">{{ trans('Nu există înregistrări') }}</td>
            </tr>
        @endif
    </tbody>
</table>
