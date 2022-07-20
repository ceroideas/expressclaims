<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>EXPRESS CLAIMS - WEB APP</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<meta name="theme-color" content="#5b6e84" />
	<link rel="shortcut icon" href="{{ url('favicon.ico') }}">
    <link href="https://materializecss.com/css/ghpages-materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
	<style>
		body {
			background: #f1f2f7;
			text-align: center;
		}
		.site-footer {
		    background: #5b6e84;
		    color: #fff;
		    padding: 6px 0;
            text-align: center;
		}
		.main-wrapper {
			height: calc(100vh - 40px - 62px);
			overflow: auto;
			position: relative;
			background-color: #4384c5;
			padding: 40px;
		}
		header {
			background-color: #fff;
			padding: 10px;
			text-align: center;
			box-shadow: 0 0 5px 1px rgba(0,0,0,.2);
		}
		h1 {
			font-size: 28px;
			color: #fff;
		}
	</style>
</head>
<body>
	<header class="header white-bg">
        <a href="#" class="logo">
          <img src="{{url('renova.png')}}" alt="" height="44px" style="position:relative;">
          {{-- <input type="file" accept="image/*" capture="camera"> --}}
        </a>
        <!--logo end-->
    </header>

    <div class="container">
		<div class="main-wrapper">

			<div style="position: relative; top: 10%;">
				<img src="{{url('disconnected.png')}}" style="width: 180px;" alt="">

				<br>

				<h1>{{$msg}}</h1>
			</div>
		</div>
	</div>

    <footer class="site-footer">
      <div class="text-center">
          {{date('Y')}} © Renova
          <a href="#" class="go-top">
              <i class="fa fa-angle-up"></i>
          </a>
      </div>
  	</footer>
	
</body>
</html>