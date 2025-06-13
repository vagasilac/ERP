@extends('app')

@section('title') {{ trans('Documente QC') }} @endsection

@section('content')
    <div class="content-fluid">
        <div class="table-responsive marginT30 list-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left">{{ trans('Proiect') }}</th>
                        <th class="text-left">{{ trans('Tip') }}</th>
                        <th class="text-left">{{ trans('Document') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($documents) > 0)
                        @foreach ($documents as $document)
                            <tr>
                                <td class="text-left">{{ $document->project->name }}</td>
                                <td class="text-left">{{ $document->project_document_categorie->name }}</td>
                                <td class="text-left"><a href="{{ action('FilesController@show', ['id' => $document->file_id, 'name' =>$document->name]) }}" target="_blank" class="no-style text-nowrap"><span class="tag marginR10" style="background-color: {{ isset($document_type_colors[strtolower(Illuminate\Support\Facades\File::extension($document->file->file))]) ? $document_type_colors[strtolower(Illuminate\Support\Facades\File::extension($document->file->file))] : '' }}">{{ Illuminate\Support\Facades\File::extension($document->file->file) }}</span> {{ $document->name }}</a></td>
                            </tr>
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
