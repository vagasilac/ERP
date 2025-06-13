@extends('app')

@section('title')
    {{ trans('Anexa A - Tabelul Proceselor') }}
@endsection

@section('content')
    <div class="content-fluid">

        <div class="clearfix"></div>

        <div class="col-xs-12 marginT30">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left">{{ trans('Proces') }}</th>
                        <th class="text-left">{{ trans('Sub-procese / activități') }}</th>
                        <th class="text-left">{{ trans('Document (Procedură / Instructiune de lucru)') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($processes) > 0)
                        @foreach ($processes as $process)
                            @if (count($process->sub_process) > 0)
                                @foreach ($process->sub_process as $sub_process)
                                    <tr>
                                    <td class="text-left">{{ $process->name }}</td>
                                    <td class="text-left">{{ $sub_process->name }}</td>
                                    <td class="text-left">{{ $sub_process->get_procedure_names() }}</td>
                                    @foreach ($standards as $standard)
                                        <tr class="child">
                                            <td class="text-left">{{ $standard->name }}</td>
                                            <td class="text-left">{{ $sub_process->get_chaptures_nrs_from_a_standard($standard->id) }}</td>
                                        </tr>
                                    @endforeach
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-left">{{ $process->name }}</td>
                                    <td class="text-left"></td>
                                    <td class="text-left">{{ $process->get_procedure_names() }}</td>
                                    @foreach ($standards as $standard)
                                        <tr class="child">
                                            <td class="text-left">{{ $standard->name }}</td>
                                            <td class="text-left">{{ $process->get_chaptures_nrs_from_a_standard($standard->id) }}</td>
                                        </tr>
                                    @endforeach
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="13">{{ trans('Nu există înregistrări') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
