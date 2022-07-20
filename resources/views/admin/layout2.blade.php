<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <meta http-equiv="refresh" content="3600;url={{url('logout',1)}}" />
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
      <!--sidebar end-->
      <!--main content start-->
      {{-- <section id="main-content"> --}}
      <section>
          <section class="wrapper">
            @yield('content')
          </section>
      </section>

      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              {{ date('Y') }} &copy; Renova
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>

  <style>
    .select-operator:hover {
      background-color: #ccc;
    }
  </style>

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

    @yield('scripts')

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

      $('.editTypology').keyup(_.debounce(function(event) {
        $.post('{{url('changeName')}}', {_token: '{{csrf_token()}}',typology:$(this).val(),id:$(this).data('id')}, function(data, textStatus, xhr) {
        });
      },1000));

      $(".form_datetime").datetimepicker({format: 'dd-mm-yyyy hh:ii'});

      $('.display.table').dataTable();
    </script>

  </body>
</html>
