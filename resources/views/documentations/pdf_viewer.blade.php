@extends('app')

@section('title') {{ $name }} @endsection

@section('content')
    <div class="content-fluid">
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
        pdfjs('{{ $url }}');

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
