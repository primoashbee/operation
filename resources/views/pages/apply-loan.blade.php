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
                <h2>Total Clients: <b>{{$clients->total()}}</b></h2>
                <div class="row">
                <form action="/Loans/Analysis" method="get">
                    
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
                <th>Name</th>
                <th>Branch</th>
                <th>Cluster Code</th>
                <th>Mobile #</th>
                
                <th>Action</th>
            </thead>
            <tbody>
           
                @foreach($clients as $x)
                    <tr>
                        <td>{{$x->firstname. ', '.$x->lastname}}</td>
                        <td>{{$x->branch()->first()->name}}</td>
                        <td>{{$x->cluster()->first() == null ? 'NONE' :$x->cluster()->first()->clusterInformation()->first()->code }}</td>
                        <td>{{$x->mobile_number}}</td>
                        
                        <td><a href="#" client_id="{{$x->id}}" class="cashflow"><button class="btn btn-sm btn-success">Apply Loan</button></a>
                    </tr>
                @endforeach
            </tbody>
        </table>  
        {{$clients->links()}}
    </div>
   <!-- Modal -->
    <form action ="/Loans/Application" method="POST" id="frmModal">
        {{csrf_field()}}
        <div id="mdlCashflow" class="modal fade modal-wide" role="dialog" style="z-index:1400">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">Loan Application for: <b><span id="lblName"></span></b></h2>
                </div>
                <div class="modal-body">
                    <h4>Loan Information <h4>
                    <div id="Loan Application">
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="purpose">Applied Loan </label>
                                <select class="form-control" id="slctAppliedLoan" name ="product_id" required>
                                    <option value="" min = "0" max="0">-Please Select-</option>   
                                
                                    @foreach($products as $x)
                                        <option value="{{$x->id}}"  min = "{{$x->min}}" max="{{$x->max}}">{{$x->name}}</option>   
                                    @endforeach
                                </select>
                               <input type="hidden" id="client_id" name="client_id" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="purpose">Purpose </label>
                                <select class="form-control" id="slctPurpose" required>
                                    <option value="">-Please Select-</option>
                                    <option value="Business">Business</option>
                                    <option value="Housing Renovation">Housing Renovation</option>
                                    <option value="Education">Education</option>
                                    <option value="Asset Purchase">Asset Purchase</option>
                                    <option value="Others">Others</option>
                             </select>
                            <div class="input-group hidden" id="divGroup"> <input class="form-control "   id="purpose" name="purpose" placeholder="Purpose" aria-describedby="btnBackk"> <span class="input-group-addon" id="btnShowPurposeList">Back</span> </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="loan_amount" id= "loan_validation">Loan Amount </label> 

                                <input type="number" class="form-control" min="2000" max="99000" name ="loan_amount" id ="loan_amount" required >
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2">
                            <div class="form-group">
                                <label for="loan_term">Loan Term</label>
                               
                                <select name="loan_term" id="loan_term" class="form-control" required>
                                    <option value="6">6 Months </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2">
                            <div class="form-group">
                                <label for="weeks_to_pay">Weeks To Pay</label>
                               
                                <select name="weeks_to_pay" id="weeks_to_pay" class="form-control" required>
                                    <option value="22">22 Weeks </option>
                                    <option value="24">24 Weeks </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="loan_interest">Interest</label>
                                <input type="number" readonly class="form-control" min="0" name ="loan_interest" id ="loan_interest" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="loan_total">Total Loan</label>
                                <input type="number" class="form-control" min="0" name ="loan_total" id ="loan_total" required >
                            </div>
                        </div>
                
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                            
                                <label for="weekly_amortization">Weekly Amortization</label>
                                <input type="number"  class="form-control" min="0" name ="weekly_amortization" id ="weekly_amortization" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                            
                                <label for="weekly_cbu">Capital Build Up (CBU)</label>
                                <input type="number"  class="form-control" min="0" name ="weekly_cbu" id ="weekly_cbu" required>
                            </div>
                        </div>
                        <hr> <h4>Co-Maker Information</h4>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                            
                                <label for="cm1">Co Maker 1 (Cluster Member)</label>
                                <input type="text"   class="form-control readonlyexcel" min="0" name ="cm1" id ="cm1" required>
                                <input type="hidden"  class="form-control" min="0" name ="co_maker_inside_cluster_id" id ="co_maker_inside_cluster_id" >
                                <button  class="btn btn-default btnshow" type="button" mode="cm1" >SHOW</button>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                            
                                <label for="cm2">Co Maker 2 (Non-Cluster Member)</label>
                                <input type="text"  class="form-control" min="0" name ="cm2" id ="cm2" required>
                                <input type="hidden"   class="form-control" min="0" name ="co_maker_outside_cluster_id" id ="co_maker_outside_cluster_id">
                                <button  class="btn btn-default btnshow" type="button" mode="cm2" >SHOW</button>
                            </div>
                        </div>

                
                    </div>
                <div class="clearfix"></div>
                    <hr> <h1> HAHAHA </h1>
                <div class="clearfix"></div>
                    <div id="cashflow_analysis">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="business_net_disposable_income">Business Net Disposable Income </label>
                                <input type="number" class="form-control" min="0" name ="business_net_disposable_income" id ="business_net_disposable_income"  required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="household_income">Household Income</label>
                                <input type="number" class="form-control" min="0" name ="household_income" id ="household_income" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="household_expense">Household Expense </label>
                                <input type="number" class="form-control" min="0" name ="household_expense" id ="household_expense" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="financial_risk_assessment">Financial Risk Assessment</label>
                                <input type="number" class="form-control" min="0" name ="financial_risk_assessment" id ="financial_risk_assessment"required >
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                            
                                <label for="credit_limit">Credit Limit</label>
                                <input type="number"  readonly class="form-control" min="0" name ="credit_limit" id ="credit_limit" required>
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
        </div>
    </form>

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