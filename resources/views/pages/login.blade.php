<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Sign-Up/Login Form</title>
  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
<link rel="stylesheet" href="{{asset('/css/login.css')}}"/>

  
</head>

<body>
  <div class="form">
      
      <ul class="tab-group">
        <li class="tab active"><a href="#login">Log In</a></li>
        <li class="tab "><a href="#signup">Sign Up</a></li>
      </ul>
      
      <div class="tab-content">
          <div id="login">   
          <h1 style="margin-bottom:-5px">LIGHT MFI </h1>
          <hr>
          <h1>LR & CBU Monitoring</h1>
            @if(\Session::has('msg'))
                <h2 class="text-centered" style="color:white"> {{(\Session::get('msg'))}} </h2>
            <?php
                destroy_session('msg');
             ?>
            @endif
          <form action="{{url()->current()}}" method="post">
            {{csrf_field()}}
            <div class="field-wrap">
            <label>
              Username<span class="req">*</span>
            </label>
            <input type="text" name="username" required />
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password" name="password" required autocomplete="off"/>
          </div>
          
          <p class="forgot"><a href="#">Forgot Password?</a></p>
          
          <button class="button button-block"/>Log In</button>
          
          </form>

        </div>
        
        <div id="signup">   
          <h1>Sign Up for Free</h1>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li style="font-color:white">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
          <form action="/Register" method="post">
        {{csrf_field()}}
          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input type="text" name="firstname" required autocomplete="off" value="{{old('firstname')}}" />
            </div>
        
            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input type="text" name="lastname"required autocomplete="off" value="{{old('lastname')}}"/>
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Username <span class="req">*</span>
            </label>
            <input type="text" name="username" required autocomplete="off" value="{{old('username')}}"/>
          </div>
         
          
          <div class="field-wrap">
            <label>
              Set A Password<span class="req">*</span>
            </label>
            <input type="password" name ="password" required autocomplete="off"/>
          </div>
          <div class="field-wrap">
            <label>
              Confirm Password<span class="req">*</span>
            </label>
            <input type="password" name="password_confirmation" required autocomplete="off"/>
          </div>
          
          <button type="submit" class="button button-block"/>Register</button>
          
          </form>

        </div>
        
      
      </div><!-- tab-content -->
      
</div> <!-- /form -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="{{asset('js/login.js')}}"></script>
    <script>

    </script>
</body>
</html>
