<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap,  Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="{{ url('/template_content') }}/img/favicon.png">

    <title>EXPRESS CLAIMS | Login</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ url('/template_content') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/template_content') }}/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="{{ url('/template_content') }}/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ url('/template_content') }}/css/style.css" rel="stylesheet">
    <link href="{{ url('/template_content') }}/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style>
        .g-recaptcha {
            margin-left:-6px;
        }
    </style>
</head>

  <body class="login-body">

    <div class="container">

      <form class="form-signin" action="{{ url('admin/login') }}" method="POST" autocomplete="false">
        {{ csrf_field() }}
        <h2 class="form-signin-heading">LogIn</h2>
        <div class="login-wrap">
            <input type="text" class="form-control" name="email" placeholder="E-Mail" autofocus />
            <input type="password" class="form-control" name="password" placeholder="Password" />
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6Lfsb_MUAAAAAHGC265-O3uMMr_ds-CzIMPEwFoL"></div>
            </div>
            <button class="btn btn-lg btn-login btn-block" type="submit">Enter</button>
        	@include('includes')
        </div>
      </form>

    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="{{ url('/template_content') }}/js/jquery.js"></script>
    <script src="{{ url('/template_content') }}/js/bootstrap.min.js"></script>


  </body>
</html>
