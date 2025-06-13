@extends('app')

@section('title') {{ trans('Diplome') }} @endsection

@section('content')
    <div class="content-fluid">
        <div class="table-responsive marginT30 list-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left">{{ trans('Utilizator') }}</th>
                        <th class="text-left">{{ trans('Diploma') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($diplomas) > 0)
                        @foreach ($diplomas as $diploma)
                            <tr>
                                <td class="text-left"><div class="user-tag-sm">@if ($diploma->user->photo != '')<img src="{{ action('FilesController@image', base64_encode('users/thumbs/' . $diploma->user->photo)) }}" alt="{{ $diploma->user->lastname }} {{ $diploma->user->firstname }}" />@else <span class="placeholder" style="background-color: {{ isset($colors[($diploma->user->id % count($colors)) + 1]) ? $colors[($diploma->user->id % count($colors)) + 1] : '' }}">{{ substr($diploma->user->lastname, 0, 1) }}{{ substr($diploma->user->firstname, 0, 1) }}</span>@endif {{ $diploma->user->lastname }} {{ $diploma->user->firstname }}</div></td>
                                <td class="text-left"><a href="{{ action('FilesController@show', ['id' => $diploma->file_id, 'name' =>$diploma->name]) }}" target="_blank" class="no-style text-nowrap"><span class="tag marginR10" style="background-color: {{ isset($diploma_type_colors[strtolower(Illuminate\Support\Facades\File::extension($diploma->file->file))]) ? $diploma_type_colors[strtolower(Illuminate\Support\Facades\File::extension($diploma->file->file))] : '' }}">{{ Illuminate\Support\Facades\File::extension($diploma->file->file) }}</span> {{ $diploma->name }}</a></td>
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
