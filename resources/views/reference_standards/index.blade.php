@extends('app')

@section('title') {{ trans('Standarde de referință') }} @endsection

@section('content')
    <div class="content-fluid">
        @if (!is_null($url_other))
            <div class="col-xs-12 marginT15 marginB15">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" @if($lang == 'ro') class="active" @endif><a href="{{ url('standarde-de-referinta', [$id, 'ro']) }}">{{ trans('Ro') }}</a></li>
                    <li role="presentation" @if($lang == 'other') class="active" @endif><a href="{{ url('standarde-de-referinta', [$id, 'other']) }}">@if($id == 3){{ trans('Hu') }} @else {{ trans('En') }} @endif</a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        @endif
        <div class="pdfjs-container">
            <div id="actions-bar-before"></div>
            <div class="filters-bar full-width" id="actions-bar">
                <div class="marginL15 marginR15 text-center">
                    <button id="prev" class="btn btn-secondary"><i class="material-icons">&#xE408;</i> {{ trans('Înapoi') }}</button>
                    <button id="next" class="btn btn-secondary"><i class="material-icons">&#xE409;</i> {{ trans('Înainte') }}</button>
                    <button id="open" class="btn btn-secondary"><i class="material-icons">&#xE89E;</i> {{ trans('Deschide') }}</button>
                    &nbsp; &nbsp;
                    <span>{{ trans('Pagină') }}: <span id="page_num"></span> / <span id="page_count"></span></span>
                </div>
            </div>
            <canvas id="the-canvas" class="marginL50"></canvas>
        </div>
    </div>
@endsection

@section('content-scripts')
    <script src="{{ asset('js/pdfjs/pdfjs.js') }}" charset="utf-8"></script>
    <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script type="text/javascript">
        if ('{{ $lang }}' == 'ro') {
            pdfjs('{{ $url_ro }}');
        }
        else {
            pdfjs(' {{ $url_other }}');
        }

        jQuery(document).ready(function ($) {

            /**
             * Add affix to actions bar
             */
            $('#actions-bar').affix({
                offset: {
                    top: function() {
                        var position = $('#actions-bar-before').offset();
                        return position.top;
                    }
                }
            });
        });
    </script>
@endsection
