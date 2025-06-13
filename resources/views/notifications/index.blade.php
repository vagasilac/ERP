@extends('app')

@section('title') {{ trans('Notificări') }} @endsection

@section('content')
    <div class="content-fluid">
        <div class="filters-bar clearfix" data-target="#notifications-table">
            <div class="col-xs-12">
                <form action="" method="get" class="form-inline filters">
                    <div class="form-group marginR15">
                        <label class="control-label">{{ trans('Căutare') }}</label>
                        <input class="form-control input-lg keyup-filter" name="search" type="text"  />
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive marginT30 list-container">
            @include('notifications._notifications_list')
        </div>
    </div>
@endsection