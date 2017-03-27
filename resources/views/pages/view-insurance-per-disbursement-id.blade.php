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
                <th>Name</th>
                <th style="width:15%">Enrolees</th>
                <th>MI Premium CBLIC</th>
                <th>MI Premium LMI FEE</th>
                <th>CLI Premium CBLIC</th>
                <th>CLI Premium LMI</th>
                
            </thead>
            <tbody>
            
                @foreach($clients as $x)
                        <td>{{$x->clientInfo->firstname.' '.$x->clientInfo->lastname}}</td>
                        <td>{{($x->insuranceInformation()->description)}}</td>
                        <td>{{pesos($x->mi_premium_cblic)}}</td>
                        <td>{{pesos($x->mi_premium_lmi)}}</td>
                        <td>{{pesos($x->cli_premium_cblic)}}</td>
                        <td>{{pesos($x->cli_premium_lmi)}}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                    <tr>
                        <td># of Clients: <b>{{$clients->count()}}</b></td>
                        <td># of Enrolled: <b>{{$head_count}} (<i>{{$dependents_only}} Dependents </i>)</b></td>
                        <td><b>{{pesos($clients->sum('mi_premium_cblic'))}}</b></td>
                        <td><b>{{pesos($clients->sum('mi_premium_lmi'))}}</b></td>
                        <td><b>{{pesos($clients->sum('cli_premium_cblic'))}}</b></td>
                        <td><b>{{pesos($clients->sum('cli_premium_lmi'))}}</b></td>
                       
                    </tr>
            </tfoot>
        </table>  
    </div>
   
@stop
@section('page-script')
    <script>
        $(function(){
            $('#tblMain').DataTable({
            })      

        })
    </script>
@stop