
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>CS CMU MIS</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	{{--<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
	<link rel="stylesheet" href="{{ asset('/libs/datatables/css/jquery.dataTables.min.css') }}">

	@yield('header_content')

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9ipt>
	<![endif]-->
</head>
<body>

	@include('partials.nav')

</br>
</br>
</br>
	@yield('content')

	<!-- Scripts -->
	{{--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>--}}
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>--}}
	{{--<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.7/js/jquery.dataTables.min.js"></script>--}}
	<script src="{{ asset('/js/jquery.min.js') }}"></script>
	<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/libs/datatables/js/jquery.dataTables.min.js') }}"></script>

	<!-- Optional theme -->
	@yield('footer')

	@yield('script_tag')

</body>
</html>
