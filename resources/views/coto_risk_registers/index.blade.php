@extends('app')

@section('title') {{ trans('Contextul Organizației') }}@endsection

@section('content')
    <div class="content-fluid">
        <div class="filters-bar clearfix" data-target="#ru-table">
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
            @include('coto_risk_registers._cr_list')
        </div>
    </div>
@endsection

@section('content-scripts')
    <script type="application/javascript">
        apply_filters(jQuery('.list-container'));
    </script>
@endsection
