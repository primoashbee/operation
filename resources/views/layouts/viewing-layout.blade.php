<!DOCTYPE html>
<html>
<head>	
	<title>LIGHT MFI - @yield('title')</title>
	@include('includes.head')
</head>
<body>
	<div class="container">
	
		
		<div class="well">
			
				@yield('content')
			
		</div>
	
		
	</div>

</body>
<script>
	@include('includes.scripts')
	@yield('page-script')
</script>
</html>
