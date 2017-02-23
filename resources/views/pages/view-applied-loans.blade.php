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
                <th>Paid</th>
                <th>Loan Amount</th>
               
                <th>Loan Officer</th>
                
                <th>Action</th>
            </thead>
            <tbody>
           
                @foreach($clusters as $x)
                    <tr>
                        <td>{{$x->clusterInfo->code}}</td>
                        <td>{{$x->clusterInfo->totalMembers($x->cluster_id)}}</td>
                        <td><b>{{pesos($x->totalPaid())}}</b></td>
                        <td><b>{{pesos($x->loan_amount)}}</b></td>
                        <td>{{$x->clusterInfo->pa_lastname.', '.$x->clusterInfo->pa_firstname}}</td>
                        <td><a href="{{url()->current().'/'.$x->id}}"><button type = "button"     class="btn btn-default btn-sm">Check Composition</button></a></td>
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

</script>
@stop