@extends('layouts.admin-layout')
@section('content')

<div style="margin-top:30px"></div>
    
<form action="{{url()->current()}}" method="POST" id="frmDisburse">
  
    <input type="hidden" name="cluster_id" value="{{$cluster_id}}">
    <div id="step-1">
      
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Loan Disbursement | Total Clients: <b>{{$clients->total()}}</b></h1>
                
           
            </div>
            </div>
            
            <!-- /.col-lg-12 -->
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('status'))

            <div class="alert alert-{{ (session('status')['code']==1)?'success' : 'danger' }}">
            <strong>{{(session('status')['code']==1)?'Success!' : 'Oooops'}}</strong> {{ session('status')['msg'] }}
            </div>
        @endif
        <div class="col-lg-6 col-md-6">
            <div class="form-group">
                <label for="cv_number"> Check Voucher # </label>
                <input type="text" class="form-control" name="cv_number" id="cv_number" required>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="form-group">
                <label for="check_number"> Check # </label>
                <input type="text" class="form-control" name="check_number" id="check_number" required>
            </div>
        </div>
         <div class="col-lg-6 col-md-6">
            <div class="form-group">
                <label for="release_date"> Release Date </label>
                <input type="date" class="form-control" name="release_date" id="release_date" required>
            </div>
        </div>
       
        <div class="col-lg-6 col-md-6">
            <div class="form-group">
                <label for="weeks_to_pay"> Weeks To Pay  </label>
                <input type="number" class="form-control" name="weeks_to_pay" id="weeks_to_pay" min="22" max="26" required>
            </div>
        </div>
         <div class="col-lg-4 col-md-4">
            <div class="form-group">
                <label for="first_collection_date"> First Payment  </label>
                <input type="date" class="form-control" name="first_collection_date" id="first_collection_date" required>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="form-group">
                <label for="last_collection_date"> Last Payment </label>
                <input type="date" class="form-control" name="last_collection_date" id="last_collection_date" required>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="form-group">
                <label for="maturity_date"> Maturity Date </label>
                <input type="date" class="form-control" name="maturity_date" id="maturity_date" required>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="form-group">
                <label for="payee_name"> Payee  </label>
                <input type="text" class="form-control" name="payee_name" id="payee_name" readonly>
                <input type="hidden" class="form-control" name="payee_id" id="payee_id" required> 
            </div>
        </div>
        
                {{csrf_field()}}
        <div class="clearfix"></div>
        {{$clients->links()}}
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Loan Information</a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <th>Name</th>
                                <th style="">Loan Amount</th>
                                <th style="text-align:center">Action</th>
                            </thead>
                            <tbody>
                                @foreach($clients as $x)
                                    <tr >
                                        <td class="">
                                            {{$x->name->lastname.', '.$x->name->firstname.', '.$x->name->middlename}}
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" min="2000" max="99000" step="1000" name="loan_amount[{{$x->name->id}}]" class="form-control loan-amount" data-id="{{$x->name->id}}" required>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-success view-amort" lookup-id="{{$x->name->id}}" type="button">View Amortization</button>
                                                </span>
                                                </div>
                                            </div>
                                            
                                        </td>
                                        <td style="text-align:center">
                                    
                                            <div class="radio">
                                                <label><input type="checkbox" class="reloan" name="reloan[{{$x->id}}]" p_id = "{{$x->id}} "p_name="{{$x->name->lastname.', '.$x->name->firstname.', '.$x->name->middlename}}" target-rdb="rdb{{$x->id}}"> Not re-loaning/loaning </label>
                                                <label  id="rdb{{$x->id}}"><input type="radio" class="rdbPayee" name="payee_id" value="{{$x->client_id}}" p_name="{{$x->name->lastname.', '.$x->name->firstname.', '.$x->name->middlename}}" required>Mark As Payee</label>
                                            </div>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Insurance Information</a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <th style="width:30%">Name</th>
                                <th style="width:30%"> Dependents </th> 

                                <th style="width:30px">MI Total</th>

                                <th style="width:45px">CLI Total</th>
                            </thead>
                            <tbody>
                                @foreach($clients as $x)
                                    <tr >
                                        <td class="">
                                            {{$x->name->lastname.', '.$x->name->firstname.', '.$x->name->middlename}}
                                        </td>
                                        <td>
                                            <select  name="mi[{{$x->name->id}}]" class="form-control mi_info" required id="slct_{{$x->id}}" bind-id="{{$x->name->id}}">
                                                <option value=""> ------- </option>
                                                @foreach($insurance as $value)
                                                    <option id="{{$value->id}}" total="{{$value->total_mi_fee}}" value="{{$value->id}}">{{$value->description}}</option>
                                                @endforeach        
                                            </select>
                                        </td>
                                      
                                        <td><b> <span id="total_mi_{{$x->name->id}}">₱ 0.00</span></b></td>
                                       
                                        <td><b><span id="total_cli_{{$x->name->id}}">₱ 0.00</span></b> </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Review</a>
                    </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse">
                    <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                </div>
            </div>
        </div>       
        
        
        
        <div class="modal-footer">
        
            <button type="submit" class="btn btn-success"> Submit </button>
        </div>
       
        </div>
                
</form>  




<!-- Modal -->
<div class="modal fade" id="mdlSummary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@stop
@section('page-script')
<script>
var weeks;
$(function(){
  weeks = {{$weeks_to_pay}}  
  $('first_collection_date').datepicker({
      showOtherMonths: true,
        selectOtherMonths: true,
  })
})
$('.loan-summary').click(function(){
    $('#frmDisburse').submit
    $('#mdlSummary').modal('show')
})
$('.rdbPayee').click(function(){
    $('#payee_name').val($(this).attr('p_name'))
    $('#payee_id').val($(this).val())
})
$('.reloan').click(function(){
    //get rdbid of clicked checkbox
    rdb = $(this).attr('target-rdb')
    if($(this).prop('checked')){
        $('#'+rdb).addClass('hidden')
            if(parseInt($(this).attr('p_id'))==($('#payee_id').val())){
                $('#payee_id').val('')
                $('#payee_name').val('')
                    $.each($('.rdbPayee'),function(k,v){
                        $(this).attr('checked',false)
                    })
            }
   }else{
        $('#'+rdb).removeClass('hidden')
   }
})
$('#first_collection_date').change(function(){
    console.log($(this).val())
})

$('.view-amort').click(function(){
    id = $(this).attr('lookup-id')
    console.log(id)
    input = $('[data-id='+ id +']')
    val = input.val()
    if(val==""){
        input.addClass('alert alert-danger')
        input.removeClass('alert alert-success')
       
    }else{
        input.addClass('alert alert-success')
        input.removeClass('alert alert-danger') 
        popuponclick(input.val())  
    }
 
})

$('.loan-amount').keyup(function(){
    var amt = $(this).val()
    var id = $(this).attr('data-id')
    var cli_cblic = '#cli_premium_cblic_' + id
    var cli_lmi = '#cli_premium_lmi_' + id
    var total = '#total_cli_'+id
    console.log(total)
    $.ajax({
        url:'/Api/Insurance/Compute',
        data:{amt:amt},
        type:'GET',
        dataType:'JSON',
        success:function(data){
             $(cli_cblic).val(data.cblic_fee)
             $(cli_lmi).val(data.lmi_fee)
             $(total).html(data.total)
   
         }

    });
    
})



function popuponclick(value)
{
my_window = window.open('/Api/Scheduling/'+value,
  "Schedule","status=1,width=1000px,height=500px");

}
 $("#release_date").change(function(){
     var input = $(this)
     var val = input.val()
     $.ajax({
         url:'/Api/Date/Amortization/',
         data:{from:val},
         dataType:'JSON',
         type:'GET',
         success:function(data){
             if(data.code==1){
                // $('#maturity_date').val(data.maturity_date)
                 $('#first_collection_date').val(data.res.first_payment)
                 $('#maturity_date').val(data.res.end_date)
                 //$('#weeks_to_pay').val(data.res.weeks_diff)
                 $('#weeks_to_pay').val(24)
                 $('#last_collection_date').val(data.res.last_payment)
                 console.log(data.res.end_date)
                   input.removeClass('alert-danger')
                
             }else{
                alert('Selected Date must be M-F');
                $("#release_date").val("")
                input.addClass('alert-danger')
             }
         }
     })
 })

 $('.mi_info').change(function(){
    id = $(this).attr('bind-id')
    target = '#total_mi_'+id
    total = $(this).find('option:selected').attr('total')
    $(target).html(' ₱ '+ total +'.00')
 })
</script>  
@stop