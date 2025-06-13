@extends('app')

@section('title') {{ trans('Mesaje') }} @endsection

@section('content')
    <div class="sidebar lg white scrollbox">

        <ul class="nav nav-tabs nav-justified">
            <li @if($rooms->count() > 0) class="active" @endif><a href="#home" id="home-selector" aria-controls="home" data-toggle="tab">{{ trans('Mesaje recente') }}</a></li>
            <li @if($rooms->count() == 0) class="active" @endif><a href="#profile" id="profile-selector" aria-controls="profile" data-toggle="tab">{{ trans('Mesaj nou') }}</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane @if($rooms->count() > 0) active @endif" id="home">
                        <ul class="users-messages-list">
                            @include('messages._rooms')
                        </ul>
                        <div class="text-center" id="roomPaginator">
                            @section('room_paginator')
                                @if($rooms)
                                    @if($rooms->hasMorePages())
                                        <!-- @todo translate this to RO -->
                                            <a class="btn btn-primary" id="loadMoreMessages" data-href="{{ $rooms->nextPageUrl() }}">Load more</a>

                                    @endif
                                @endif
                            @show
                        </div>
            </div>
            <div class="tab-pane @if($rooms->count() == 0) active @endif" id="profile">
                    <ul class="messages-users-list">
                        <div class="form-group search-users">
                        {!! Form::label('participants', 'Search users', ['class' => 'control-label']) !!}
                        {!! Form::text('participants', null, ['class' => 'form-control', 'id' => 'participants']) !!}
                        </div>
                        <ul class="participant-list hidden"></ul>
                        @include('messages._participants')
                    </ul>
            </div>
        </div>

    </div>
    <div class="content-fluid offset-lg content-messages">
        <div class="messages-container">
            <div class="messages scrollbox">
                @include('messages._messages')
            </div>
            <div class="message-input-container form-group">
                {!! Form::label('message', trans('Mesaj'), ['class' => 'control-label']) !!}
                @if($activeRoom)
                    {!! Form::text('message', null, ['class' => 'form-control', 'data-room' => $activeRoom->id]) !!}
                @else
                    {!! Form::text('message', null, ['class' => 'form-control', 'data-room' => '0']) !!}
                @endif
            </div>
        </div>
    </div>
@endsection

@section('content-scripts')
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('.user-select').click(function() {
                if ($(this).is(':checked')) {
                    $(this).parents('li').addClass('active');
                }
                else {
                    $(this).parents('li').removeClass('active');
                }
            });

            //set height of messages container
            $('.messages-container .messages').height($(window).outerHeight() - $('.content-wrapper .navbar').outerHeight() - $('.content-wrapper .header').outerHeight() - 65 /*padding*/);
            $(window).resize(function() {
                $('.messages-container .messages').height($(window).outerHeight() - $('.content-wrapper .navbar').outerHeight() - $('.content-wrapper .header').outerHeight() - 65 /*padding*/);
            });

            // init popovers
            $("[data-toggle=popover]").popover({
                html : true,
                content: function() {
                    var content = $(this).attr("data-popover-content");
                    return $(content).children(".popover-body").html();
                },
                title: function() {
                    var title = $(this).attr("data-popover-content");
                    return $(title).children(".popover-heading").html();
                }
            });



            /**
             * Messagerooms paginator
             */
            $(document).on('click', '#loadMoreMessages', function(e){
                var url = $(this).attr('data-href');
                $(this).remove();
                $.ajax({
                    url : url,
                    method: 'GET',
                    data: {},
                    success: function(response){
                        var json = JSON.parse(response);
                        $('.users-messages-list').append(json.rooms);
                        $('#roomPaginator').append(json.roomPaginator);
                    },
                    error: function(response){
                        console.log(response);
                    }
                });
                e.preventDefault();
            });

            /**
             * Change room
             */
            $(document).on('click', '.user-message', function(e){
                $('.user-message').removeClass('active');
                $(this).addClass('active');
                $('#message').attr('data-room', $(this).attr('data-id'));
                var url = $(this).attr('data-href');
                var data = {
                    "_token": "{{ csrf_token() }}"
                };

                getMessages(url, data);

                e.preventDefault();

            });

            $(document).on('click', '#profile-selector', function(){
                $('#message').attr('data-room', '0');
                $('.messages.scrollbox').html('');
            });

            $(document).on('click', '#home-selector', function(){
                $('#message').attr('data-room', $('.user-message.active').attr('data-id'));
                var url = $('.user-message.active').attr('data-href');
                var data = {
                    "_token": "{{ csrf_token() }}"
                };

                getMessages(url, data);
            });

            $(document).on('click', '.user-select', function(e){
               if(!$(this).is(':checked')){
                   $(this).parent().remove();
               }
            });

            var req = null;

            $(document).on('keyup', '#participants', function() {
                if (req != null) req.abort();
                var value = $(this).val();
                var participants = [];
                if($('.user-select').length > 0){
                    $('.user-select').each(function(){
                        participants.push($(this).val());
                    })
                }

                req = $.ajax({
                    type: "POST",
                    url: "{{ action('MessagesController@get_participants') }}",
                    data: {"s": value, "participants": participants, "_token": "{{ csrf_token() }}"},
                    dataType: "text",
                    success: function (response) {
                        if (response != 0) {
                            $('.participant-list').html(response).removeClass('hidden');
                        }
                        else{
                            $('.participant-list').html('').addClass('hidden');
                        }
                    }
                });
            });

            $(document).on('click', '.participant-add', function(e){
                var id = $(this).attr('data-id');
                sendRequest(
                    '{{ action('MessagesController@add_participant') }}',
                    'POST',
                    {
                        "id": id,
                        "_token": "{{ csrf_token() }}"
                    },
                    function(response){
                        if(response != 0){
                            $('.messages-users-list').append(response);
                            $('.participant-list').html('').addClass('hidden');
                            $('#participants').val('');
                        }
                    }
                );
                e.preventDefault();
            });

            /**
             * Send message
             */
            $(document).keydown(function (e) {
                if (e.which == 13 && $('#message').is(':focus')) {
                    if( $('#message').val().trim() != ''){
                        var message = $('#message').val();
                        $('#message').val('');
                        var participants = [];
                        if($('.user-select').length > 0){
                            $('.user-select').each(function(){
                                participants.push($(this).val());
                            })
                        }
                        var room = $('#message').attr('data-room');
                        var data ={
                            "_token": "{{ csrf_token() }}",
                            "message" : message,
                            "room_id" : room,
                            "participants": participants
                        };

                        sendRequest(
                          '{{ action('MessagesController@store') }}',
                          'POST',
                           data,
                           function(response){
                              if(! $.isNumeric(response)){
                                  // append message and scroll down
                                  $('.messages.scrollbox').append(response)
                                          .animate({ scrollTop: $('.messages.scrollbox').prop("scrollHeight")}, 300);
                              }
                              else{
                                  window.location.href = '{{ action('MessagesController@index')  }}';
                              }
                           }
                        );
                    }
                }
            });
        });

        /**
         * Send ajax request
         */
        function sendRequest(url, method, data, successCallback){
            jQuery.ajax({
                url: url,
                method: method,
                data: data,
                success: successCallback,
                error: function(response){
                    console.log(response);
                }
            })
        }

        /**
         * Get room messages
         * @param url
         * @param data
         */
        function getMessages(url, data){
            sendRequest(
                    url,
                    'POST',
                    data,
                    function(response){
                        jQuery('.messages.scrollbox').html(response).animate({ scrollTop: jQuery('.messages.scrollbox').prop("scrollHeight")}, 300);
                    }
            );
        }

    </script>
@endsection
