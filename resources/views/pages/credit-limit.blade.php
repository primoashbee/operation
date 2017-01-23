@extends('layouts.admin-layout')
@section('content')

    <div style="margin-top:30px"></div>


    <div id="step-1">
      
        <div class="row">
            <div class="col-lg-12">
              
                <form action="/Clients/Credit/{{Route::current()->getParameter('id')}}" method="POST">
                    {{ csrf_field() }}
                <h1 class="page-header"> Credit Limit</h1>
                @if (session('status'))
                    <div class="{{ session('status')['code'] == 1 ? 'alert alert-success' :'alert alert-danger'}}">
                        <h1> {{ session('status')['msg'] }} </h1>
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
                        
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                            
                                <label for="cm1">Co Maker 1 (Cluster Member)</label>
                                <input type="text"   class="form-control" min="0" name ="cm1" id ="cm1" value="{{$info->coMakerInside()->first()==null ? '' : $info->coMakerInside()->first()->lastname.', '.$info->coMakerInside()->first()->firstname. ',' .$info->coMakerInside()->first()->middlename }}" required>
                                <input type="hidden"  class="form-control" min="0" name ="co_maker_inside_cluster_id" id ="co_maker_inside_cluster_id" value="{{$info->coMakerInside()->first()==null ? '' : $info->co_maker_inside_cluster_id }}" >
                                <button  class="btn btn-default btnshow" type="button" mode="cm1" >SHOW</button>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                            
                                <label for="cm2">Co Maker 2 (Non-Cluster Member)</label>
                                <input type="text"  class="form-control" min="0" name ="cm2" id ="cm2" value="{{$info->coMakerOutside()->first()==null ? '' : $info->coMakerOutside()->first()->lastname.', '.$info->coMakerOutside()->first()->firstname. ',' .$info->coMakerOutside()->first()->middlename }}" required>
                                <input type="hidden"   class="form-control" min="0" name ="co_maker_outside_cluster_id" id ="co_maker_outside_cluster_id"  value="{{$info->coMakerOutside()->first()==null ? '' : $info->co_maker_outside_cluster_id }}">
                                <button  class="btn btn-default btnshow" type="button" mode="cm2" >SHOW</button>
                            </div>
                        </div>

                
                 
                  
                    <div class="clearfix"></div>
                        <div id="cashflow_analysis">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="business_net_disposable_income">Business Net Disposable Income </label>
                                    <input type="number" class="form-control" min="0" name ="business_net_disposable_income" id ="business_net_disposable_income"  value="{{$info->business_net_disposable_income}}" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="household_income">Household Income</label>
                                    <input type="number" class="form-control" min="0" name ="household_income" id ="household_income" value="{{$info->household_income}}" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="household_expense">Household Expense </label>
                                    <input type="number" class="form-control" min="0" name ="household_expense" id ="household_expense" value="{{$info->household_expense}}" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="financial_risk_assessment">Financial Risk Assessment</label>
                                    <input type="number" class="form-control" min="0" name ="financial_risk_assessment" id ="financial_risk_assessment" value="{{$info->financial_risk_assessment}}" required >
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                
                                    <label for="credit_limit">Credit Limit</label>
                                    <input type="number"  readonly class="form-control" min="0" name ="credit_limit" id ="credit_limit" value ="{{$info->credit_limit}}" required>
                                </div>
                            </div>
                        
                    
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn" id="btnCompute"> Compute </button>
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
            </div>
        </div>
            
            <!-- /.col-lg-12 -->
    </div>
    
  
<div id="frmAlert" class="modal fade" role="dialog" style="z-index: 1800;">
  <div class="modal-dialog">
    <!-- Modal content-->
  
        <div class="alert alert-danger">
            <strong>Loan Error! </strong> Loan Applied is higher than the Credit Limit
        </div>
      
  </div>
</div>


<div id="test2" class="modal fade" role="dialog" style="z-index: 1600;">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <div class="modal-body">

        <table class="table table-striped" id="tblListToAdd">
            <thead>
                <th>Name</th>
                <th>Branch</th>
                <th>Action</th>
              
            </thead>
            <tbody>
                @foreach($list as $x)
                    <tr>
                        <td>{{$x->lastname.', '.$x->firstname.', '.$x->middlename}}</td>
                        <td>{{$x->branch()->first()->name}}</td>
                        <td><button class="btn btn-default comaker1" client_id = "{{$x->id}}" name = "{{$x->lastname.', '.$x->firstname.', '.$x->middlename}}">Pick as Co-Maker</button></td>
        
                    </tr>
                @endforeach
            </tbody>
        </table>  
      </div>      
    </div>
  </div>
</div>


@stop
@section('page-script')
<script>
var tags=[];
var mode=0;
/*
    $('.cashflow').click(function(e){
        var id = $(this).attr('client_id');
        $('#frmModal').attr('action','/Api/Loans/Analysis/'+id)
        $('#client_id').val(id)
        $.ajax({
            url:'/Api/Loans/Analysis',
            data:{id:id},
            dataType:'JSON',
            type:'GET',
            success:function(data){
                $('#business_net_disposable_income').val(data.business_net_disposable_income);
                $('#household_income').val(data.household_income);
                $('#household_expense').val(data.household_expense);
                $('#financial_risk_assessment').val(data.financial_risk_assessment);
                $('#credit_limit').val(data.credit_limit);
                 $('#mdlCashflow').modal('show');

            }
        })
        e.preventDefault();
    })
*/
    $('#btnCompute').click(function(e){
        var BNDI = parseInt($('#business_net_disposable_income').val())
        var HI = parseInt($('#household_income').val())
        var HE = parseInt($('#household_expense').val())

        //credit limit 
        //CL = [BNDI + (HI - HE)]
        var CL = (BNDI + (HI - HE))
        $('#credit_limit').val(CL);
    })
/*
    $("#slctPurpose").change(function(){
        if($(this).val()=="Others"){
            $('#divGroup').removeClass('hidden')
           
            $(this).addClass('hidden')
        }else{
            
            $('#purpose').val($(this).val())            
        }
    })
    $('#btnShowPurposeList').click(function(){
        $('#divGroup').addClass('hidden')
        $('#slctPurpose').removeClass('hidden')
    })
    $('#mdlCashflow').on('hidden.bs.modal',function(){
        $('#purpose').addClass('hidden')
        $('#slctPurpose').show()
    })
    
    */
    
    $(".btnshow").click(function(){
        mode= $(this).attr('mode')
        $('#test2').modal('show')
    })
    
    $('.comaker1').click(function(){
        var id = $(this).attr('client_id') 
        $.ajax({
            url:'/Api/Loans/CheckCoMaker',
            data:{client_id:id},
            dataType:'JSON',
            type:'GET',
            success:function(data){
                alert(data.MSG);
            }
        })
    })
    $(function(){
        $('#tblListToAdd').DataTable();
        
    })

    $('.comaker1').click(function(){
        if(mode=="cm1"){
            $('#cm1').val($(this).attr('name'))
            $('#co_maker_inside_cluster_id').val($(this).attr('client_id'))
        }else{
            $('#cm2').val($(this).attr('name'))
            $('#co_maker_outside_cluster_id').val($(this).attr('client_id'))
            
        }
         $('#test2').modal('hide')
       
    })
    /*
InvalidInputHelper(document.getElementById("loan_amount"), {
  defaultText: "Please enter Loan Amount",

  emptyText: "Please enter Loan Amount",

  invalidText: function (input) {
    return $('#slctAppliedLoan').val() +' must only have values from '+$("#slctAppliedLoan option:selected").attr("min")+' - '+$("#slctAppliedLoan option:selected").attr("max");
  }
});

$('#loan_amount').change(function(){
    if($('#loan_amount').val() % 1000 !=0){
        $('#loan_validation').html('Loan Amount must be  / 1000')
        $('#loan_validation').addClass('alert-danger')
    }else{
        $('#loan_validation').html('Loan Amount')
        $('#loan_validation').removeClass('alert-danger')
        var loan = parseInt($('#loan_amount').val())
        var months = parseInt($('#loan_term').val())
        var interest = (loan * .03) * months
        $('#loan_interest').val(interest)
        var total_loan = loan + interest
        var weeks_to_pay = parseInt($('#weeks_to_pay').val())
        var weekly_amort= Math.round(total_loan / weeks_to_pay)
        var cbu = loan * .05

        $('#loan_total').val(total_loan)
        $('#weekly_amortization').val(weekly_amort)
        $('#weekly_cbu').val(cbu)
    }
    
   
})
$('#weeks_to_pay').change(function(){
    if($('#loan_amount').val() % 1000 !=0){
        $('#loan_validation').html('Loan Amount must be  / 1000')
        $('#loan_validation').addClass('alert-danger')
    }else{
        $('#loan_validation').html('Loan Amount')
        $('#loan_validation').removeClass('alert-danger')
        var loan = parseInt($('#loan_amount').val())
        var months = parseInt($('#loan_term').val())
        var interest = (loan * .03) * months
        $('#loan_interest').val(interest)
        var total_loan = loan + interest
        var weeks_to_pay = parseInt($('#weeks_to_pay').val())
        var weekly_amort= Math.round(total_loan / weeks_to_pay)
        var cbu = loan * .05

        $('#loan_total').val(total_loan)
        $('#weekly_amortization').val(weekly_amort)
        $('#weekly_cbu').val(cbu)
    }
    
   
})

$('#frmModal').submit(function(e){
    var cl = parseInt($('#credit_limit').val())
    var loan_applied = parseInt($('#loan_amount').val())
    if(cl < loan_applied){
        $('#frmAlert').modal('show')
        e.preventDefault()

    }else{
        
    }
})

*/
</script>
@stop