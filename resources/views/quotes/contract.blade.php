@extends('app')

@section('content')
    <div class="sidebar">
        @include('quotes._sidebar')
    </div>
    <div class="content">
        <h1>03.01. SANDOR SCARI 12.10.2015</h1>
        <h3>{{ trans('Contract') }}</h3>
        <form action="/" method="post">
            <div class="form-group">
                <label class="control-label label-req">{{ trans('Contract') }}:</label>
                <input class="form-control" type="file" />
            </div>
        </form>
    </div>
@endsection