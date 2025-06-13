@extends('app')

@section('title') {{ trans('Pagina nu a fost găsită!') }} @endsection

@section('content')
    <div class="content-fluid">
        <div class="col-xs-12 marginT30">
            <h4>{{ trans('Ne pare rău – pagina pe care o căutați nu a fost găsită.') }}</h4>
            <p>{{ trans('Este posibil ca pagina pe care o căutați să fi fost mutată, actualizată sau ștearsă.') }}</p>
        </div>
    </div>

@endsection
