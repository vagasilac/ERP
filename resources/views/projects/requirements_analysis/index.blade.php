@extends('app')

@section('title') @include('projects._header') @endsection

@section('content')
    <div class="sidebar">
        @include('projects._sidebar')
    </div>
    <div class="content-fluid offset requirements-analysis">
        <div class="paddingL15 paddingR15">
            <div class="page-header col-xs-12 paddingL0">
                <h2>{{ trans('Analiza cerinţelor și verificare technică (analiza calității)') }}</h2>
                @include('projects._buttons')
            </div>
            <h5>{{ trans('Data') }}: {{ count($project->requirements_analysis) > 0 ? $project->requirements_analysis[0]->date->format('d.m.Y') : '' }}</h5>
            <h5 class="marginB30">{{ trans('Cod producție') }}: {{ $project->production_name() }} {{ $project->customer->short_name }} {{ $project->name }}</h5>

            <div class="clearfix"></div>

            {!! Form::model($project, ['action' => ['ProjectsController@requirements_analysis_update', $project->id], 'id' => 'saveForm']) !!}
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td class="paddingL0">
                            <strong class="marginB5 inline-block">{{ trans('Tehnolog') }}:</strong>
                            @foreach ($users_by_role['Tehnolog'] as $user)
                                {{ $user }}
                            @endforeach
                            <br />
                            <strong class="marginB5 inline-block">{{ trans('IWE') }}:</strong>
                            @foreach ($users_by_role['IWE'] as $user)
                                {{ $user }}
                            @endforeach
                            <br />
                            <strong class="marginB5 inline-block">{{ trans('Aprovizionare') }}:</strong>
                            @foreach ($users_by_role['Aprovizionare'] as $user)
                                {{ $user }}
                            @endforeach
                            <br />
                            <strong class="marginB5 inline-block">{{ trans('Șef CTC') }}:</strong>
                            @foreach ($users_by_role['Șef CTC'] as $user)
                                {{ $user }}
                            @endforeach
                            <br />
                            <strong class="marginB5 inline-block">{{ trans('Magazioner') }}:</strong>
                            @foreach ($users_by_role['Magazioner'] as $user)
                                {{ $user }}
                            @endforeach
                            <br />
                            <strong class="marginB5 inline-block">{{ trans('Director Producție') }}:</strong>
                            @foreach ($users_by_role['Director Producție'] as $user)
                                {{ $user }}
                            @endforeach
                            <br />
                            <strong class="marginB5 inline-block">{{ trans('Responsabil Transport') }}:</strong>
                            @foreach ($users_by_role['Responsabil Transport'] as $user)
                                {{ $user }}
                            @endforeach
                            <br />
                            <strong class="marginB5 inline-block">{{ trans('Șef Echipă Montatori') }}:</strong>
                            @foreach ($users_by_role['Șef Echipă Montatori'] as $user)
                                {{ $user }}
                            @endforeach
                        </td>
                        <td class="rotate"><a class="status text-center" style="background-color: {{ $role_colors[$roles['Tehnolog']] }}"  @if (Auth::user()->hasRole('Tehnolog')) data-toggle="modal" data-target="#update-all-modal-{{ $roles['Tehnolog'] }}" @endif>{{ trans('Tehnolog') }}</a></td>
                        <td class="rotate"><a class="status text-center" style="background-color: {{ $role_colors[$roles['IWE']] }}" @if (Auth::user()->hasRole('IWE')) data-toggle="modal" data-target="#update-all-modal-{{ $roles['IWE'] }}" @endif>{{ trans('IWE') }}</a></td>
                        <td class="rotate"><a class="status text-center" style="background-color: {{ $role_colors[$roles['Aprovizionare']] }}" @if (Auth::user()->hasRole('Aprovizionare')) data-toggle="modal" data-target="#update-all-modal-{{ $roles['Aprovizionare'] }}" @endif>{{ trans('Aprovizionare') }}</a></td>
                        <td class="rotate"><a class="status text-center" style="background-color: {{ $role_colors[$roles['Șef CTC']] }}" @if (Auth::user()->hasRole('Șef CTC')) data-toggle="modal" data-target="#update-all-modal-{{ $roles['Șef CTC'] }}" @endif>{{ trans('Șef CTC') }}</a></td>
                        <td class="rotate"><a class="status text-center" style="background-color: {{ $role_colors[$roles['Magazioner']] }}" @if (Auth::user()->hasRole('Magazioner')) data-toggle="modal" data-target="#update-all-modal-{{ $roles['Magazioner'] }}" @endif>{{ trans('Magazioner') }}</a></td>
                        <td class="rotate"><a class="status text-center" style="background-color: {{ $role_colors[$roles['Director Producție']] }}" @if (Auth::user()->hasRole('Director Producție')) data-toggle="modal" data-target="#update-all-modal-{{ $roles['Director Producție'] }}" @endif>{{ trans('Director Producție') }}</a></td>
                        <td class="rotate"><a class="status text-center" style="background-color: {{ $role_colors[$roles['Responsabil Transport']] }}" @if (Auth::user()->hasRole('Responsabil Transport')) data-toggle="modal" data-target="#update-all-modal-{{ $roles['Responsabil Transport'] }}" @endif>{{ trans('Responsabil Transport') }}</a></td>
                        <td class="rotate"><a class="status text-center" style="background-color: {{ $role_colors[$roles['Șef Echipă Montatori']] }}" @if (Auth::user()->hasRole('Șef Echipă Montatori')) data-toggle="modal" data-target="#update-all-modal-{{ $roles['Șef Echipă Montatori'] }}" @endif>{{ trans('Șef Echipă Montatori') }}</a></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($items as $item)
                        @if ($item->id != 11 || ($item->id == 11 && $project->has_assembling()))
                        <tr>
                            <td class="paddingL0">{{ $item->name }}</td>
                            <td class="text-center">
                                @if ($config['Tehnolog'][$item->id])
                                    @if (Auth::user()->hasRole('Tehnolog') && $project->requirements_analysis()->where('user_id', Auth::id())->where('item_id', $item->id)->where('role_id', $roles['Tehnolog'])->count() == 0)
                                        <a class="btn btn-xs btn-success control-plan-submit" data-id="{{ $item->id }}" data-role="{{ $roles['Tehnolog'] }}">{{ trans('Confirm') }}</a>
                                    @elseif ($project->requirements_analysis()->where('item_id', $item->id)->where('role_id', $roles['Tehnolog'])->count() > 0)
                                        <i class="material-icons active" data-toggle="tooltip" title="{{ isset($users_by_item['Tehnolog'][$item->id]) ? implode(', ', $users_by_item['Tehnolog'][$item->id]) : '' }}">&#xE86C;</i>
                                    @else
                                        <i class="material-icons disabled">&#xE15C;</i>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($config['IWE'][$item->id])
                                    @if (Auth::user()->hasRole('IWE') && $project->requirements_analysis()->where('user_id', Auth::id())->where('item_id', $item->id)->where('role_id', $roles['IWE'])->count() == 0)
                                        <a class="btn btn-xs btn-success control-plan-submit" data-id="{{ $item->id }}" data-role="{{ $roles['IWE'] }}">{{ trans('Confirm') }}</a>
                                    @elseif ($project->requirements_analysis()->where('item_id', $item->id)->where('role_id', $roles['IWE'])->count() > 0)
                                        <i class="material-icons active" data-toggle="tooltip" title="{{ isset($users_by_item['IWE'][$item->id]) ? implode(', ', $users_by_item['IWE'][$item->id]) : '' }}">&#xE86C;</i>
                                    @else
                                        <i class="material-icons disabled">&#xE15C;</i>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($config['Aprovizionare'][$item->id])
                                    @if (Auth::user()->hasRole('Aprovizionare') && $project->requirements_analysis()->where('user_id', Auth::id())->where('item_id', $item->id)->where('role_id', $roles['Aprovizionare'])->count() == 0)
                                        <a class="btn btn-xs btn-success control-plan-submit" data-id="{{ $item->id }}" data-role="{{ $roles['Aprovizionare'] }}">{{ trans('Confirm') }}</a>
                                    @elseif ($project->requirements_analysis()->where('item_id', $item->id)->where('role_id', $roles['Aprovizionare'])->count() > 0)
                                        <i class="material-icons active" data-toggle="tooltip" title="{{ isset($users_by_item['Aprovizionare'][$item->id]) ? implode(', ', $users_by_item['Aprovizionare'][$item->id]) : '' }}">&#xE86C;</i>
                                    @else
                                        <i class="material-icons disabled">&#xE15C;</i>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($config['Șef CTC'][$item->id])
                                    @if (Auth::user()->hasRole('Șef CTC') && $project->requirements_analysis()->where('user_id', Auth::id())->where('item_id', $item->id)->where('role_id', $roles['Șef CTC'])->count() == 0)
                                        <a class="btn btn-xs btn-success control-plan-submit" data-id="{{ $item->id }}" data-role="{{ $roles['Șef CTC'] }}">{{ trans('Confirm') }}</a>
                                    @elseif ($project->requirements_analysis()->where('item_id', $item->id)->where('role_id', $roles['Șef CTC'])->count() > 0)
                                        <i class="material-icons active" data-toggle="tooltip" title="{{ isset($users_by_item['Șef CTC'][$item->id]) ? implode(', ', $users_by_item['Șef CTC'][$item->id]) : '' }}">&#xE86C;</i>
                                    @else
                                        <i class="material-icons disabled">&#xE15C;</i>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($config['Magazioner'][$item->id])
                                    @if (Auth::user()->hasRole('Magazioner') && $project->requirements_analysis()->where('user_id', Auth::id())->where('item_id', $item->id)->where('role_id', $roles['Magazioner'])->count() == 0)
                                        <a class="btn btn-xs btn-success control-plan-submit" data-id="{{ $item->id }}" data-role="{{ $roles['Magazioner'] }}">{{ trans('Confirm') }}</a>
                                    @elseif ($project->requirements_analysis()->where('item_id', $item->id)->where('role_id', $roles['Magazioner'])->count() > 0)
                                        <i class="material-icons active" data-toggle="tooltip" title="{{ isset($users_by_item['Magazioner'][$item->id]) ? implode(', ', $users_by_item['Magazioner'][$item->id]) : '' }}">&#xE86C;</i>
                                    @else
                                        <i class="material-icons disabled">&#xE15C;</i>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($config['Director Producție'][$item->id])
                                    @if (Auth::user()->hasRole('Director Producție') && $project->requirements_analysis()->where('user_id', Auth::id())->where('item_id', $item->id)->where('role_id', $roles['Director Producție'])->count() == 0)
                                        <a class="btn btn-xs btn-success control-plan-submit" data-id="{{ $item->id }}" data-role="{{ $roles['Director Producție'] }}">{{ trans('Confirm') }}</a>
                                    @elseif ($project->requirements_analysis()->where('item_id', $item->id)->where('role_id', $roles['Director Producție'])->count() > 0)
                                        <i class="material-icons active" data-toggle="tooltip" title="{{ isset($users_by_item['Director Producție'][$item->id]) ? implode(', ', $users_by_item['Director Producție'][$item->id]) : '' }}">&#xE86C;</i>
                                    @else
                                        <i class="material-icons disabled">&#xE15C;</i>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($config['Responsabil Transport'][$item->id])
                                    @if (Auth::user()->hasRole('Responsabil Transport') && $project->requirements_analysis()->where('user_id', Auth::id())->where('item_id', $item->id)->where('role_id', $roles['Responsabil Transport'])->count() == 0)
                                        <a class="btn btn-xs btn-success control-plan-submit" data-id="{{ $item->id }}" data-role="{{ $roles['Responsabil Transport'] }}">{{ trans('Confirm') }}</a>
                                    @elseif ($project->requirements_analysis()->where('item_id', $item->id)->where('role_id', $roles['Responsabil Transport'])->count() > 0)
                                        <i class="material-icons active" data-toggle="tooltip" title="{{ isset($users_by_item['Responsabil Transport'][$item->id]) ? implode(', ', $users_by_item['Responsabil Transport'][$item->id]) : '' }}">&#xE86C;</i>
                                    @else
                                        <i class="material-icons disabled">&#xE15C;</i>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($config['Șef Echipă Montatori'][$item->id])
                                    @if (Auth::user()->hasRole('Șef Echipă Montatori') && $project->requirements_analysis()->where('user_id', Auth::id())->where('item_id', $item->id)->where('role_id', $roles['Șef Echipă Montatori'])->count() == 0)
                                        <a class="btn btn-xs btn-success control-plan-submit" data-id="{{ $item->id }}" data-role="{{ $roles['Șef Echipă Montatori'] }}">{{ trans('Confirm') }}</a>
                                    @elseif ($project->requirements_analysis()->where('item_id', $item->id)->where('role_id', $roles['Șef Echipă Montatori'])->count() > 0)
                                        <i class="material-icons active" data-toggle="tooltip" title="{{ isset($users_by_item['Șef Echipă Montatori'][$item->id]) ? implode(', ', $users_by_item['Șef Echipă Montatori'][$item->id]) : '' }}">&#xE86C;</i>
                                    @else
                                        <i class="material-icons disabled">&#xE15C;</i>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('content-modals')
    @foreach ($roles as $role)
    <div class="modal fade" id="update-all-modal-{{ $role }}">
        {!! Form::open(['action' => ['ProjectsController@requirements_analysis_update', $project->id], 'method' => 'POST']) !!}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Confirmare') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('Doriți să le confirmați pe toate?') }}
                    <div class="inputs-container">
                        {!! Form::hidden('role', $role) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('Închide') }}</button>
                    {!! Form::button(trans('Da'), ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    @endforeach
@endsection

@section('content-scripts')
    <script type="application/javascript">


        jQuery(document).ready(function($) {
            //hide save button
            $('#save-page-btn').hide();

            //submit control plan form
            $('.control-plan-submit').click(function() {
                var form = $('#saveForm');
                form.append('<input type="hidden" value="1" name="status" />');
                form.append('<input type="hidden" value="' + $(this).data('id') + '" name="item" />');
                form.append('<input type="hidden" value="' + $(this).data('role') + '" name="role" />');
                form.submit();
            });
        });
    </script>
@endsection
