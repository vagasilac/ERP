<div class="buttons-container right0 clearfix">
    @if (isset($show))
        @can ($edit_permission)
            <a href="{{ route(Route::currentRouteName(), $project->id) }}" class="btn btn-primary marginL10 pull-left">{{ trans('Editare') }}</a>
            <a href="{{ action('ProjectsController@index') }}" class="btn btn-secondary marginL10 back-btn marginR10 pull-left">{{ trans('Înapoi') }}</a>
        @endcan
    @else
        {!! Form::submit(trans('Salvează'), ['class' => 'btn btn-default pull-left', 'id' => 'save-page-btn']) !!}
        <a href="{{ action('ProjectsController@index') }}" class="btn btn-secondary marginL10 back-btn marginR10 pull-left">{{ trans('Înapoi') }}</a>

        @set ('folder_id', 0)
        @foreach (\App\Models\ProjectFolder::all() as $folder)
            @if (Route::is($folder->route_name))
                @set ($folder_id, $folder->id)
            @endif
        @endforeach

        @set ('folder_status_info', \App\Models\ProjectFolderStatus::where('folder_id', $folder_id)->where('project_id', $project->id)->where('user_id', Auth::id())->first())

        <span class="buttons-separator pull-left"></span>

        @if (Auth::id() == $project->primary_responsible)
            @if (is_null($folder_status_info) || $folder_status_info->status != 'completed')
                <a class="btn btn-success marginL10 pull-left" data-toggle="modal" data-target="#terminate-modal">{{ trans('Terminat') }}</a>
            @endif
        @else
            @if (is_null($folder_status_info) || $folder_status_info->status != 'approved')
            <a class="btn btn-success marginL10 pull-left" data-toggle="modal" data-target="#approve-modal">{{ trans('Aprobă') }}</a>
            @endif

            @if (is_null($folder_status_info) || $folder_status_info->status != 'rejected')
            <a class="btn btn-danger marginL10  pull-left" data-toggle="modal" data-target="#reject-modal">{{ trans('Respinge') }}</a>
            @endif
        @endif
    @endif
</div>