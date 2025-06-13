@extends('app')

@section('title') {{ trans('Analiza efectuata de management') }} <a href="{{ action('ManagementReviewMeetingsController@create') }}" class="action pull-right"><i class="fa fa-plus"></i> {{ trans('Adăugare') }}</a> @endsection

@section('content')
    <div class="content-fluid">
        <div class="table-responsive marginT30 list-container">
            @include('management_review_meetings._management_review')
        </div>
    </div>
@endsection
