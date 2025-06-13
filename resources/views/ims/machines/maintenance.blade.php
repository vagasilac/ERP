@extends('app')

@section('title') {{ $item->name }} - {{ trans('Calendarul de mentenanță / reparație') }} @endsection

@section('content')
    <div class="content-fluid">
        <div class="col-xs-12">
            @include('ims.machines._maintenance_calendar')
        </div>
    </div>
@endsection
