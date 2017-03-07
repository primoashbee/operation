@extends('layouts.admin-layout')
@section('content')

    <div style="margin-top:30px"></div>
    

    <div id="step-1">
      
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> List of All Clients</h1>
                <h2>Total Clients: <b></b></h2>
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
        <table class="table table-striped" id="tblMain">
            <thead>
                <th>Client Name</th>
                <th>CBU Deposited</th>
                <th>Date</th>
                <th>Week</th>
            </thead>
            <tbody>
                @foreach($data as $x)
                <tr>
                        <td>{{$x->clientInfo()->firstname.' '.$x->clientInfo()->lastname}}</td>
                        <td>{{pesos($x->amount)}}</td>
                        <td>{{$x->paymentSummary()->getPaymentSummary()->created_at}}</td>
                        <td>{{$x->paymentSummary()->amortizationInfo()->week}}</td>
                        
                </tr>
                @endforeach 
            </tbody>
        </table>  
       
    </div>
   
@stop
@section('page-script')
    <script>
        $(function(){
            $('#tblMain').DataTable();
        })
    </script>
@stop