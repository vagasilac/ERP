@extends('app')

@section('title') {{ trans('Audit intern') }} <a href="{{ action('InternalAuditsController@create') }}" class="action pull-right"><i class="fa fa-plus"></i> {{ trans('Adăugare') }}</a> @endsection

@section('content')
    <div class="content-fluid">
        <div class="table-responsive marginT30 list-container">
            @include('internal_audits._internal_audits')
        </div>
    </div>
@endsection
