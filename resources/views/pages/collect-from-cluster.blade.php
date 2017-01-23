@extends('layouts.admin-layout')
@section('content')

    <div style="margin-top:30px"></div>
    

    <div id="step-1">
      
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> List of All Clients</h1>
                <h2>Total Clients: <b>10</b></h2>
                <div class="row">
                <form action="{{ url()->current()}}" method="get">
                    
                    <div class="row">
                        <div class="col-md-12 ">
                          
                                <div class="form-group has-feedback">
                                    <label for="search" class="sr-only">Search</label>
                                    <input type="text" class="form-control" name="search" id="search" placeholder="search">
                                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                </div>
                         
                        </div>
                    </div>
                </form>
                </div>
            </div>
            </div>
            
            <!-- /.col-lg-12 -->
        </div>
        <table class="table table-striped">
            <thead>
                <th>Client Name</th>
                <th>Loan Amount</th>
                <th>Amount Due</th>
                <th>Past Due</th>
                <th>Total Due</th>
                
            </thead>
            
            <tbody>
                <tr>
                    <td>Ashbee Morgado</td>
                    <td>{{money_format('50000')}}</td>
                    <td>{{money_format('2458')}}</td>
                    <td>{{money_format('0')}}</td>
                    <td>{{money_format('2458')}}</td>
                </tr>
                
                <tr>
                    <td>Michael Bomlarda</td>
                    <td>{{money_format('60000')}}</td>
                    <td>{{money_format('4320')}}</td>
                    <td>{{money_format('0')}}</td>
                    <td>{{money_format('4320')}}</td>
                </tr>
                
                <tr>
                    <td>Jasmin Conquilla</td>
                    <td>{{money_format('45000')}}</td>
                    <td>{{money_format('2230')}}</td>
                    <td>{{money_format('0')}}</td>
                    <td>{{money_format('2230')}}</td>
                </tr>
                
                
                <tr>
                    <td>Erwin Libunao</td>
                    <td>{{money_format('70000')}}</td>
                    <td>{{money_format('4769')}}</td>
                    <td>{{money_format('0')}}</td>
                    <td>{{money_format('4769')}}</td>
                </tr>
                
                
                <tr>
                    <td>Greggy Canja</td>
                    <td>{{money_format('75000')}}</td>
                    <td>{{money_format('4900')}}</td>
                    <td>{{money_format('0')}}</td>
                    <td>{{money_format('4900')}}</td>
                </tr>
                
            </tbody>
        </table>  
        <div class="modal-footer">
           
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary form-control">
                        Browse… <input type="file" style="display: none;" multiple="">
                    </span>
                    
                </label>
                <input type="text" class="form-control" readonly="" style="width:80%">
                <input type="submit" class="btn btn-default" >
               

            </div>
        </div>
       
    </div>
   
@stop
@section('page-script')
<script>
$(function() {

  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }

      });
  });
  
});
</script>
@stop