<table class="table table-striped" id="drawings-table">
    <thead>
    <tr>
        <th width="40">

        </th>
        <th width="300">{{ trans('Fișier') }}</th>
        <th>{{ trans('(Sub)ansamblu') }}</th>
        <th>{{ trans('Observații') }}</th>
        <th>{{ trans('Fișiere') }}</th>
        <th width="45" class="text-center">{{ trans('Încarcă fișier') }}</th>
    </tr>
    </thead>
    <tbody>
    @if (count($project->drawings) > 0)
        @foreach ($project->drawings as $k => $file)
            @if (count($file->quality_control_drawings) > 0)
                <tr>
                    <td>{!! Form::checkbox('select_' . $file->id , $file->id, false, ['class' => 'select'] ) !!}{!! Form::label('select_' . $file->id, '&nbsp;', ['class' => 'marginB0']) !!}</td>
                    <td><a href="{{ action('FilesController@show', ['id' => $file->file_id, 'name' =>$file->name]) }}" target="_blank" class="no-style text-nowrap"><span class="tag marginR10" style="background-color: {{ isset($file_type_colors[strtolower(Illuminate\Support\Facades\File::extension($file->file->file))]) ? $file_type_colors[strtolower(Illuminate\Support\Facades\File::extension($file->file->file))] : '' }}">{{ Illuminate\Support\Facades\File::extension($file->file->file) }}</span> {{ $file->name }}</a></td>
                    <td class="ui-front">{{ !is_null($file->subassembly) ? $file->subassembly->name : ''}}</td>
                    <td><span data-toggle="tooltip" title="Cras ultricies ligula sed magna dictum porta. Donec rutrum congue leo eget malesuada.">Cras ultricies ligula sed magna dictum porta&hellip;</span></td>
                    <td>
                        @if (count($file->quality_control_drawings) > 0)
                            @foreach ($file->quality_control_drawings as $k => $qa_file)
                                @if (!is_null($qa_file->file))
                                <div class="file-tag pull-left marginR5"><a href="{{ action('FilesController@show', ['id' => $qa_file->file->id]) }}" target="_blank">{{ substr($qa_file->file->file, strrpos($qa_file->file->file, '/') + 1) }}</a><a class="icon-container" data-toggle="modal" data-target="#delete-modal{{ $qa_file->id }}"><i class="material-icons">&#xE14C;</i></a></div>
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td align="center"><a class="btn btn-sm btn-default icon-btn" title="{{ trans('Încarcă') }}" data-toggle="modal" data-target="#upload-modal{{ $file->id }}"><i class="material-icons">&#xE2C6;</i></a></td>
                </tr>
            @endif
        @endforeach
    @else
        <tr>
            <td colspan="6">{{ trans('Nu există fișiere') }}</td>
        </tr>
    @endif
    </tbody>
</table>