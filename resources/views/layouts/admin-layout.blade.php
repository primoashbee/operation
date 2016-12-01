<!DOCTYPE html>
<html>
<head>	
	<title>LIGHT MFI - @yield('title')</title>
	@include('includes.head')
</head>
<body>
	<div id="wrapper">
		@include('includes.header')
		
		<div id="page-wrapper">
			
				@yield('content')
			
		</div>
		<footer class="row">
			@include('includes.footer')
		</footer>
		
	</div>

</body>
	@include('includes.scripts')
	@yield('page-script')
</html>
