<!DOCTYPE html>
<html>
    <head>
        @include('new-includes.head')
    </head>

<body class="nav-md">
    <div class="container body">
      <div class="main_container">
			@include('new-includes.top-navigation')
                @yield('content')
            @include('new-includes.footer')
  
      </div>
  
    </div>
    
 </body>
        @include('new-includes.scripts')
</html>