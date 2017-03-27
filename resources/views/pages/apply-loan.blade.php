@extends('layouts.admin-layout')
@section('content')

    <div style="margin-top:30px"></div>


    <div id="step-1">
      
        <div class="row">
            <div class="col-lg-12">
              
                
                <h1 class="page-header"> List of All Clients</h1>
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
                <h2>Total Clusters: <b>{{$clusters->total()}}</b></h2>
                <div class="row">
                <form action="{{url()->current()}}" method="get">
                    
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
                <th>Cluster Code</th>
                <th>Members</th>
                <th>Status</th>
                <th>Loan Officer</th>
                
                <th>Action</th>
            </thead>
            <tbody>
           
                @foreach($clusters as $x)
                    <tr>
                        <td>{{$x->code}}</td>
                        <td>{{$x->totalMembers($x->id) }}</td>
                        <td><span class="label label-{{$x->status()=='On-Going Collection' ? 'danger' : 'success'}}">{{($x->status())}}</span></td>
                        <td>{{$x->pa_firstname.' '.$x->pa_lastname}}</td>
                        <td><a href="/Loans/Disbursement/{{$x->id}}" ><button class="btn btn-sm btn-success">Apply Loan</button></a>
                    </tr>
                @endforeach
            </tbody>
        </table>  
        {{$clusters->links()}}
    </div>
   <!-- Modal -->
    

<div id="frmAlert" class="modal fade" role="dialog" style="z-index: 1800;">
  <div class="modal-dialog">
    <!-- Modal content-->
  
        <div class="alert alert-danger">
            <strong>Loan Error! </strong> Loan Applied is higher than the Credit Limit
        </div>
      
  </div>
</div>




@stop
@section('page-script')
<script>
var tags=[];
var mode=0;
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

    $('#btnCompute').click(function(e){
        var BNDI = parseInt($('#business_net_disposable_income').val())
        var HI = parseInt($('#household_income').val())
        var HE = parseInt($('#household_expense').val())

        //credit limit 
        //CL = [BNDI + (HI - HE)]
        var CL = (BNDI + (HI - HE))
        $('#credit_limit').val(CL);
    })
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
        $('#mdlCashflow').modal('show')
    })
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


</script>
@stop