<ul class="product-folders nav nav-pills nav-stacked">
    @set ('folder_id', 0)
    @foreach (\App\Models\ProjectFolder::where('parent', 0)->orderBy('order')->get() as $folder)
        <li class="@if (in_array(Route::currentRouteName(), explode(';', $folder->route_name))) active @endif">
            <span class="icons-container">
                @set ('folder_status', $folder->status($project->id))
                @if ($folder_status == 'approved')
                    @php
                        $tooltip_message = '';
                        $status_info = $folder->status_info($project->id, 'approved');
                        if (!is_null($status_info)) {
                            $tooltip_message = '<div class="marginB5">' . trans('Aprobat de către') . ':</div>';
                            foreach ($status_info as $info) {
                                $tooltip_message .= ' ' . $info->user->firstname . $info->user->lastname . ',';
                            }
                            $tooltip_message = rtrim($tooltip_message, ",");
                        }
                    @endphp
                    <i class="material-icons success" data-toggle="tooltip" data-placement="right" title="{{ $tooltip_message }}">&#xE86C;</i>
                @elseif ($folder_status == 'rejected')
                    @php
                        $tooltip_message = '';
                        $status_info = $folder->status_info($project->id, 'rejected');
                        if (!is_null($status_info)) {
                            $tooltip_message = '<div>' . trans('Respins de către') . ':</div>';
                            foreach ($status_info as $info) {
                                $tooltip_message .= '<div class="marginT5">' . $info->user->firstname . $info->user->lastname . ' <div clas="paddingL5">"' . $info->description . '"</div></div>';
                            }
                            $tooltip_message = rtrim($tooltip_message, ",");
                        }
                    @endphp
                    <i class="material-icons danger" data-toggle="tooltip" data-placement="right" title="{{ $tooltip_message }}">&#xE5C9;</i>
                @elseif ($folder_status == 'completed')
                    <i class="material-icons" data-toggle="tooltip" data-placement="right" title="{{ trans('Terminat') }}">&#xE065;</i>
                @endif
                @php
                /*
                <i class="material-icons lock">&#xE897;</i>
                */
                @endphp
            </span>
            @if (count($folder->children) > 0)
                <a @if (count($folder->children) > 0) data-toggle="collapse" href="#sidebar-nav-child-{{ $folder->id }}" @endif class="sidebar-nav-link @if (!in_array(Route::currentRouteName(), explode(';', $folder->route_name))) collapsed @endif">{{ $folder->name }}<span class="arrow-icon-container"><i class="material-icons arrow-down">&#xE313;</i><i class="material-icons arrow-up">&#xE316;</i></span></a>
                @if (count($folder->children) > 0)
                    <ul class="nav nav-pills nav-stacked @if (!in_array(Route::currentRouteName(), explode(';', $folder->route_name))) collapse @endif" id="sidebar-nav-child-{{ $folder->id }}">
                        @foreach ($folder->children as $child)
                            <li @if (Route::is($child->route_name)) class="active" @endif><span class="icons-container"></span><a href="{{ $child->route_name != '' ? route($child->route_name, $project->id) : '' }}">{{ $child->name }}</a></li>

                            @if (Route::is($child->route_name))
                                @set ($folder_id, $child->id)
                            @endif
                        @endforeach
                    </ul>
                @endif
            @else
                <a href="{{ $folder->route_name != '' ? route($folder->route_name, [$project->id, 'show']) : '' }}">{{ $folder->name }}</a>
            @endif


        </li>

        @if (Route::is($folder->route_name))
            @set ($folder_id, $folder->id)
        @endif
    @endforeach
</ul>

@section('content-modals')
    @parent

    <div class="modal fade" id="approve-modal">
        {!! Form::open(['action' => ['ProjectsController@change_folder_status', $project->id]]) !!}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Aprobă') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('Doriți să aprobați această secțiune a proiectului?') }}
                    <div class="inputs-container">
                        {{ Form::hidden('folder_id', $folder_id) }}
                        {{ Form::hidden('status', 'approved') }}
                        {{ Form::hidden('return_url', Request::url()) }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Aprobă', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="modal fade" id="reject-modal">
        {!! Form::open(['action' => ['ProjectsController@change_folder_status', $project->id]]) !!}
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Respinge') }}</h4>
                </div>
                <div class="modal-body">
                    <div>{{ trans('Doriți să respingeți această secțiune a proiectului?') }}</div><br>
                    <div class="inputs-container">
                        {{ Form::hidden('folder_id', $folder_id) }}
                        {{ Form::hidden('status', 'rejected') }}
                        {{ Form::hidden('return_url', Request::url()) }}
                        <div class="form-group">
                            {!! Form::label('sanding[auto-roughness]', trans('Motiv') , ['class'=> 'control-label']) !!}
                            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 4]) }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Respinge', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="modal fade" id="terminate-modal">
        {!! Form::open(['action' => ['ProjectsController@change_folder_status', $project->id]]) !!}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Setare ca terminat') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('Doriți să setați ca și terminat această secțiune a proiectului?') }}
                    <div class="inputs-container">
                        {{ Form::hidden('folder_id', $folder_id) }}
                        {{ Form::hidden('status', 'completed') }}
                        {{ Form::hidden('return_url', Request::url()) }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Terminat', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@endsection