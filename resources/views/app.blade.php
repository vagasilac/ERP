<!DOCTYPE html>
<html lang="en" ng-app="steiger">
<head>
    <title>Steiger ERP</title>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="{{ asset('css/app.css') }}?v={{ time() }}" rel="stylesheet" />
    @yield ('css')

    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script>window.Modernizr || document.write('<script src="{{ asset('js/modernizr-2.8.3.min.js') }}"><\/script>')</script>

</head>
<body data-spy="scroll" data-target="#scroll_spy">
    <div class="relative">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ action('HomeController@index') }}"><img src="{{ asset('img/steiger.png') }}" alt="Steiger" class="marginR5"> Steiger ERP</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    @if (Auth::check())
                        <ul class="nav navbar-nav">
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" >{{ trans('Proiecte') }} <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    @if (Auth::user()->hasRole('Tehnolog'))
                                        <li><a href="{{ action('ProjectsController@index') }}?#user={{ Auth::id() }}">{{ trans('Proiectele mele') }}</a></li>
                                        <li><a href="{{ action('ProjectsController@index') }}?type=offer#user={{ Auth::id() }}&type=offer">{{ trans('Ofertele mele') }}</a></li>
                                        <li><a href="{{ action('ProjectsController@index') }}?type=work#user={{ Auth::id() }}&type=work">{{ trans('Proiectele mele în execuție') }}</a></li>
                                        <li><a href="{{ action('ProjectsController@index') }}?type=executed#user={{ Auth::id() }}&type=executed">{{ trans('Proiectele mele executate') }}</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="{{ action('ProjectsController@index') }}">{{ trans('Toate proiectele') }}</a></li>
                                    @else
                                        <li><a href="{{ action('ProjectsController@index') }}">{{ trans('Toate proiectele') }}</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="{{ action('ProjectsController@index') }}?type=offer#type=offer">{{ trans('Oferte') }}</a></li>
                                        <li><a href="{{ action('ProjectsController@index') }}?type=work#type=work">{{ trans('Proiecte în execuție') }}</a></li>
                                        <li><a href="{{ action('ProjectsController@index') }}?type=executed#type=executed">{{ trans('Proiecte executate') }}</a></li>
                                    @endif
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ action('ProjectsController@gantt') }}">{{ trans('GANTT') }}</a></li>
                                </ul>

                            </li>
                            <li class="dropdown">
                                <a href="{{ action('InventoryController@index') }}">{{ trans('Aprovizionare') }}</a>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" >{{ trans('CTC') }} <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ action('DocumentsQcController@index') }}">{{ trans('Documente QC') }}</a></li>
                                    <li><a href="{{ action('ReceivingMaterialsController@index') }}">{{ trans('Recepția materialelor') }}</a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" >{{ trans('Angajați și parteneri') }} <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ action('UsersController@index') }}">{{ trans('Angajați') }}</a></li>
                                    <li><a href="{{ action('RolesController@index') }}">{{ trans('Roluri de utilizator') }}</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ action('CustomersController@index') }}">{{ trans('Clienți') }}</a></li>
                                    <li><a href="{{ action('SuppliersController@index') }}">{{ trans('Furnizori aprobați') }}</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="{{ action('TimeTrackingController@index') }}">{{ trans('Terminal atelier') }}</a>
                            </li>
                            <li class="dropdown">
                                <a href="{{ action('InternalRegulationController@index') }}">{{ trans('Regulament intern') }}</a>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown">{{ trans('HR') }} <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ action('EducationController@index') }}">{{ trans('Instruiri comune') }}</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown">{{ trans('Registre') }} <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ action('InputsOutputsRegisterController@index') }}">{{ trans('Registru intrare-ieșire') }}</a></li>
                                    <li><a href="{{ action('ContractRegisterController@index') }}">{{ trans('Registru contracte') }}</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown">{{ trans('IMS') }} <span class="caret"></span></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-toggle" data-toggle="dropdown">{{ trans('QMS') }}</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ action('MachinesController@index') }}">{{ trans('Utilaje') }}</a></li>
                                            <li class="dropdown-submenu">
                                                <a class="dropdown-toggle" data-toggle="dropdown">{{ trans('EMM') }}</a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="{{ action('MeasuringEquipmentsController@index') }}">{{ trans('Echipamente') }}</a></li>
                                                    <li><a href="{{ action('RulersController@index') }}">{{ trans('Rulete') }}</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="{{ action('ComplaintsController@index') }}">{{ trans('Reclamații') }}</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-toggle" data-toggle="dropdown">{{ trans('COTO') }}</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ action('CotoPartiesController@index') }}">{{ trans('Părți') }}</a></li>
                                            <li><a href="{{ action('CotoIssuesController@index') }}">{{ trans('Aspecte') }}</a></li>
                                            <li><a href="{{ action('CotoRiskRegistersController@index') }}">{{ trans('Riscuri') }}</a></li>
                                            <li><a href="{{ action('CotoOpportunityRegistersController@index') }}">{{ trans('Oportunități') }}</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ action('OrganizationalChartController@index') }}">{{ trans('Organigrama') }}</a></li>
                                    <li class="dropdown-submenu">
                                        <a href="dropdown-toggle" data-toggle="dropdown">{{ trans('Standarde de referință') }}</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ url('standarde-de-referinta', ['1', 'ro']) }}">{{ trans('EN 1090-1') }}</a></li>
                                            <li><a href="{{ url('standarde-de-referinta', ['2', 'ro']) }}">{{ trans('EN 1090-2') }}</a></li>
                                            <li><a href="{{ url('standarde-de-referinta', ['3', 'ro']) }}">{{ trans('ISO 3834-2') }}</a></li>
                                            <li><a href="{{ url('standarde-de-referinta', ['4', 'ro']) }}">{{ trans('ISO 9001') }}</a></li>
                                            <li><a href="{{ url('standarde-de-referinta', ['5', 'ro']) }}">{{ trans('ISO 14001') }}</a></li>
                                            <li><a href="{{ url('standarde-de-referinta', ['6', 'ro']) }}">{{ trans('OHSAS 18001') }}</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ action('CapasController@index') }}">{{ trans('Acțiuni corective și preventive') }}</a></li>
                                    <li><a href="{{ action('EmergencyReportsController@create') }}">{{ trans('Rapoarte de urgență') }}</a></li>
                                    <li><a href="{{ action('InternalAuditsController@index') }}">{{ trans('Audit intern') }}</a></li>
                                    <li><a href="{{ action('ManagementReviewMeetingsController@index') }}">{{ trans('Analiza efectuata de management') }}</a></li>
                                    <li><a href="{{ action('DocumentationsController@index') }}">{{ trans('Documentație') }}</a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown">{{ trans('Certificate') }} <span class="caret"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ action('CertificatesController@index', ['1', 'ro']) }}">{{ trans('Autorizație de Mediu') }}</a></li>
                                        <li><a href="{{ action('CertificatesController@index', ['2', 'ro']) }}">{{ trans('STEIGER 1090 1-2') }}</a></li>
                                        <li><a href="{{ action('CertificatesController@index', ['3', 'ro']) }}">{{ trans('STEIGER 3834 2') }}</a></li>
                                        <li><a href="{{ action('CertificatesController@index', ['4', 'ro']) }}">{{ trans('STEIGER 9001 14001 18001') }}</a></li>
                                        <li><a href="{{ action('DiplomasController@index') }}">{{ trans('Diplome') }}</a></li>
                                    </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown">{{ trans('Setări') }} <span class="caret"></span></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{ action('SettingsController@materials') }}">{{ trans('Materiale') }}</a></li>
                                    <li><a href="{{ action('SettingsController@standards') }}">{{ trans('Standarde') }}</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="nav navbar-nav navbar-right">
                            <div class="dropdown user-account">
                                <a class="btn" id="user-account-toggle" data-toggle="dropdown" accesskey="u"><span class="profile-picture placeholder">{{ substr(Auth::user()->lastname, 0, 1) }}{{ substr(Auth::user()->firstname, 0, 1) }}</span><span class="user-name">{{ Auth::user()->lastname }} {{ Auth::user()->firstname }}</span></a>
                                <div class="dropdown-menu dropdown-menu-right popover bottom" role="menu" aria-labelledby="user-account-toggle">
                                    <div class="arrow"></div>
                                    <div class="popover-title"><span class="profile-picture placeholder">{{ substr(Auth::user()->lastname, 0, 1) }}{{ substr(Auth::user()->firstname, 0, 1) }}</span><span class="user-name">{{ Auth::user()->lastname }} {{ Auth::user()->firstname }}<br><span class="account-type">{{ Auth::user()->roles[0]->name }}</span></span></div>
                                    <div class="popover-content">
                                        <ul class="nav" role="menu">
                                            <li><a href="{{ action('ProfileController@edit') }}">{{ trans('Profilul meu') }}</a></li>
                                            <li><a href="{{ url('/logout') }}">{{ trans('Log out') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown messages">
                                <a href="#" id="messages-toggle" class="icon icon-notes" data-toggle="dropdown" accesskey="n">@if($unreadMessages > 0)<span class="badge messages-count">{{ $unreadMessages }}</span>@endif</a>
                                <div class="dropdown-menu dropdown-menu-right popover bottom" role="menu" aria-labelledby="user-account-toggle">
                                    <div class="arrow"></div>
                                    <div class="popover-title">{{ trans('Mesaje') }}</div>
                                    <div class="popover-content">
                                        <ul class="nav" role="menu">
                                            @foreach($userRooms as $userRoom)
                                                <li @if($userRoom->lastMessage()->seen(\Illuminate\Support\Facades\Auth::user()->id)->count() > 0) class="new" @endif>
                                                    <a href="{{ action('MessagesController@index', $userRoom->id) }}">
                                                        <b>{{ $userRoom->participants->first()->user->firstname }} {{ $userRoom->participants->first()->user->lastname }}
                                                            @if($userRoom->participants->count() > 1)
                                                                and {{ $userRoom->participants->count() - 1 }} others
                                                            @endif</b><br/>
                                                        {{str_limit($userRoom->lastMessage()->message, 80) }}<br/>
                                                        <span class="time">{{ $userRoom->messages()->first()->created_at->format('d/m/Y H:i') }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="popover-footer">
                                        <a href="{{ action('MessagesController@index') }}">{{ trans('Vezi toate mesajele') }}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown notifications">
                                <a href="#" id="notifications-toggle" class="icon icon-alert" data-toggle="dropdown" accesskey="a">@if($unreadNotifications > 0)<span class="badge messages-count">{{ $unreadNotifications }}</span>@endif</a>
                                <div class="dropdown-menu dropdown-menu-right popover bottom" role="menu" aria-labelledby="user-account-toggle">
                                    <div class="arrow"></div>
                                    <div class="popover-title">{{ trans('Notificări') }}</div>
                                    <div class="popover-content">
                                        <ul class="nav" role="menu">
                                            @if (count(\Illuminate\Support\Facades\Auth::user()->notifications))
                                                @foreach (\Illuminate\Support\Facades\Auth::user()->notifications()->orderBy('timestamp', 'desc')->take(5)->get() as $notification)
                                                    <li class="@if (!$notification->getReadAttribute()) new @endif" data-toggle="notification" data-action="{{ action('NotificationsController@mark_read', $notification->id) }}">{!! substr_replace($notification->message, '<span class="time">' . $notification->timestamp->format('d/m/Y h:i') . '</span>', strpos($notification->message, '</a>'), 0) !!}</li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="popover-footer">
                                        <a href="{{ action('NotificationsController@index') }}">{{ trans('Vezi toate notificările') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="search">
                                <a href="#" id="search-toggle" class="icon icon-search" data-toggle="dropdown" accesskey="f"></a>
                            </div>
                        </div>
                    @endif
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class="header clearfix">
            <div class="col-xs-12"><h1>@yield('title')</h1></div>
        </div>

        @yield('content')

        <div id="alert-container"><div class="alert">Success</div></div>
    </div>


    @yield('content-modals')

    <!-- jQuery CDN	-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script>!window.jQuery && document.write('<script src="{{ asset('js/jquery-2.2.0.min.js') }}"><\/script>')</script>

    <!-- Load bootstrap, our UI scripts and app specific scripts -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @yield ('content-scripts')

    @if (Session::has('success_msg'))
        <script type="text/javascript">	<!--
            jQuery(document).ready(function($) {
                var alert_container = $('#alert-container');
                alert_container.find('.alert').attr('class', '').addClass('alert alert-success').html('{{ Session::get('success_msg') }}')
                alert_container.slideDown().delay(4000).slideUp();
            });
            //-->
        </script>
    @endif

    @if (Session::has('error_msg'))
        <script type="text/javascript">	<!--
            jQuery(document).ready(function($) {
                var alert_container = $('#alert-container');
                alert_container.find('.alert').attr('class', '').addClass('alert alert-danger').html('{{ Session::get('error_msg') }}');
                alert_container.slideDown().delay(4000).slideUp();
            });
            //-->
        </script>
    @endif

</body>
</html>
