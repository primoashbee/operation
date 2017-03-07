@extends('layouts.new')
@section('content')
        <!-- page content -->
 
<div class="right_col" role="main">
    <div class="clearfix"></div> 


</div>
        <!-- /page content -->
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

