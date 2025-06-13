@extends('app')

@section('title') {{ trans('Furnizori aprobați') }} <a href="{{ action('SuppliersController@create') }}" class="action pull-right"><i class="fa fa-plus"></i> {{ trans('Adaugă furnizor aprobat nou') }}</a> @endsection

@section('content')
    <div class="content-fluid">
        <div class="scrollable-nav-bar marginT30">
            <div class="scroller scroller-left"><i class="fa fa-angle-left fa-3x"></i></div>
            <div class="scroller scroller-right"><i class="fa fa-angle-right fa-3x"></i></div>
            <div class="wrapper">
                <ul class="nav nav-tabs list" id="myTab">
                    <li @if (Request::segment(3) == '') class="active" @endif><a href="{{ action('SuppliersController@index') }}">{{ trans('Toate') }}</a></li>
                    @foreach($types as $type)
                        <li @if ($type->id == Request::segment(3)) class="active" @endif><a href="{{ url('furnizori-aprobati/tip', $type->id) }}">{{ trans($type->name) }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="actions-bar clearfix" data-target="#suppliers-table">
            <div class="col-xs-12 paddingT5 paddingB5 clearfix">
                <div class="pull-left marginR15"><span class="count">0</span> {{ trans('articol(e) selectat(e)') }}</div>
                @can ('Suppliers delete')
                <div class="pull-left marginL5"><a class="material-icon-container remove" data-toggle="modal" data-target="#delete-modal"><i class="material-icons">&#xE872;</i></a></div>
                @endcan
            </div>
        </div>
        <div class="filters-bar clearfix" data-target="#suppliers-table" style="border-color: transparent">
            <div class="col-xs-12">
                <form action="" method="get" class="form-inline filters">
                    <div class="form-group marginR15">
                        <label class="control-label">{{ trans('Denumire furnizor aprobat') }}, {{ trans('CUI') }}, {{ trans('Nr. reg. com.') }}</label>
                        <input class="form-control input-lg keyup-filter" name="search" type="text"  />
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive list-container">
            @include('suppliers._suppliers_list')
        </div>
    </div>
@endsection


@section('content-modals')
    <div class="modal fade" id="delete-modal">
        {!! Form::open(['action' => ['SuppliersController@multiple_destroy'], 'method' => 'DELETE']) !!}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >{{ trans('Șterge furnizori aprobați') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('Doriți să ștergeți acești furnizori aprobați') }}
                    <div class="inputs-container"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Închide</button>
                    {!! Form::button('Șterge', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('content-scripts')
    <script type="application/javascript">
        apply_filters(jQuery('.list-container'));
    </script>

    <!-- Scrollable nav-bar script -->

    <script>
        jQuery(document).ready(function($) {
            var hidWidth;
            var scrollBarWidths = 40;

            var widthOfList = function(){
                var itemsWidth = 0;
                $('.list li').each(function(){
                    var itemWidth = $(this).outerWidth();
                    itemsWidth+=itemWidth;
                });
                return itemsWidth;
            };

            var widthOfHidden = function(){
                return (($('.wrapper').outerWidth())-widthOfList()-getLeftPosi())-scrollBarWidths;
            };

            var getLeftPosi = function(){
                return $('.list').position().left;
            };

            var reAdjust = function(){
                if (($('.wrapper').outerWidth()) < widthOfList()) {
                    $('.scroller-right').show();
                }
                else {
                    $('.scroller-right').hide();
                }

                if (getLeftPosi()<0) {
                    $('.scroller-left').show();
                }
                else {
                    $('.item').animate({left:"-="+getLeftPosi()+"px"},'slow');
                    $('.scroller-left').hide();
                }
            }

            reAdjust();

            $(window).on('resize',function(e){
                reAdjust();
            });

            $('.scroller-right').click(function() {

                $('.scroller-left').fadeIn('slow');
                $('.scroller-right').fadeOut('slow');

                $('.list').animate({left:"+="+widthOfHidden()+"px"},'slow',function(){

                });
            });

            $('.scroller-left').click(function() {

                $('.scroller-right').fadeIn('slow');
                $('.scroller-left').fadeOut('slow');

                $('.list').animate({left:"-="+getLeftPosi()+"px"},'slow',function(){

                });
            });
        });
    </script>
@endsection
