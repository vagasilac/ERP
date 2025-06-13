@extends('app')

@section('title') {{ trans('Analiza efectuata de management') }} @endsection

@section('content')
    <div class="content-fluid">
        {!! Form::model($management_review_meeting, ['id' => 'saveForm', 'files' => true]) !!}
        <div class="page-header no-border col-xs-12">
            <h2>&nbsp;</h2>
            <div class="buttons-container">
                <a href="{{ action('ManagementReviewMeetingsController@index') }}" class="btn btn-secondary marginL15 back-btn">{{ trans('Înapoi') }}</a>
            </div>
        </div>

        <div class="scrollable-nav-bar marginT30">
            <div class="scroller scroller-left"><i class="fa fa-angle-left fa-3x"></i></div>
            <div class="scroller scroller-right"><i class="fa fa-angle-right fa-3x"></i></div>
            <div class="wrapper">
                <ul class="nav nav-tabs list" id="myTab">
                    <li role="presentation" class="active"><a href="#general-container"  aria-controls="general-container" role="tab" data-toggle="tab">{{ trans('General') }}</a></li>
                    <li role="presentation"><a href="#revision-of-integrated-policy-container"  aria-controls="revision-of-integrated-policy-container" role="tab" data-toggle="tab">{{ trans('Revizuirea Politicii Integrată') }}</a></li>
                    <li role="presentation"><a href="#review-internal-and-external-issues-container" aria-controls="review-internal-and-external-issues-container" role="tab" data-toggle="tab">{{ trans('Revizuirea problemelor interne și externe (Contextul Organizației)') }}</a></li>
                    <li role="presentation"><a href="#internal-and-external-audits-container" aria-controls="internal-and-external-audits-container" role="tab" data-toggle="tab">{{ trans('Audituri interne și externe') }}</a></li>
                    <li role="presentation"><a href="#corrective-and-preventive-actions-container" aria-controls="corrective-and-preventive-actions-container" role="tab" data-toggle="tab">{{ trans('Acțiuni corective si preventive') }}</a></li>
                    <li role="presentation"><a href="#resource-review-container" aria-controls="resource-review-container" role="tab" data-toggle="tab">{{ trans('Revizuirea Resurselor') }}</a></li>
                    <li role="presentation"><a href="#review-of-training-container" aria-controls="review-of-training-container" role="tab" data-toggle="tab">{{ trans('Revizuirea Instruirii') }}</a></li>
                    <li role="presentation"><a href="#supplier-review-container" aria-controls="supplier-review-container" role="tab" data-toggle="tab">{{ trans('Revizuirea furnizorilor aprobate') }}</a></li>
                    <li role="presentation"><a href="#revision-of-objectives-container" aria-controls="revision-of-objectives-container" role="tab" data-toggle="tab">{{ trans('Revizuirea obiectivelor') }}</a></li>
                    <li role="presentation"><a href="#customer-feedback-container" aria-controls="customer-feedback-container" role="tab" data-toggle="tab">{{ trans('Feedback-ul clientului, rezultatele masurarii satisfacției clienților') }}</a></li>
                    <li role="presentation"><a href="#overall-performance-of-the-integrated-management-system-container" aria-controls="overall-performance-of-the-integrated-management-system-container" role="tab" data-toggle="tab">{{ trans('Performanța generală a sistemului de management integrat. Oportunități de îmbunătățire') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="tab-content col-xs-12 marginT30">
            <div class="tab-pane active" id="general-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    <div class="form-group">
                        {!! Form::label('attendance', trans('Participanți'), ['class' => 'control-label small-label']) !!}
                        {!! Form::text('attendance', $management_review_meeting->get_attendance_names(), ['class' => 'form-control', 'disabled']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('absent', trans('Absenți'), ['class' => 'control-label small-label']) !!}
                        {!! Form::text('absent', $management_review_meeting->get_absent_names(), ['class' => 'form-control', 'disabled']) !!}
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="revision-of-integrated-policy-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    @include('management_review_meetings._manual_system_management')
                    <div class="form-group">
                        {!! Form::label('accepted_policy', trans('Status'), ['class' => 'control-label']) !!}
                        {!! Form::select('accepted_policy', Config::get('management_review_meetings.policy'), null, ['class' => 'form-control', 'id'  => 'policy-change', 'disabled']) !!}
                    </div>
                    <div class="form-group @if ($management_review_meeting->policy_recommendation == '') hidden @endif">
                        {!! Form::label('policy_recommendation', trans('Modificările recomandate'), ['class' => 'control-label']) !!}
                        {!! Form::text('policy_recommendation', null, ['class' => 'form-control', 'id' => 'policy-recommendation-input', 'disabled']) !!}
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="review-internal-and-external-issues-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    @include('management_review_meetings._coto_issues')
                    <div class="form-group">
                        {!! Form::label('accepted_issues', trans('Status'), ['class' => 'control-label']) !!}
                        {!! Form::select('accepted_issues', Config::get('management_review_meetings.issues'), null, ['class' => 'form-control', 'id'  => 'issues-change', 'disabled']) !!}
                    </div>
                    <div class="form-group @if ($management_review_meeting->issues_recommendation == '') hidden @endif">
                        {!! Form::label('issues_recommendation', trans('Modificările recomandate'), ['class' => 'control-label']) !!}
                        {!! Form::text('issues_recommendation', null, ['class' => 'form-control', 'id' => 'issues-recommendation-input', 'disabled']) !!}
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="internal-and-external-audits-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    <h4>{{ trans('Analiza rezultatelor auditurilor efectuate de la ultima ședință') }}</h4>
                    @include('management_review_meetings._internal_audits')
                    <div class="form-group">
                        {!! Form::label('audit_note', trans('Note'), ['class' => 'control-label']) !!}
                        {!! Form::textarea('audit_note', null, ['class' => 'form-control', 'rows' => 5, 'disabled']) !!}
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="corrective-and-preventive-actions-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    @include('management_review_meetings._capas')
                </div>
            </div>
            <div class="tab-pane" id="resource-review-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    <h4>{{ trans('Revizuirea resurselor necesare pentru menținerea și îmbunătățirea eficacității organizației') }}</h4>
                    <div class="form-group marginT30">
                        {!! Form::label('infrastructure', trans('Mediul de Lucru, infrastructura'), ['class' => 'control-label']) !!}
                        {!! Form::text('infrastructure', null, ['class' => 'form-control', 'disabled']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('qms', trans('Cerințele QMS'), ['class' => 'control-label']) !!}
                        {!! Form::text('qms', null, ['class' => 'form-control', 'disabled']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('hr', trans('Resurse Umane'), ['class' => 'control-label']) !!}
                        {!! Form::text('hr', null, ['class' => 'form-control', 'disabled']) !!}
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="review-of-training-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    @include('management_review_meetings._education')
                    <div class="form-group">
                        {!! Form::label('education_note', trans('Note'), ['class' => 'control-label']) !!}
                        {!! Form::textarea('education_note', null, ['class' => 'form-control', 'rows' => 5, 'disabled']) !!}
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="supplier-review-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    @include('management_review_meetings._suppliers')
                </div>
            </div>
            <div class="tab-pane" id="revision-of-objectives-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    @include('management_review_meetings._processes_view')
                </div>
            </div>
            <div class="tab-pane" id="customer-feedback-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    <div class="form-group">
                        {!! Form::label('customer_feedback_note', trans('Note'), ['class' => 'control-label']) !!}
                        {!! Form::textarea('customer_feedback_note', null, ['class' => 'form-control', 'rows' => 5, 'disabled']) !!}
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="overall-performance-of-the-integrated-management-system-container" role="tabpanel">
                <div class="col-xs-12 marginR15">
                    <div class="form-group">
                        {!! Form::label('integrated_management_system_note', trans('Note'), ['class' => 'control-label']) !!}
                        {!! Form::textarea('integrated_management_system_note', null, ['class' => 'form-control', 'rows' => 5, 'disabled']) !!}
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('content-scripts')
    <script type="application/javascript">
        apply_filters(jQuery('.list-container'));
    </script>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        //Scrollable nav-bar script
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
