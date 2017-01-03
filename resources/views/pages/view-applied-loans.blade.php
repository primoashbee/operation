@extends('layouts.admin-layout')
@section('content')

    <div style="margin-top:30px"></div>
    

    <div id="step-1">
      
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> List of All Loans</h1>
                <h2>Total Clients: <b>{{$list->total()}}</b></h2>
                <div class="row">
                <form action="/Loans/Applied" method="get">
                    
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
                <th>Cluster</th>
                <th>Loan Type</th>
                <th>Loan Amount</th>
                <th>Status</th>
                <th>Released</th>
                <th>Action</th>
            </thead>
            <tbody>
           
                @foreach($list as $x)
                    <tr>
                        <td>{{$x->clientInfo()->first()->firstname.' '.$x->clientInfo()->first()->lastname}}</td>
                        <td>{{$x->clientInfo()->first()->branch()->first()->name}}</td>
                        <td>{{$x->clientInfo()->first()->cluster()->first()->clusterInformation()->first()->code}}</td>
                        <td>{{$x->product()->first()->name}}</td>
                        <td>{{$x->loan_amount}}</td>
                        
                        <td><span class="label {{$x->status == 'ON GOING' ? 'label-success' : 'label-primary'}}">{{$x->status}}</span></td>
                        <td>TRUE</td>
                        <td><button type="button" class="btn btn-sm btn-default view-loan" loan_id = "{{$x->id}}"><i class="fa fa-eye" aria-hidden="true"></i></button></td>
                     </tr>
                @endforeach
            </tbody>
        </table>  
        {{$list->links()}}
    </div>
      <div id="mdlLoanInfo" class="modal fade modal-wide" role="dialog" style="z-index:1400">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">Loan Application for: <b><span id="lblName"></span></b></h2>
                </div>
                <div class="modal-body">
                  
                    <h3>Loan Amount : 16000 </h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" id="btnCompute"> Compute </button>
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </div>

            </div>
        </div>
@stop
@section('page-script')
<script>
$('.view-loan').click(function(){
    var id = $(this).attr('loan_id')
    $.ajax({
        url:'/Api/Loans/Information/'+id,
        type:'GET',
        data:{},
        success:function(data){
            console.log(data.business_net_disposable_income )
        }
    })
    $('#mdlLoanInfo').modal('show')
})
</script>
@stop