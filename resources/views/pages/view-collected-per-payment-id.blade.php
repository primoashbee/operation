@extends('layouts.admin-layout')
@section('content')

    <div style="margin-top:60px" class="clearfix"></div>
    <div class="well clearfix">
                
            <h2 class="text-center"><b>Disbursement Information</b></h2>
            <div class="col-lg-4 col-md-4">
                   <h4>CV #: <b>{{$loans->cv_number}}</b></h4>
            </div>
            <div class="col-lg-4 col-md-4">
                   <h4>PAYEE : <a href ="\Clients\Update\{{$loans->payee_id}}"><b>{{$loans->payeeName->firstname. ' '.$loans->payeeName->lastname}}</b></a></h4>
            </div>
            <div class="col-lg-4 col-md-4">
                   <h4>RELEASED DATE: <b>{{$loans->release_date}}</b></h4>
            </div>
            <div class="col-lg-4 col-md-4">
                   <h4>LOAN AMOUNT: <b>{{pesos($loans->loan_amount)}}</b></h4>
            </div>
            <div class="col-lg-4 col-md-4">
                   <h4>CLUSTER: <b>{{$loans->clusterInfo->code}}</b></h4>
            </div>
            <div class="col-lg-4 col-md-4">
                   <h4>MATURITY DATE: <b>{{$loans->maturity_date}}</b></h4>
            </div>
            <div class="col-lg-12 col-md-12">
                   <h4 style="overflow:ellipsis">CHECK #: <b>{{$loans->check_number}}</b></h4>
            </div>
            
        </div>
    <h1 class="text-center">Collection Summary</h1>
    <h3 > Week #:<b>{{$collection{0}->amortizationInfo()->week}}</b></h3>
    <a href="\Downloads\Collected\{{$id}}"><button class="btn btn-lg btn-default">Download Collection  <i class="fa fa-cloud-download" aria-hidden="true"></i></button></a>
    <div class="">
    <table class="table table-striped">
    <thead>
        <th>Client Name</th>
        <th>Past Due</th>
        <th>Week Due</th>
        <th>Total due</th>
        <th>Amount Paid</th>
        <th>Balance This Week</th>
        
    </thead>
        @foreach($collection as $x)
            <?php 
            ?>
            <tr>
                <td>{{$x->amortizationInfo()->clientInfo->firstname.' '.$x->amortizationInfo()->clientInfo->lastname}}</td>
                <td>{{pesos($x->lastWeekDue()->total_amount==null ? '0' :$x->lastWeekDue()->total_amount)}}</td>
                <td>{{pesos($x->weekDue()->principal_with_interest) }}</td>               
                <td>{{pesos( $x->lastWeekDue()===null ? $x->lastWeekDue()->total_amount + $x->weekDue()->principal_with_interest : $x->weekDue()->principal_with_interest) }}</td>
                <?php 
                    $total;
                    $x->lastWeekDue()->total_amount==null ? $total = 0 + $x->weekDue()->principal_with_interest: $total = $x->lastWeekDue()->total_amount + $x->weekDue()->principal_with_interest;
                    
                ?>
                <td class="{{$x->amount_paid == $total ? 'alert alert-success' :'alert alert-warning'}}">{{pesos($x->amount_paid)}}</td>
                <td class="{{$x->amount_paid == $total ? 'alert alert-success' :'alert alert-danger'}}">{{pesos($x->this_week_balance)}}</td>
            </tr>
        @endforeach
    <tbody> 
  
    </tbody>
    </table>
    </div>
   

@stop
@section('page-script')

@stop