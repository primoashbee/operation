@extends('layouts.admin-layout')
@section('content')

    <div style="margin-top:30px"></div>
    

    <div id="step-1">
      
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> List of All Clients</h1>
                <h2>Total Clients: <b></b></h2>
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
                <th>Cluster Code</th>
                <th>Disbursement Date</th>
                <th>Due</th>
                <th>Collected Amount</th>
                <th>Interest Due</th>
                <th>Principal Due</th>
                <th>Total Past Due</th>
                <th>Collection Date</th>
                
            </thead>
            
            <tbody>
                @foreach($summaries as $x)
                    <tr>
                        <td>{{$x->getDisbursement->clusterInfo->code}}</td>
                        <td>{{$x->getDisbursement->release_date}}</td>
                        <td>{{pesos($x->total_amount_due)}}</td>
                        <td>{{pesos($x->amount_paid)}}</td>
                       
                        <td class="alert alert-danger">{{pesos($x->interest_not_collected)}}</td>
                        <td class="alert alert-danger">{{pesos($x->principal_not_collected)}}</td>
                        <td class="alert alert-danger">{{pesos($x->interest_not_collected + $x->principal_not_collected)}}</td>
                        <td>{{$x->collection_date}}</td> 
                        
                    </tr>
                @endforeach

            </tbody>
        </table>  
        
        
       
    </div>
   
@stop
@section('page-script')

@stop