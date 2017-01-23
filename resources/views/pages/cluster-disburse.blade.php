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
                <label for="first_collection_date"> First Payment  </label>
                <input type="date" class="form-control" name="first_collection_date" id="first_collection_date" required>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="form-group">
                <label for="last_collection_date"> Last Payment </label>
                <input type="date" class="form-control" name="last_collection_date" id="last_collection_date" required>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="form-group">
                <label for="maturity_date"> Maturity Date </label>
                <input type="date" class="form-control" name="maturity_date" id="maturity_date" required>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="form-group">
                <label for="release_date"> Release Date </label>
                <input type="date" class="form-control" name="release_date" id="release_date" required>
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
                                    <input type="number" min="2000" max="99000" name="loan_amount[{{$x->name->id}}]" class="form-control loan-amount"> 
                                </td>
                                <td style="text-align:center">
                                    <div class="radio">
                                        <label><input type="checkbox" class="reloan" name="reloan[{{$x->id}}]" p_id = "{{$x->id}} "p_name="{{$x->name->lastname.', '.$x->name->firstname.', '.$x->name->middlename}}" target-rdb="rdb{{$x->id}}" > Not re-loaning/loaning </label>
                                        <label  id="rdb{{$x->id}}"><input type="radio" class="rdbPayee" name="payee_id" value="{{$x->id}}" p_name="{{$x->name->lastname.', '.$x->name->firstname.', '.$x->name->middlename}}" required>Mark As Payee</label>
                                    <button type="button" class="btn btn-sm btn-default loan-summary"><i class="fa fa-info-circle fa-5" aria-hidden="true"></i></button>
                                    </div>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="modal-footer">
                
                <button type="submit" class="btn btn-success"> Submit </button>
                </div>
       
        {{$clients->links()}}
    </div>
</form>  
<div class="modal modal-wide fade" id="mdlDisburseSummary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Disbursement Summary</h4>
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
})
$('.loan-summary').click(function(){
    $('#frmDisburse').submit
    $('#mdlSummary').modal('show')
})
$('.rdbPayee').click(function(){
    $('#payee_name').val($(this).attr('p_name'))
    $('#payee_id').val($(this).val())
})
$('#btnShowSummary').click(function(){
   
    $('#mdlDisburseSummary').modal('show')
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
    console.log($(this).toLocaleDateString())
})
</script>  
@stop