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
                <h2>Total Clusters: <b>{{$clusters->count()}}</b></h2>
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
                <th>Recent Collection Date</th>
                <th>Next Collection Date</th>
                <th>Paid</th>
                <th>Loan Amount</th>
               
                <th>CBU Collection</th>
                
                <th>Action</th>
            </thead>
            <tbody>
                @foreach($clusters as $x)
                    <tr>
                        <td>{{$x->clusterInfo->code}}</td>
                        <td>{{$x->clusterInfo->totalMembers($x->cluster_id)}}</td>
                        <td>{{$x->lastCollection()}}</td>
                        <td>{{$x->nextCollection()}}</td>
                        <td><b>{{pesos($x->totalPaid())}}</b></td>
                        <td><b>{{pesos($x->loan_amount)}}</b></td>
           
                        <td><b>{{pesos($x->cbuCollected())}} </b></td>
                        <td><a href="/Collected/Cbu/{{$x->id}}"><button class="btn btn-sm btn-default"> CBU </button></a><a href="{{url()->current().'/'.$x->id.'/'.$x->nextCollection()}}"><button type = "button"     class="btn btn-default btn-sm">Collect</button></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>  
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

</script>
@stop