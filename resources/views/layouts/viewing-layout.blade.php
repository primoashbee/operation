<!DOCTYPE html>
<html>
<head>	
	<title>LIGHT MFI - @yield('title')</title>
	@include('includes.head')
</head>
<body>
	<div class="container"  style="padding-top:25px">
	
		
		<div class="jumbotron">
			
				@yield('content')
			
		</div>
	
		
	</div>

</body>
	@include('includes.scripts')
	@yield('page-script')
</html>
