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
                
                <th style="text-align:center">Action</th>
            </thead>
            <tbody>
           <?php $ctr=0; ?>
                @foreach($clusters as $x)
                    @if($x->isInBranch())        
                    <?php $ctr++; ?>
                    
                    <tr>
                        <td>{{$x->clusterInfo->code}}</td>
                        <td>{{$x->clusterInfo->totalMembers($x->cluster_id)}}</td>
                        <td><b>{{pesos($x->totalPaid())}}</b></td>
                        <td><b>{{pesos($x->loan_amount)}}</b></td>
                        <td>{{$x->clusterInfo->pa_lastname.', '.$x->clusterInfo->pa_firstname}}</td>
                        <td style="text-align:center">
                        <a href="{{url()->current().'/'.$x->id.'/Schedule?collection_date='.$x->nextCollection()}}"><button type = "button"     class="btn btn-default btn-sm">Check Composition</button></a>
                        <a href="{{url()->current().'/'.$x->id.'/Insurance'}}"><button type = "button"     class="btn btn-default btn-sm">Insurance Information</button></a>
                        
                        </td>
                    </tr>
                    @else
                      
                    @endif
                
                @endforeach
            </tbody>
        </table>  
    
        <h2>Total Clusters: <b>{{$ctr}}</b></h2>
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