@extends('layouts.admin-layout')
@section('content')

    <div style="margin-top:30px"></div>
    

    <div id="step-1">
      
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> List of All Clients</h1>
                <h2>Total Clients: <b>{{$due->count() }}</b></h2>
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
       
        @if($due->count()==0)
            <h1> Wala pong collection ngayong araw </h1>    
        @endif 
        @if (null !== (session('data')))
            <div class="alert alert-danger">
                <ul>
                  
                    @foreach (session('data') as $error)
                        <li>{{$error->msg}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                  
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        
        <div class="hidden" id="alert-div">
            <div class="alert alert-danger">
                <ul>
                
                        <li>Invalid File Type (.xlsx only)</li>
                  
                </ul>
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
        
                @foreach($due as $x)
                    <tr>
                        <td>{{$x->clientInfo->firstname.' '.$x->clientInfo->lastname}}</td>
                        <td>{{pesos(individual_total_loan($x->disbursement_id,$x->client_id)->loan_amount) }}</td>
                        
                    
                        <td>{{pesos($x->principal_with_interest)}}</td>
                        <td>{{pesos($x->past_due)}}</td>
                        <td>{{pesos($x->principal_this_week + $x->past_due)}}</td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>  
        <div class="modal-footer">
            <form action ="{{url()->current()}}" method ="POST" enctype="multipart/form-data" id="frmUpload">
                {{csrf_field()}}
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary form-control">
                            Browse… <input type="file" name = "fileUpload" id ="fileUpload" style="display: none;" value ="{{isset($input) ? $input->getRealPath() : ''}}">
                        </span>
                        
                    </label>
                    <input type="text" class="form-control" readonly="" style="width:80%" value="{{isset($input) ? $input->getClientOriginalName() : '' }}">
                    <button type="submit" class="btn btn-default"  id="btnUpload" > Upload </button>
                

                </div>
            </form>
        </div>
        
        @if(isset($readFile))
        
        <div class="read-values">
            <h1>Review Payment <button type ="submit" class="btn btn-success"/ > <i class="fa fa-floppy-o" aria-hidden="true"></i> Save Payment </button></h1>
            <table class="table table-condensed">
                <thead>
                    <th>Client Name</td>
                    <th>Amount Due</td>
                    <th>Amount Paid</td>
                    <th>This Week Balance</td>
                    <th>CBU</td>
                </thead>
                <tbody>
                @foreach($readFile->collection as $k => $v)
                
                    <tr>
                        <td>{{$v->client_name}}</td>
                        <td>{{pesos($v->principal_with_interest)}}</td>
                        <td>{{pesos($v->amount_paid)}}</td>
                        <td>{{pesos($v->this_week_balance)}}</td>
                        <td>{{pesos($v->cbu)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="modal-footer">
                <a href="{{url()->current()}}/Save"><button type ="submit" class="btn btn-success"/ > <i class="fa fa-floppy-o" aria-hidden="true"></i> Save Payment </button></a>
            </div>
        </div>
        @endif
       
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
  /*
  $('#btnUpload').click(function(){
     file = $('#fileUpload').val()
     ext = file.substr(file.lastIndexOf('.')+1)
     if(ext=='xlsx'){
       $('#alert-div').addClass('hidden')   
       formData = $('#frmUpload').serialize()
        $.ajax({
            type: 'get',
            url: '/Ajax/UploadCollection/',
            data: formData,
            dataType: 'json',
            success: function(data){
                // success logic
            },
            error: function(data){
                var errors = data.responseJSON;
                console.log(errors);
                // Render the errors with js ...
        }
        })
     }else{
        
        $('#alert-div').removeClass('hidden')
     }
     console.log(ext)
         
     
  })
  */
});

</script>
@stop