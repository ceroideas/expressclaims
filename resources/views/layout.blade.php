<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>STUDIO ZAPPA</title>

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

    <link href="{{ url('/template_content') }}/css/style.css" rel="stylesheet">
    <link href="{{ url('/css') }}/custom.css" rel="stylesheet">
    <link href="{{ url('/template_content') }}/css/style-responsive.css" rel="stylesheet" />
    <link href="{{ url('/js') }}/owl/owl.css" rel="stylesheet" />
    <link href="{{ url('/js') }}/pnotify.custom.min.css" rel="stylesheet" />
    <script src="{{ url('/template_content') }}/js/jquery.js"></script>
    <script src="{{ url('/js') }}/owl/owl.carousel.min.js"></script>

    <style>
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

      /* Hide default HTML checkbox */
    .switch input {display:none;}

    /* The slider */
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
  </head>

  <body>

  <section id="container" >
      <!--header start-->
      <header class="header white-bg">
            <!--logo start-->
            <a href="{{ url('/') }}" class="logo hidden-xs">
              {{-- Ren<span>ova</span> --}}
              <img src="{{ url('renova.png') }}" alt="" width="100px" style="top:-6px;position:relative;">
            </a>
            <!--logo end-->
            <div class="top-nav ">
                <!--search & user info start-->
                <!--search & user info end-->
            </div>
        </header>
      <!--header end-->
      
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
            @yield('content')
          </section>
      </section>
      <!--main content end-->
      <!-- Right Slidebar start -->

      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              {{ date('Y') }} &copy; Renova
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="{{ url('/template_content') }}/js/bootstrap.min.js"></script>
    <script src="{{ url('/js') }}/jquery.blockUI.js"></script>
    @yield('scripts')

  </body>
</html>
