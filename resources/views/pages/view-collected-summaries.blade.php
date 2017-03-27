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
        <table class="table table-striped" id="tblMain">
            <thead>
                <th>Cluster Code</th>
                <th>Previous Week Due</th>
                <th>Amortization Due</th>
                <th>This Week Due</th>
                <th>Collected Amount</th>
               
                <th>Past Due</th>
                <th>Collected On</th>
                <th>Action</th>
                
            </thead>
            
            <tbody>
            <?php $ctr=0;?>
                @foreach($summaries as $x)
                    <?php  $ctr+=$x->this_week_due ?>
                    <tr>
                        <td>{{$x->getDisbursement->clusterInfo->code}}</td>
                        <td class="alert alert-danger">{{pesos($x->last_week_past_due)}}</td>
                        <td class="">{{pesos($x->this_week_due)}}</td>
                        <td class="{{$x->this_week_total_amount_due == $x->amount_paid ? 'alert alert-success' : 'alert alert-danger'}}">{{pesos($x->this_week_total_amount_due)}}</td>
                        <td class="{{$x->this_week_total_amount_due == $x->amount_paid ? 'alert alert-success' : 'alert alert-danger'}}"> {{pesos($x->amount_paid)}}</td>
                        <td class="{{$x->interest_not_collected + $x->principal_not_collected == 0 ? 'alert alert-success' : 'alert alert-danger'}}">{{pesos($x->interest_not_collected + $x->principal_not_collected)}}</td>
                        <td>{{$x->collection_date}}</td> 
                        
                        <td><a href="{{url()->current().'/'.$x->id}}" class="btn-icon"><button class="btn"><i class="fa fa-eye" aria-hidden="true"></i></button></a></td> 
                        
                    </tr>
                @endforeach

            </tbody>
        </table>  
        {{$summaries->links()}}
       
       {{$ctr}}
    </div>
   
@stop
@section('page-script')
<script>
    $(function(){
        $('#tblMain').DataTable();
    })
</script>
@stop