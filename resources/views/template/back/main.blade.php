<!DOCTYPE html>
<html lang="fr-FR">
	<head>
		<meta charset="utf-8" />
		@yield('title')
		
		<meta name="robots" content="noindex,nofollow" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="_token" content="{!! csrf_token() !!}"/>
		{!! HTML::style('assets/css/app.css', array('media' => 'all')) !!}
		{!! HTML::style('assets/css/adminlte.css', array('media' => 'all')) !!}
		{!! HTML::style('assets/css/skin-black.css', array('media' => 'all')) !!}

		@yield('header')
	</head>
	<body class="skin-black">
		<div class="wrapper">
			 @include('template.back.nav')
			
			@yield('home')
			<div class="content-wrapper">
				@yield('content')
			</div>
			<!-- Javascripts
			================================================== -->
			{!! HTML::script('assets/js/app.js') !!}
			<script type="text/javascript">
			$.ajaxSetup({
			   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
			});
			$(document).ready(function() {
		        $(".multiselect").chosen();
		    });
			</script>
			@yield('footer')
		</div>
	</body>
</html>
