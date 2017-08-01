<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.3/css/bulma.min.css">
<script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/vue.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/moment.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/datepicker.en.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bulma.css') }}">
<script type="text/javascript" src="{{ URL::asset('js/semantic.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/semantic.css') }}">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/datepicker.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/timepicker.min.css') }}">
<script type="text/javascript" src="{{ URL::asset('js/timepicker.min.js') }}"></script>


<title>@yield('title')</title>
</head>
<body>
<div style="width: 100%; background-color:#eee; height:55px; position: fixed; display: flex; justify-content: flex-end;" id="Header">
	@if(Auth::check())
		<a class="button is-danger" href="/logout">Log Out</a>
	@else
		<a class="button is-success" href="/login" style="margin:10px;">Log In</a>
		<a class="button is-success" href="/register" style="margin:10px;">Register</a>
	@endif
</div>
<script type="text/javascript">
new Vue({
	el:'#Header',
	data:{

	},
	methods:{

	}
});
</script>
<div style="width:100%; height:55px;"></div>
	<!-- include('Layouts.Vidhikarya.Lawyer.Header') -->
		<div>
			@yield('content')
		</div>
	<!-- include('Layouts.Vidhikarya.Lawyer.Footer') -->
</body>
</html>
