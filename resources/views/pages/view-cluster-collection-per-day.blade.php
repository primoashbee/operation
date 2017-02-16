@extends('layouts.admin-layout')
@section('content')
    <div id="step-1">
        <div class="row">
            <div class="col-lg-12">
              
                
                
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
              
              
               
                
            </div>
            </div>
            
            <!-- /.col-lg-12 -->
        </div>
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
         <div class="col-lg-6 col-md-6">
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
        <div class="col-lg-6 col-md-6">
            <form action = "{{url()->current()}}" method="GET" id="form_filter">
                    
                <select class="form-control" name="collection_date"  id="collection_date" >
                    @if(\Request::get('collection_date')==null)
                        <option value="">
                            -
                        </option>
                    @else
                    <option value="{{\Request::get('collection_date')}}">
                            {{ \Request::get('collection_date') .' | ('.day_name(\Request::get('collection_date')).')'}}
                    </option>
                    <option value="">
                            -
                    </option>
                    @endif                        
                    @foreach($loans->getCollectionDates($loans->id) as $x)
                        <option value="{{$x->collection_date}}"> {{$x->collection_date}} | ({{day_name($x->collection_date)}})</option>
                    @endforeach
                    
                </select>
            </form>
        </div>
        <div class="clearfix"></div>
        <h4> Collection for the date: <b>{{\Request::get("collection_date")}}</b> Download File <a class="logo" href="/Downloads/Collection/CCRDownload/{{$disbursement_id.'/'.\Request::get('collection_date')}}"><i class="fa fa-download" aria-hidden="true"></i> </a> </h4>
        <div class="progress">
            <div class="progress-bar progress-bar-striped active {{$projected->css_class}}" role="progressbar"
            aria-valuenow="{{$projected->p_percentage }}" aria-valuemin="0" aria-valuemax="100" style="width:{{$projected->p_percentage }}%">   
            <b>{{$projected->p_percentage}}%</b>
            </div>
        </div>                                                   
        <table class="table table-striped">
            <thead>
                <th>Name</th>
                <th>Principal</th>
                <th>Interest</th>
                <th>Past Due</th>
            
                <th>Cashflow</th>
                <th>Principal Balance</th>
                <th>Interest Balance</th>
            </thead>
           
                @foreach($data as $x)
                    <tr>
                        <td>{{$x->clientInfo->firstname. ' '.$x->clientInfo->lastname}}</td>
                        <td>{{pesos($x->principal_this_week)}}</td>
                        <td>{{pesos($x->interest_this_week)}}</td>
                        
                        <td class="alert alert-danger">{{pesos($x->pastDue()->total_amount)}}</td>
                        
                        <td>{{pesos($x->principal_with_interest+$x->pastDue()->total_amount)}}</td>
                        <td>{{pesos($x->principal_balance)}}</td>
                        <td>{{pesos($x->interest_balance)}}</td>
                    </tr>
                @endforeach

            <tbody>
              
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
$("#collection_date").change(function(){
    $('#form_filter').submit();
})
</script>
@stop