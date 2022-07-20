<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <meta http-equiv="refresh" content="7200;url={{url('logout',1)}}" />
    <link rel="shortcut icon" href="{{ url('favicon.ico') }}">

    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ url('/template_content') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/template_content') }}/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="{{ url('/template_content') }}/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="{{ url('/template_content') }}/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="{{ url('/template_content') }}/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="{{url('template_content')}}/assets/data-tables/DT_bootstrap.css">

    <!--right slidebar-->
    <link href="{{ url('/template_content') }}/css/slidebars.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <audio src="{{ url('tone.mp3') }}" id="new-call" ></audio>
    <link href="{{ url('/template_content') }}/css/style.css" rel="stylesheet">
    <link href="{{ url('/mp/MonthPicker.css') }}" rel="stylesheet">
    <link href="{{ url('/css') }}/custom.css" rel="stylesheet">
    <link href="{{ url('/template_content') }}/css/style-responsive.css" rel="stylesheet" />
    <link href="{{ url('/js') }}/owl/owl.css" rel="stylesheet" />
    <link href="{{ url('/js') }}/pnotify.custom.min.css" rel="stylesheet" />
    <script src="{{ url('/template_content') }}/js/jquery.js"></script>
    <script src="{{ url('/js') }}/owl/owl.carousel.min.js"></script>
    {{-- <script src="{{ url('js') }}/fancywebsocket.js"></script> --}}
    <script src="{{ url('js') }}/download.js"></script>
    <script src="{{ url('js') }}/print.js"></script>
    <script src="{{ url('/') }}/lodash.js"></script>
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="{{url('/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    <link href="{{url('/js/select2-bootstrap.css')}}" rel="stylesheet">
    <script src="{{ url('/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
    <link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

    <link rel="stylesheet" href="{{ asset('/pnotify/PNotifyBrightTheme.css') }}" />
    
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" id="theme-styles">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
      .select2-selection__rendered, .select2-container .select2-selection--single {
        height: 34px;
        outline: none !important;
      }
      .select2-container .select2-selection--single {
        padding: 2px 12px;
      }
      [id*="info-sub-"] .modal-body > div {
        overflow: auto;
        height: 70vh;
      }
      .hover-to-show span {
        display: none;
      }
      .hover-to-show:hover span {
        display: inline-block;
      }
      .adv-table .dataTables_filter label input {
        width: auto !important;
      }
      .dataTables_length, .dataTables_filter {
        padding: 0;
      }
      .panel-body .dropdown-menu-1 {
        height: 300px;
        overflow: auto;
      }
      #panel-imagenes {
        overflow-y: auto;
      }

      #sidebar {
        overflow: auto;
      }

      /* Hide default HTML checkbox */
    .switch input {display:none;}

    /* The slider */
    .bg-success {
      background-color: #2e9c00 !important;
    }
    .bg-warning {
      background-color: #d88900 !important;
    }
    .bg-danger {
      background-color: #ff4646 !important;
    }
    .sb-slidebar
    {
      height: auto;
    }
    .sb-slidebar ul {
      padding: 0 !important;
    }
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 3px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }

    .ev-emails {
      list-style: disc;
      margin: 8px 0;
    }
    </style>



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    {{-- <link rel="manifest" href="/manifest.json" />
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
      var OneSignal = window.OneSignal || [];
      OneSignal.push(function() {
        OneSignal.init({
          appId: "ef82e3a1-4933-4a6c-97a0-0bfef67377a7",
        });
      });
    </script> --}}
  </head>

  <body>

  <section id="container" >
      <!--header start-->
      <header class="header white-bg">
              <div class="sidebar-toggle-box">
                  <i class="fa fa-bars"></i>
              </div>
            <!--logo start-->
            <a href="{{ url('/') }}" class="logo hidden-xs">
              {{-- Ren<span>ova</span> --}}
              <img src="{{ url('renova.png') }}" alt="" width="100px" style="top:-6px;position:relative;">
            </a>
            <!--logo end-->
            <div class="top-nav ">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <li>
                        <input type="text" class="form-control search" placeholder="Search">
                    </li>
                    <!-- user login dropdown start-->
                    <li class="dropdown" style="margin-top: 4px;">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            {{-- <img alt="" src="{{ url('assets/logo2.png') }}" width="32"> --}}
                            <span class="username">{{ Auth::user()->fullname() }}</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            {{-- <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                            <li><a href="#"><i class="fa fa-bell-o"></i> Notification</a></li> --}}
                            <li><a href="{{ url('logout') }}"><i class="fa fa-key"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <li class="sb-toggle-right">
                        <i class="fa  fa-align-right"></i>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
      <!--header end-->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              @php
                $route = explode('/',Request()->path());
              @endphp
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">

                  <li class="sub-menu">
                    <a href="{{url('admin/dashboard')}}" class="{{ @$route[1] == 'dashboard' ? 'active dcjq-parent' : 'dcjq-parent' }}">
                      <i class="fa fa-dashboard"></i>
                      <span>Dashboard</span>
                    </a>
                  </li>
                  
                  @if (/*@Auth::user()->operator->ec == 1 || Auth::user()->role_id == -1*/true)

                  @php
                      $unrated = App\Reservation::whereNotExists(function($q){
                          $q->from('questions')
                            ->whereRaw('questions.reservation_id = reservations.id');
                      })->whereExists(function($q){
                          $q->from('users')
                            ->whereRaw('users.id = reservations.customer_id')
                            ->whereExists(function($q){
                              $q->from('web_app_users')
                                  ->whereRaw('web_app_users.user_id = users.id');
                            });
                      })->count();

                      $qcount = App\Question::count();

                      $totales = $unrated+$qcount;
                    @endphp

                    @if(@Auth::user()->operator->ec == 1 || Auth::user()->role_id == -1)

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-globe"></i>
                            <span>WebApp</span>
                        </a>
                        <ul class="sub">
                          <li class="{{ @$route[1] == 'web-app' ? 'active zp' : '' }}"><a href="{{ url('admin/web-app') }}">
                            <i class="fa fa-link"></i>
                          Links</a></li>
                          <li>
                            <a href="javascript:;"><img src="{{url('assets/icono-02-b.png')}}" alt="" style="width: 15px"> &nbsp;
                              {{ number_format((App\Question::where('rate',2)->count()*100)/$totales,2).'% ('.App\Question::where('rate',2)->count().')' }} </a>
                          </li>

                          <li>
                            <a href="javascript:;"><img src="{{url('assets/icono-03-b.png')}}" alt="" style="width: 15px"> &nbsp;
                              {{ number_format((App\Question::where('rate',3)->count()*100)/$totales,2).'% ('.App\Question::where('rate',3)->count().')' }} </a>
                          </li>

                          <li>
                            <a href="javascript:;"><img src="{{url('assets/icono-04-b.png')}}" alt="" style="width: 15px"> &nbsp;
                              {{ number_format((App\Question::where('rate',4)->count()*100)/$totales,2).'% ('.App\Question::where('rate',4)->count().')' }} </a>
                          </li>

                          <li>
                            <a href="javascript:;"><img src="{{url('assets/neutral.svg')}}" alt="" style="width: 15px"> &nbsp;
                                {{number_format(($unrated*100)/$totales,2).'% ('.$unrated.')' }} </a>
                          </li>

                          <li>
                            <a href="javascript:;"><img src="{{url('assets/icono-full.png')}}" alt="" style="width: 15px"> &nbsp;
                              Totale ({{ App\Question::whereIn('rate',[2,3,4])->count()+$unrated }}) </a>
                          </li>
                        </ul>
                    </li>

                    @endif

                    @if (@Auth::user()->operator->ap == 1 || Auth::user()->role_id == -1)
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-handshake-o"></i>
                            <span>AUTOPerizia</span>
                        </a>
                        <ul class="sub">
                          <li class="{{ @$route[1] == 'self-management-links' ? 'active zp' : '' }}"><a href="{{ url('admin/self-management-links') }}">
                            <i class="fa fa-link"></i>
                          Links</a></li>

                          <li class="{{ @$route[1] == 'self-management' ? 'active zp' : '' }}"><a href="{{ url('admin/self-management') }}">
                            <i class="fa fa-file"></i>
                          AUTOPer. in gestione</a></li>

                          <li class="{{ @$route[1] == 'self-management-closed' ? 'active zp' : '' }}"><a href="{{ url('admin/self-management-closed') }}">
                            <i class="fa fa-file"></i>
                          AUTOPer. chiuse</a></li>
                        </ul>
                    </li>
                    @endif

                    @if(@Auth::user()->operator->ec == 1 || Auth::user()->role_id == -1)

                    <li class="sub-menu">
                      <a href="javascript:;">
                          <i class="fa fa-id-badge"></i>
                          <span>App</span>
                      </a>
                      <ul class="sub">
                        <li class="{{ @$route[1].'/'.@$route[2] == 'preassign/' ? 'active zp' : '' }}">
                            <a href="{{ url('admin/preassign') }}">
                                <i class="fa fa-user"></i>
                                <span>Pre-abbinare</span>
                            </a>
                        </li>

                        <li class="{{ @$route[1] == 'requests' ? 'active zp' : '' }}">
                            <a href="{{ url('admin/requests') }}">
                                <i class="fa fa-phone"></i>
                                <span>Link utenti</span>
                            </a>
                        </li>
                      </ul>
                    </li>

                    @endif

                    @if(@Auth::user()->operator->ec == 1 || Auth::user()->role_id == -1)
                    <li class="sub-menu">
                      <a href="javascript:;">
                          <i class="fa fa-video-camera"></i>
                          <span>Video-perizie</span>
                      </a>
                      <ul class="sub">

                        @if(@Auth::user()->operator->ec == 1 && Auth::user()->role_id != -1)
                        <li class="{{ @$route[1].'/'.@$route[2] == 'videocalls/' ? 'active zp' : '' }}">
                            <a href="{{ url('admin/videocalls') }}">
                                <i class="fa fa-video-camera"></i>
                                <span>Videochiamate</span>
                            </a>
                        </li>
                        @endif
                        <li class="{{ @$route[1] == 'sinister' ? 'active zp' : '' }}">
                            <a href="{{ url('admin/sinister') }}">
                                <i class="fa fa-file-text-o"></i>
                                <span>Sinistri in gestione</span>
                            </a>
                        </li>

                        @if(@Auth::user()->operator->ec == 1 && Auth::user()->role_id != -1)
                          <li class="{{ @$route[1].'/'.@$route[2] == 'all-sinister/' ? 'active zp' : '' }}">
                              <a href="{{ url('admin/all-sinister') }}">
                                  <i class="fa fa-file-text"></i>
                                  <span>Sinistri aperti tot</span>
                              </a>
                          </li>
                        @endif

                        <li class="{{ @$route[1].'/'.@$route[2] == 'historial/' ? 'active zp' : '' }}">
                            <a href="{{ url('admin/historial') }}">
                                <i class="fa fa-times"></i>
                                <span>Sinistri chiusi</span>
                            </a>
                        </li>

                        <li class="{{ @$route[1].'/'.@$route[2] == 'videochiamate-mensili/' ? 'active zp' : '' }}">
                            <a href="{{ url('admin/videochiamate-mensili') }}">
                                <i class="fa fa-clock-o"></i>
                                <span>Videochiam. mensili </span>
                            </a>
                        </li>
                      </ul>
                    </li>
                    @endif

                  {{-- @endif

                  @if (Auth::user()->role_id != 2 && Auth::user()->role_id != 3) --}}

                  @endif

                  @if (Auth::user()->role_id == -1)

                    <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-users"></i>
                            <span>Utenti</span>
                        </a>
                        <ul class="sub">
                            <li class="{{ @$route[1].'/'.@$route[2] == 'accertatore/' ? 'active zp' : '' }}"><a href="{{ url('admin/accertatore') }}">Accertatori</a></li>
                            <li class="{{ @$route[1].'/'.@$route[2] == 'customers/' ? 'active zp' : '' }}"><a href="{{ url('admin/customers') }}">Clienti App</a></li>
                            <li class="{{ @$route[1].'/'.@$route[2] == 'web-app-2/' ? 'active zp' : '' }}"><a href="{{ url('admin/web-app-2') }}">Clienti WebApp</a></li>
                            <li class="{{ @$route[1].'/'.@$route[2] == 'self-management-links-2/' ? 'active zp' : '' }}"><a href="{{ url('admin/self-management-links-2') }}">Clienti AUTOPerizia</a></li>
                            {{-- <li class="{{ @$route[1].'/'.@$route[2] == 'operators/' ? 'active zp' : '' }}"><a href="{{ url('admin/operators') }}">Operatori</a></li> --}}
                        </ul>
                    </li>

                  @endif

                  @if (Auth::user()->role_id == -1)
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-comments-o"></i>
                            <span>SMS</span>
                        </a>
                        <ul class="sub">
                          <li class="{{ @$route[1] == 'sms' ? 'active zp' : '' }}"><a href="{{ url('admin/sms') }}">Inviare SMS</a></li>
                          <li class="{{ @$route[1] == 'predefiniti' ? 'active zp' : '' }}"><a href="{{ url('admin/predefiniti') }}">SMS Predefiniti</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="#smspassword" data-toggle="modal">
                            <i class="fa fa-user"></i>
                            <span>SMS Password</span>
                        </a>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-building-o"></i>
                            <span>DDBB</span>
                        </a>
                        <ul class="sub">
                          <li class="{{ @$route[1] == 'compagnia' ? 'active zp' : '' }}"><a href="{{ url('admin/compagnia') }}">Compagnia</a></li>
                          <li class="{{ @$route[1] == 'modello-di-polizza' ? 'active zp' : '' }}"><a href="{{ url('admin/modello-di-polizza') }}">Modello di polizza</a></li>
                          <li class="{{ @$route[1] == 'tipologia-di-danno' ? 'active zp' : '' }}"><a href="{{ url('admin/tipologia-di-danno') }}">Tipologia di danno</a></li>
                        </ul>
                    </li>

                  @endif


                  @if(@Auth::user()->operator->ec == 1 && Auth::user()->role_id != -1)
                  <li class="sub-menu">
                      <a href="javascript:;">
                          <i class="fa fa-comments-o"></i>
                          <span>SMS</span>
                      </a>
                      <ul class="sub">
                        <li class="{{ @$route[1] == 'sms' ? 'active zp' : '' }}"><a href="{{ url('admin/sms') }}">Inviare SMS</a></li>
                        <li class="{{ @$route[1] == 'predefiniti' ? 'active zp' : '' }}"><a href="{{ url('admin/predefiniti') }}">SMS Predefiniti</a></li>
                      </ul>
                  </li>
                  @endif
                  @if(Auth::user()->role_id == -1)
                  {{-- <li class="sub-menu">
                      <a href="javascript:;">
                          <i class="fa fa-building-o"></i>
                          <span>DDBB</span>
                      </a>
                      <ul class="sub">
                        <li class="{{ @$route[1] == 'modello-di-polizza' ? 'active zp' : '' }}"><a href="{{ url('admin/modello-di-polizza') }}">Modello di polizza</a></li>
                      </ul>
                  </li> --}}
                  
                  @endif
                  @if (@Auth::user()->operator->et == 1 || Auth::user()->role_id == -1)
                  <li class="sub-menu">
                      <a href="javascript:;" class="dcjq-parent active">
                          <i class="fa fa-cog"></i>
                          <span>ExpressTech</span>
                      </a>
                      <ul class="sub" style="display: block;">
                        @if (@Auth::user()->operator->et == 1 || Auth::user()->role_id == -1)
                        <li><a href="#new-sinister-tech" data-toggle="modal">Nuovo sinistro</a></li>
                        @endif
                        <li class="{{ @$route[1].'/'.@$route[2] == 'express-tech/elenco' ? 'active' : '' }}"><a href="{{ url('admin/express-tech/elenco') }}">Sinistri in gestione</a></li>
                        <li class="{{ @$route[1].'/'.@$route[2] == 'express-tech/chiusi' ? 'active' : '' }}"><a href="{{ url('admin/express-tech/chiusi') }}">Sinistri chiusi</a></li>
                        @if (Auth::user()->role_id == -1)
                        <li class="{{ @$route[1].'/'.@$route[2] == 'express-tech/emails' ? 'active' : '' }}"><a href="{{ url('admin/express-tech/emails') }}">E-mail Predefiniti</a></li>
                        @endif
                      </ul>
                  </li>
                  @endif

                  @if (@Auth::user()->operator->mp == 1 || Auth::user()->role_id == -1)
                    <li class="sub-menu">
                        <a href="{{url('admin/mappa')}}" class="{{ @$route[1] == 'mappa' ? 'active dcjq-parent' : 'dcjq-parent' }}">
                            <i class="fa fa-map-marker"></i>
                            <span>Mappe sopralluogo</span>
                        </a>
                    </li>

                    <li class="sub-menu">
                        <a href="{{url('admin/situazione-generale')}}" class="{{ @$route[1] == 'situazione-generale' ? 'active dcjq-parent' : 'dcjq-parent' }}">
                            <i class="fa fa-map-o"></i>
                            <span>Situazione Generale</span>
                        </a>
                    </li>

                    <li class="sub-menu">
                        <a href="{{url('admin/calendario')}}" class="{{ @$route[1] == 'calendario' ? 'active dcjq-parent' : 'dcjq-parent' }}">
                            <i class="fa fa-calendar"></i>
                            <span>Calendario</span>
                        </a>
                    </li>

                    <li class="sub-menu">
                        <a href="{{url('admin/tipologie')}}" class="{{ @$route[1] == 'tipologie' ? 'active dcjq-parent' : 'dcjq-parent' }}">
                            <i class="fa fa-flash"></i>
                            <span>Tipologie</span>
                        </a>
                    </li>
                  @endif

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
            @yield('content')
          </section>
      </section>
      <!--main content end-->
      <!-- Right Slidebar start -->
      <div class="sb-slidebar sb-right sb-style-overlay">
          <h5 class="side-title">Spazio sul server</h5>
          <ul class="quick-chat-list">
              <li class="online">
                  @php
                    $cien = disk_total_space("/var/www/vhosts/expressclaims.it")/pow(10,9);
                    $libr = disk_free_space("/var/www/vhosts/expressclaims.it")/pow(10,9);

                    $used = $cien - $libr;

                    $perc = number_format(((($libr / $cien) * 100)),4);

                    $_used = 100-$perc;

                    if ($_used <= 50) {
                      $badge = "bg-success";
                    }elseif($_used > 50 && $_used < 70){
                      $badge = "bg-warning";
                    }elseif($_used >= 70){
                      $badge = "bg-danger";
                    }
                  @endphp

                  <div class="progress">
                    <div class="progress-bar progress-bar-striped {{$badge}}" role="progressbar" style="width: {{($_used).'%'}}" aria-valuenow="{{$perc}}" aria-valuemin="0" aria-valuemax="100">{{$_used}}%</div>
                  </div>
              </li>

              <li class="online">

                <b>Totale:</b> {{number_format($cien,4)}} GB <br>
                <b>Usato:</b> {{number_format($used,4)}} GB <br>
                <b>Disponibile:</b> {{number_format($libr,4)}} GB

              </li>
          </ul>
      </div>

      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              {{ date('Y') }} &copy; Renova
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>

      @if (@Auth::user()->operator->et == 1 || Auth::user()->role_id == -1)

      <div class="modal fade" id="new-sinister-tech">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">Nuovo Sinistro</div>
            <form action="{{ url('api/checkBack') }}" method="POST" class="modal-body assign-street">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Riferimento interno</label>
                    <input type="text" name="sin_number" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="">Ripeti Riferimento interno</label>
                    <input type="text" name="sin_number_confirmation" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="">Nome assicurato</label>
                    <input type="text" name="name" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="">Società</label>
                    <select class="form-control" name="society" id="">
                      <option>Renova</option>
                      <option>Studio Zappa</option>
                      <option>Gespea</option>
                    </select>
                  </div>
                  <div class="form-group" style="position: relative;">
                    <label for="">Sopralluoghista</label>
                    <select name="id" id="selected-street-operator" class="select2example form-control">
                        {{-- App\User::where(['role_id'=>2,'status'=>1])->orWhere(['role_id'=>1,'supervisor'=>1,'status'=>1])->get() as $op --}}
                      @foreach (
                        App\User::where('role_id','!=',-1)->where('role_id','!=',0)->where('status',1)->get() as $op
                        )

                        <option value="{{$op->id}}">{{$op->id}} - {{$op->fullname()}}</option>
                      @endforeach
                    </select>
                    {{-- <input type="text" id="street-operator-find" class="form-control"> --}}
                    {{-- <input type="hidden" name="id" id="selected-street-operator"> --}}

                    {{-- <div id="street-results" style="  position: absolute;
                                                      border: 1px solid silver;
                                                      width: 100%;
                                                      max-height: 200px;
                                                      z-index: 9999;
                                                      display: block;
                                                      background-color: #fff;
                                                      overflow: auto;
                                                      display: none;
                                                  ">
                      
                    </div> --}}
                    {{-- <select name="id" class="form-control" required="">
                      <option value="" selected disabled></option>
                      @foreach (App\User::where('role_id',2)->get() as $o)
                        <option value="{{ $o->id }}">{{ $o->name }}</option>
                      @endforeach
                    </select> --}}
                  </div>
                  <div class="form-group">
                    <label for="">Email da notificare alla chiusura 1</label>
                    <input type="text" name="email1" class="form-control" value="expresstech@studiozappa.com">
                  </div>
                </div>
                <div class="col-md-6">
                  <h5 style="margin-top: 0; margin-bottom: 8px;">Allegati</h5>
                  <input type="file" name="attachments[]" class="form-control">
                  <input type="file" name="attachments[]" class="form-control">
                  <input type="file" name="attachments[]" class="form-control">
                  <input type="file" name="attachments[]" class="form-control">
                  <input type="file" name="attachments[]" class="form-control">
                  <hr style="margin: 11px 0">
                  
                  <div class="form-group" style="position: relative;">
                    <label for="">Tipologia</label>
                    <select name="typology" id="typology" class="select2example form-control">
                      @foreach (App\Typology::get() as $tp)
                        <option value="{{$tp->id}}">{{$tp->short_name}} - {{$tp->long_name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group" style="position: relative;">
                    <label for="">Perito</label>
                    <select name="supervisor" id="selected-perito" class="select2example form-control">
                      <option value="" selected disabled></option>
                      @foreach (App\User::where(['supervisor'=>1,'status'=>1])->get() as $op)
                        <option value="{{$op->id}}">{{$op->id}} - {{$op->fullname()}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">Email da notificare alla chiusura 2</label>
                    <input type="text" name="email2" class="form-control">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Email predefiniti</label>
                    <select id="predefined-1" class="form-control">
                      <option value="" selected disabled></option>
                      @foreach (App\PredefinedMail::where('status',1)->get() as $mm)
                        <option value="{{$mm->predefined}}">{{$mm->title}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <textarea id="_predefined-1" class="form-control" rows="6"></textarea>
                  </div>
                </div>

              </div>
              <button class="btn btn-success">INVIA</button>
            </form>
          </div>
        </div>
      </div>

      <div class="modal fade" id="smspassword">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">Cambia la password SMS</div>
            <form action="{{ url('admin/smspassword') }}" method="POST" class="modal-body">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="">Actual Password</label>
                <input type="text" name="password" class="form-control" value="{{ App\SMSPassword::first() ? App\SMSPassword::first()->password : '' }}">
              </div>
              <button class="btn btn-success">SALVA</button>
            </form>
          </div>
        </div>
      </div>
      @endif
      <!--footer end-->
  </section>

  <style>
    .select-operator:hover {
      background-color: #ccc;
    }
  </style>

  <script>
    $('#predefined-1').change(function(event) {
      // $(this).find('.ckeditor').set
      $('#_predefined-1').val($(this).val());
    });

    $('.predefined-edit').change(function(event) {
      console.log($(this).data('id'))
      $($(this).data('id')).val($(this).val());
    });
  </script>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="{{ url('/template_content') }}/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="{{ url('/template_content') }}/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="{{ url('/template_content') }}/js/jquery.scrollTo.min.js"></script>
    {{-- <script src="{{ url('/template_content') }}/js/jquery.nicescroll.js" type="text/javascript"></script> --}}
    <script src="{{ url('/template_content') }}/js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="{{ url('/template_content') }}/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="{{ url('/template_content') }}/js/owl.carousel.js" ></script>
    <script src="{{ url('/template_content') }}/js/jquery.customSelect.min.js" ></script>
    <script src="{{ url('/template_content') }}/js/respond.min.js" ></script>
    <script type="text/javascript" language="javascript" src="{{url('template_content')}}/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="{{url('template_content')}}/assets/data-tables/DT_bootstrap.js"></script>
    {{-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> --}}
    <script src="{{ url('template_content') }}/js/dynamic_table_init.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!--right slidebar-->
    <script src="{{ url('/template_content') }}/js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="{{ url('/template_content') }}/js/common-scripts.js"></script>
    <script src="{{ url('/js') }}/pnotify.custom.min.js"></script>
    <script src="{{ url('/js') }}/jquery.blockUI.js"></script>
    <script src="{{ url('/js') }}/RecordRTC.js"></script>
    <script src="{{ url('/js') }}/correct/load-image.all.min.js"></script>
    <script src="{{ url('/js') }}/select2.full.js"></script>
    <script src="{{ url('/js') }}/moment.js"></script>
    <script src="{{ url('/js') }}/moment-timezone.js"></script>
    <script src="{{ url('/mp/MonthPicker.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('/pnotify/PNotify.js') }}"></script>

    {{-- <script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script> --}}
    <script>

      $('[data-toggle="toggle"]').bootstrapToggle();

      // $('#street-operator-find').keyup(_.debounce(function(event) {

      //   $('#street-results').hide();

      //   var search = $(this).val();

      //   $.post("{{ url('api/searchStrertOperator') }}", {search: search}, function(data, textStatus, xhr) {
      //     var html = "";
      //     $.each(data, function(index, val) {
      //        html+= "<li data-id='"+val.id+"' data-name='"+val._name+"' style='width:100%; cursor: pointer; list-style: none; height:20px; padding-left: 10px;' class='select-operator'>"+val._name+"</li>"
      //     });

      //     $('#street-results').html(html)

      //     $('.select-operator').click(function(){
      //       var id = $(this).data('id');
      //       var name = $(this).data('name');
      //       $('#selected-street-operator').val(id);
      //       $('#street-operator-find').val(name);
      //       $('#street-results').hide();
      //     })

      //     $('#street-results').show();
      //   });
      // },1000));

      // $('.street-operator-reasign').keyup(_.debounce(function(event) {

      //   $('.street-results').hide();

      //   var search = $(this).val();

      //   var elem = $(this).parent();

      //   $.post("{{ url('api/searchStrertOperator') }}", {search: search}, function(data, textStatus, xhr) {
      //     var html = "";
      //     $.each(data, function(index, val) {
      //        html+= "<li data-id='"+val.id+"' data-name='"+val._name+"' style='width:100%; cursor: pointer; list-style: none; height:20px; padding-left: 10px;' class='select-operator'>"+val._name+"</li>"
      //     });

      //     elem.find('.street-results').html(html)

      //     $('.select-operator').click(function(){
      //       var id = $(this).data('id');
      //       var name = $(this).data('name');
      //       elem.find('.selected-street-operator').val(id);
      //       elem.find('.street-operator-reasign').val(name);
      //       elem.find('.street-results').hide();
      //     })

      //     elem.find('.street-results').show();
      //   });
      // },1000));

      $('.assign-street').submit(function(event) {
        event.preventDefault();

        $('.assign-street').block({message:"<img src='{{url('ajax-loader.gif')}}' style='width: 100px;' alt=''>"});

        var id = $('#selected-street-operator').val();
        var perito = $('#selected-perito').val();

        if (!id) {
          $('.assign-street').unblock();
          return alert('Devi selezionare un sopralluoghista');
        }
        if (!perito) {
          $('.assign-street').unblock();
          return alert('Devi selezionare un perito');
        }

        var elem = $(this);

        var formData = new FormData(elem[0]);

        formData.append('mail_text',elem.find('#_predefined-1').val())

        $.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          contentType: false,
          processData: false,
          data: formData,
        })
        .done(function(data) {
          $('.assign-street').unblock();
          elem[0].reset();
          imClient.sendMessage(data.user_id,'RECARGAR_LISTA_DE_SINIESTROS')
          alert("Sinistro assegnato al sopralluoghista!");
          $('#new-sinister-tech').modal('hide');
          location.reload();
        }).fail(function(e){
          $('.assign-street').unblock();
          var err = JSON.parse(e.responseText)
          if (!err[0]) {
            alert('Il numero di riferimento interno non corrisponde');
          }else{ 
            alert(err[0]);
          }
        })
        .always(function() {
          $('.assign-street').unblock();
          console.log("complete");
        });
        
        // $.post($(this).attr('action'), $(this).serialize(), function(data, textStatus, xhr) {
        //   elem[0].reset();
        //   imClient.sendMessage(data.user_id,'RECARGAR_LISTA_DE_SINIESTROS')
        //   alert("Sinistro assegnato all'accertatore!");
        //   $('#new-sinister-tech').modal('hide');
        //   location.reload();
        // }).fail(function(e){
        //   var err = JSON.parse(e.responseText)
        //   if (!err[0]) {
        //     alert('Il numero di riferimento interno non corrisponde');
        //   }else{ 
        //     alert(err[0]);
        //   }
        // });
      });

      $('.reassign-street').submit(function(event) {
        event.preventDefault();

        var id = $(this).find('.selected-street-operator').val();

        $('.reassign-street').block({message:"<img src='{{url('ajax-loader.gif')}}' style='width: 100px;' alt=''>"});

        if (!id) {
          return alert('Devi selezionare un accertatore');
        }

        var elem = $(this);

        var formData = new FormData(elem[0]);

        formData.append('mail_text',elem.find('textarea').val())

        $.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          contentType: false,
          processData: false,
          data: formData,
        })
        .done(function(data) {
          $('.reassign-street').unblock();
        // $.post($(this).attr('action'), $(this).serialize(), function(data, textStatus, xhr) {
          elem[0].reset();
          imClient.sendMessage(data[0].user_id,'RECARGAR_LISTA_DE_SINIESTROS')
          if (data[1] != null) { 
            imClient.sendMessage(data[1],'RECARGAR_LISTA_DE_SINIESTROS')
          }
          alert("Sinistro assegnato all'accertatore!");
          $('#new-sinister-tech').modal('hide');
          location.reload();
        }).fail(function(e){
          $('.reassign-street').unblock();
          var err = JSON.parse(e.responseText)
          if (!err[0]) {
            alert('Il numero di riferimento interno non corrisponde');
          }else{ 
            alert(err[0]);
          }
        });
      });

      $('.delete-user').click(function(event) {
        console.log('borrando')
        var btn = $(this);
        $.ajax({
          url: $(this).data('href')
        })
        .done(function() {
          imClient.sendMessage(btn.data('id'),'19397b123ff06697f69a3ce5e083b503792c5b2f');
          location.reload();
        });
        
      });

      $('.contrassegnare').click(function(event) {
        var form = $(this).parents('form');
        var btn = $(this);
        console.log(btn)
        $.post(form.attr('action'), form.serializeArray(), function(data, textStatus, xhr) {
          imClient.sendMessage(btn.data('id'),'b0da14d6c9940064fdaff92a2f04ca3b8b335df6');
          location.reload();
        });
      });
      function convert2C(v)
      {
        if (v<10) {
          return '0'+v;
        }
        return v;
      }
      function convertTS(timestamp)
      {
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        date = new Date(timestamp * 1000),
        values = [
           convert2C(date.getFullYear()),
           months[date.getMonth()],
           convert2C(date.getDate()),
           convert2C(date.getHours()),
           convert2C(date.getMinutes()),
           convert2C(date.getSeconds()),
        ];

        return values[2]+' '+values[1]+', '+values[3]+':'+values[4];
      }
      // PNotify.desktop.permission();

      $('.send-form-sms').submit(sendFormSms);

      function sendFormSms(event) {
          event.preventDefault();

          var form = $(this)
          var formData = new FormData(form[0]);

          form.find('[type="submit"]').prop('disabled',true);

          form.find('#error').addClass('hide');
          form.find('#success').addClass('hide');

          $.each($(this).find('input'), function(index, val) {
              $(this).removeClass('error');
          });
          $.ajax({
              url: $(this).attr('action'),
              type: $(this).attr('method'),
              contentType: false,
              processData: false,
              data: formData,
          })
          .done(function(data) {
              form.find('#success').removeClass('hide');

              form.find('[type="submit"]').prop('disabled',false);

              setTimeout(function(){
                form.find('#error').addClass('hide');
                form.find('#success').addClass('hide');
                $('[id*="get-link"]').modal("hide");
              },3000);
          }).fail(function(r){
              var errors = $.parseJSON(r.responseText);
              var html = "";

              $.each(errors, function(index, val) {
                 html += val+'<br>'
              });

              form.find('#error').removeClass('hide');
              form.find('#error').html(html);

          });         
      }

      $('.send-form-webapp').submit(function(event) {
          event.preventDefault();

          var form = $(this)
          var formData = new FormData(form[0]);

          form.find('#error').addClass('hide');
          form.find('#success').addClass('hide');

          if (form.find('#_predefined-0').length > 0) {
            formData.append('predefined',form.find('#_predefined-0').val());
          }

          $.each($(this).find('input'), function(index, val) {
              $(this).removeClass('error');
          });
          $.ajax({
              url: $(this).attr('action'),
              type: $(this).attr('method'),
              contentType: false,
              processData: false,
              data: formData,
          })
          .done(function(data) {
              form.find('#success').removeClass('hide');

              setTimeout(function(){
                location.reload();
              },500);
          }).fail(function(r){
            
              if (r.responseJSON.length) {

                let errors = r.responseJSON;
                let message = "";

                if (errors[0].status == 1) {
                  message = "Il sinistro che stai creando esiste già e risulta chiuso. Vuoi riaprirlo?";

                  Swal.fire({
                    title: message,
                    showCancelButton: true,
                    confirmButtonText: `Si`,
                    cancelButtonText: `No`,
                  }).then((result) => {
                    if (result.isConfirmed) {
                      location.href = '{{url('admin/reopenSinister')}}/'+errors[0].customer_id
                      // Swal.fire('Saved!', '', 'success')
                    }
                  })

                }else{
                  message = "Il sinistro che stai creando esiste già e risulta aperto.";

                  Swal.fire({
                    title: message,
                    showCancelButton: true,
                    confirmButtonText: `Accettare`,
                    cancelButtonText: `Cancella`,
                  }).then((result) => {
                    if (result.isConfirmed) {
                      // Swal.fire('Saved!', '', 'success')
                    }
                  })
                }

              }else{

                var errors = $.parseJSON(r.responseText);
                var html = "";


                $.each(errors, function(index, val) {
                   html += val+'<br>'
                });

                form.find('#error').removeClass('hide');
                form.find('#error').html(html);

              }


          });         
      });

      $('.send-form').submit(function(event) {
          event.preventDefault();

          var form = $(this)
          var formData = new FormData(form[0]);

          form.find('#error').addClass('hide');
          form.find('#success').addClass('hide');

          if (form.find('#_predefined-0').length > 0) {
            formData.append('predefined',form.find('#_predefined-0').val());
          }

          $.each($(this).find('input'), function(index, val) {
              $(this).removeClass('error');
          });
          $.ajax({
              url: $(this).attr('action'),
              type: $(this).attr('method'),
              contentType: false,
              processData: false,
              data: formData,
          })
          .done(function(data) {
              form.find('#success').removeClass('hide');

              setTimeout(function(){
                location.reload();
              },500);
          }).fail(function(r){
              var errors = $.parseJSON(r.responseText);
              var html = "";

              $.each(errors, function(index, val) {
                 html += val+'<br>'
              });

              form.find('#error').removeClass('hide');
              form.find('#error').html(html);

          });         
      });
      $(function(){
        $('.active.zp').parent().css('display','block');
        $('.active.zp').parent().prev().addClass('active');
      });

      $('[name="all"]').click(function(){
        if($(this).is(':checked') == true){
          $('.send').prop('checked','true');
        }else{
          $('.send').removeAttr('checked');
        }
      })

      $('.send').click(function(event) {
        let a = 0;
        let l = $('.send').length;
        $.each($('.send'), function(index, val) {
            if ($(this).is(':checked')) {
              a++;
            }
        });

        if (l == a) {
          $('[name="all"]').prop('checked','true');
        }else{
          $('[name="all"]').removeAttr('checked');
        }
      });
    </script>

    <script type="text/javascript" src="https://cloud.apizee.com/apiRTC/apiRTC-latest.min.js"></script>
    {{-- <script src="https://cloud.apizee.com/apiRTC/v3.18/apiRTC-3.18.min.js"></script> --}}
    @yield('scripts')
    <script>
      // alert("Stop using the web please, I'm working!")
      @if (!isset($inside_call_page))
        function sessionReadyHandler(e) {
          console.log('Loading external client')
          webRTCClient = apiCC.session.createWebRTCClient();
          if ($('#myCallId')) { 
            $('#myCallId').html(apiRTC.session.apiCCId);
          }
          imClient = apiCC.session.createIMClient();
          imClient.nickname = '{{ Auth::user()->name }}';
          apiRTC.addEventListener("receiveIMMessage", function(m){
            console.log('nuevo mensaje fuera de la vista principal',m.detail.message)
            if ($('.messages').length == 0) {
              
              if (m.detail.message != "92ef97f1cadcae6b4cb70ba141a68bf78580f3ff" && m.detail.message.indexOf('href=') == -1 && m.detail.message.indexOf("c39d8c95216d7fa04bed5befd831cecbf6291c72") == -1) {
                (PNotify.info({
                    title: m.detail.senderNickname,
                    text: m.detail.message,
                    type: 'info',
                    desktop: {
                        desktop: true
                    }
                }));
              }
              /*******/
            }else{

              if ($('#user_id').val() == m.detail.senderId) {
              // function receiveIMMessageHandler(e) {

                // aqui para recibir imagenes
                $('#number').val(m.detail.senderId);

                if (m.detail.message == "92ef97f1cadcae6b4cb70ba141a68bf78580f3ff") {
                    if ($('div#panel-imagenes').length > 0) {
                        $('div#panel-imagenes').block({ message: "Caricamento dell'immagine..." });
                        $.post('{{ url('admin/receiveImage') }}', {senderId: m.detail.senderId, _token: '{{ csrf_token() }}' }, function(data, textStatus, xhr) {
                            var imagenes = "<div id='img-carousel'>";
                            $.each(data, function(index, val) {
                                imagenes += "<div style='padding: 0 6px'>\
                                        <div style='position:relative;'><button style='position:absolute; right: -5px; top: 15px;' class='btn badge label-danger delete-this' data-id='"+val.id+"'><i class='fa fa-times'></i></button>\
                                            <a href='"+val.imagen+"' download class='btn btn-info btn-xs'><i class='fa fa-download'></i> SALVA</a>   \
                                        </div>\
                                        <div style='background-image: url("+val.imagen+"); background-size: cover; background-position: center; height: 80px;'>\
                                        </div>\
                                    </div>";
                            });
                            imagenes += "</div>";

                            $('#panel-imagenes').html(imagenes);

                            // $('.open-image').click(openImage);

                            $('#img-carousel').owlCarousel({
                                items: 5,
                                itemsDesktop: [1199,4],
                                itemsDesktopSmall: [979,3],
                                itemsTablet: [768,3],
                                pagination: true
                            });
                            $('.delete-this').click(deleteThis);
                            $('div#div_messages').unblock();
                        });
                    }
                    return false;
                }/*else if(m.detail.message == "Incoming call from a customer - CODE 0001"){

                  //
                  (new PNotify({
                      title: m.detail.senderNickname,
                      text: "Chiamata in arrivo dal cliente \""+m.detail.senderNickname+"\"",
                      html: true,
                      type: 'info',
                      desktop: {
                          desktop: true
                      }
                  })).get().click(function(e) {
                      if ($('.ui-pnotify-closer, .ui-pnotify-sticker, .ui-pnotify-closer *, .ui-pnotify-sticker *').is(e.target)) return;
                      var _token = new Date().getTime().toString();
                      localStorage.setItem('call_token',_token)
                      window.open('{{url('admin/videocalls')}}?incoming_call='+m.detail.senderId+'&token='+_token,'_self')
                  });
                    
                }*/else if(m.detail.message == "3c05ebcf376c5eaa2fbb79019c26fd691207898f"){
                  return false;
                }else if(m.detail.message == "c39d8c95216d7fa04bed5befd831cecbf6291c72"){
                  return false;
                }else{
                    //If chatbox not visible, we set it visible
                    // $.post('{{ url('getTime') }}', {_token: '{{ csrf_token() }}'}, function(data, textStatus, xhr) {
                    //   $('.messages').append('<div class="contenedor"><div class="well notme"><span class="label label-danger">'+m.detail.senderNickname+':</span> '+m.detail.message+'</div></div><div class="date-notme">'+data+'</div>');
                    //   //Optionnal, a little animation
                    //   $(".messages").scrollTop(document.getElementsByClassName('messages')[0].scrollHeight);
                    // });
                }
            // }
              }else{
                if (m.detail.message != "92ef97f1cadcae6b4cb70ba141a68bf78580f3ff" && m.detail.message.indexOf('href=') == -1 && m.detail.message != "Incoming call from a customer - CODE 0001" && m.detail.message != "c39d8c95216d7fa04bed5befd831cecbf6291c72") {
                  (PNotify.info({
                      title: m.detail.senderNickname,
                      text: m.detail.message,
                      type: 'info',
                      desktop: {
                          desktop: true
                      }
                  }));
                }
              }
            }
          });

          $.post('{{ url('admin/operator_call_id') }}', {operator_call_id: apiRTC.session.apiCCId, _token: '{{ csrf_token() }}'}, function(data, textStatus, xhr) {
              // $.each(data[1], function(index, val) {
              //     imClient.sendMessage(val.call_id,'eaf2ea9f6559f226c8f433830b397204fe28ffdc');
              // });
          });

          $('.link-user').click(function(event) {
            var form = $(this).parents('form');
            var data = form.serialize();
            var id = $(this).data('id');

            data+='&sin_number='+($('input#sinister-'+id).val());
            data+='&operator_id='+($('select#operator-'+id).val());

            console.log(data);

            var btn = $(this);
            $.post(form.attr('action'), data, function(data, textStatus, xhr) {
              imClient.sendMessage(btn.data('id'),'b0da14d6c9940064fdaff92a2f04ca3b8b335df6');
              location.reload();
            }).error(function(e){
              alert('Il numero di sinistro è già in uso!');
            });
          });

          $('.add-sinister').click(function(event) {
            var form = $(this).parents('form');
            var btn = $(this);
            $.post(form.attr('action'), form.serializeArray(), function(data, textStatus, xhr) {
              imClient.sendMessage(btn.data('id'),'b0da14d6c9940064fdaff92a2f04ca3b8b335df6');
              location.reload();
            }).error(function(e){
              alert(JSON.parse(e.responseText));
            });
          });

          console.log('agregada funcion')

          apiRTC.addEventListener("recordedStreamsAvailable", function(e){
            console.error("recordedStreamsAvailableHandler");
            console.log("confId : " + e.detail.confId);
            console.log("userId1 : " + e.detail.userId1);
            console.log("userId2 : " + e.detail.userId2);

            if (e.detail.mediaURL !== undefined) {
                console.log(e.detail.mediaURL);
                $.post('{{url('api/downloadVideo')}}', {remote_url: e.detail.mediaURL}, function(data, textStatus, xhr) {
                    console.log(data);
                    (PNotify.success({
                        title: "Videochiamate",
                        text: "Il record video è stato caricato correttamente",
                        type: 'success',
                        desktop: {
                            desktop: false
                        }
                    }));
                });
            }
          });
        }
      @endif
      apiRTC.init({
          apiKey : "c67e026888d764c51462554b272f3419",
          // apiKey : "5ea39d65d0fff6f5b486a18a11ac46c3",
          // apiKey : "819abef1fde1c833e0601ec6dd4a8226",
          apiCCId : "{{ Auth::user()->id }}",
          onReady : sessionReadyHandler
      });
      localStorage.removeItem('notificationTo');
      localStorage.removeItem('notificationCall');
      $('[name="policy_model"]').editableSelect();

      $('.editTypology').keyup(_.debounce(function(event) {
        $.post('{{url('admin/changeName')}}', {_token: '{{csrf_token()}}',typology:$(this).val(),id:$(this).data('id')}, function(data, textStatus, xhr) {
        });
      },1000));

      $('.copy-link').click(copyLink);

      function copyLink(event) {

        var aux = document.createElement("input");
        aux.setAttribute("value", $(this).data('url'));
        document.body.appendChild(aux);
        aux.select();
        document.execCommand("copy");
        document.body.removeChild(aux);

        (new PNotify({
            title: "Copy link",
            text: "Il link è stato copiato negli appunti!",
            type: 'success',
            desktop: {
                desktop: false
            }
        })).get().click(function(e) {
            // if ($('.ui-pnotify-closer, .ui-pnotify-sticker, .ui-pnotify-closer *, .ui-pnotify-sticker *').is(e.target)) return;
            // alert('Hey! You clicked the desktop notification!');
        });
      }

      $(".form_datetime").datetimepicker({format: 'dd-mm-yyyy hh:ii'});

      $('.display.table').dataTable();

      let table = $('#orderByDate,.orderByDate').dataTable({
          "aaSorting": [[ 0, "desc" ]]
      });
    </script>

    <script>
      $( function() {
        $( "#sortable" ).sortable({
          connectWith: ".connectedSortable",
          update: function( event, ui ) {
            let ids = [];
            $.each($('.connectedSortable').find('.elementSortable'), function(index, val) {
              ids.push($(this).data('file_id'))
            });

            let url = $('#sortable').data('url');

            $.post(url, {_token: '{{csrf_token()}}', ids: ids}, function(data, textStatus, xhr) {
              console.log(data);
            });

            console.log(ids);
          }
        }).disableSelection();
      } );

      $('.button-link').click(function(event) {
        event.preventDefault();

        var id = $(this).data('id');

        $('input#sinister-'+id).css('border', '1px solid #e2e2e4');

        if ($('input#sinister-'+id).val() != "") {
          $('#modal-'+id).modal('show');
        }else{
          $('input#sinister-'+id).css('border', '1px solid #a00');
        }
      });
      $('.select2example').select2();
    </script>

    <script src="{{url('ckeditor')}}/ckeditor.js"></script>
    <script src="{{url('ckeditor')}}/adapters/jquery.js"></script>

    <script>
      $('[id*="_predefined-').ckeditor();
      $('.mpick').MonthPicker({'Button': false});
    </script>

    <script>
      if ('serviceWorker' in navigator) {
        window.addEventListener('load',()=>{

          navigator.serviceWorker.register('/sw.js')
          .then(()=>{
            console.log("serviceWorker registered");
          });
          
        });
      }
    </script>

    <script>
      
      function changeMonthFull() {
      var month = $(this).data('month');
      var action = $(this).data('action');
      $('[data-toggle="popover"]').popover('hide');
      $.post('{{ url('changeMonth-full') }}', {_token: '{{ csrf_token() }}', month: month, action: action}, function(data, textStatus, xhr) {
        $('.ajax-calendar').html(data);
        $('.changeMonth-full').click(changeMonthFull);
        $('[data-toggle="popover"]').popover({
          container: 'body'
        });
        $('[data-toggle="popover"]').click(function(event) {
          $('[data-toggle="popover"]').not(this).popover('hide');
        });
        $('#modal-show').on('show.bs.modal', function () {openModal1();})
        // $('#modal-invite').on('show.bs.modal', function () {openModal2();})
        $('#modal-delete').on('show.bs.modal', function () {openModal3();})

        $('#ev-delete').click(evDelete);
      });
    }
    
    $('.changeMonth-full').click(changeMonthFull);

    $('[data-toggle="popover"]').popover({
      container: 'body'
    });
    $('[data-toggle="popover"]').click(function(event) {
      $('[data-toggle="popover"]').not(this).popover('hide');
    });
    $('#modal-show').on('show.bs.modal', function () {openModal1();})
    // $('#modal-invite').on('show.bs.modal', function () {openModal2();})
    $('#modal-delete').on('show.bs.modal', function () {openModal3();})

    //

    function openModal1(){
      $($('.popover a[data-target="#modal-show"]').data('id')).trigger('click');
      let content = $($('.popover a[data-target="#modal-show"').data('content'))[0];

      console.log(content);

      let start = moment(content.start.dateTime);
      let end = moment(content.end.dateTime);
      let attendees = content.attendees;

      $('#desc-ev').text(content.summary);

      $('#date-ev').text(start.format('DD-MM-Y'));
      $('#hour-ev').text(start.format('HH:mm'));
      $('#edate-ev').text(end.format('DD-MM-Y'));
      $('#ehour-ev').text(end.format('HH:mm'));

      $('#calendar-link').attr('href', content.htmlLink);
      $('#ev-orgnm').text(content.organizer.displayName);
      $('#ev-orgem').text(content.creator.email);

      let html = "";

      if (attendees) {
        html+="<hr><h4><b> <i class='fa fa-users'></i> Partecipanti:</b></h4>";
        $.each(attendees, function(index, val) {
          html+="<li class='ev-emails'>"+val.email;
          if (val.responseStatus == 'accepted')
            html+="&nbsp;<i style='color: lightgreen' class='fa fa-check'></i>";
          html+= "</li>";
        });
      }

      $('#attendees').html(html);
    }

    // function openModal2(){
    //   $($('.popover a[data-target="#modal-show"]').data('id')).trigger('click');
    //   let id = $('.popover a[data-target="#modal-invite"').data('id');
    //   $('#ev-id').val(id);
    //   console.log(id);
    // }

    function openModal3(){
      $($('.popover a[data-target="#modal-show"]').data('id')).trigger('click');
      let id = $('.popover a[data-target="#modal-delete"').data('id');
      $('#ev-delete').attr('data-id', id);
      console.log( id );
    }

    // $('.ev-invita').click(function(event) {

    //   let rg = new RegExp('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$');

    //   if (rg.test($('#ev-email').val())) {

    //     $.post('{{url('inviteEvent')}}', {_token: '{{csrf_token()}}', id: $('#ev-id').val(), email: $('#ev-email').val()}, function(data, textStatus, xhr) {
    //       /*optional stuff to do after success */
    //     });
    //   }else{
    //     alert("L'email inserita non è corretta");
    //   }

    // });

    $('#ev-delete').click(evDelete);

    function evDelete(event) {

      // let rg = new RegExp('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$');

      // if (rg.test($('#ev-email').val())) {

        $.post('{{url('deleteEvent')}}', {_token: '{{csrf_token()}}', id: $(this).data('id')}, function(data, textStatus, xhr) {
          $('#modal-delete').modal('hide');

          var month = $('.changeMonth-full:first').data('month');
          
          $('[data-toggle="popover"]').popover('hide');
          $.post('{{ url('changeMonth-full') }}', {_token: '{{ csrf_token() }}', month: month, action: 'none'}, function(data, textStatus, xhr) {
            $('.ajax-calendar').html(data);
            $('.changeMonth-full').click(changeMonthFull);
            $('[data-toggle="popover"]').popover({
              container: 'body'
            });
            $('[data-toggle="popover"]').click(function(event) {
              $('[data-toggle="popover"]').not(this).popover('hide');
            });
            $('#modal-show').on('show.bs.modal', function () {openModal1();})
            // $('#modal-invite').on('show.bs.modal', function () {openModal2();})
            $('#modal-delete').on('show.bs.modal', function () {openModal3();})
          });
        });
      // }else{
      //   alert("L'email inserita non è corretta");
      // }

    }

    </script>

  </body>
</html>
