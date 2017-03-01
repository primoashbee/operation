@extends('layouts.admin-layout')
@section('content')

    <div style="margin-top:30px"></div>
    

    <div id="step-1">
      
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> List of All Clients</h1>
                <h2>Total Clients: <b>{{$clients->total()}}</b></h2>
                <div class="row">
                <form action="\Clients" method="get">
                    
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
                <th>Branch</th>
                <th>Cluster</th>
                <th>Mobile Number</th>
                <th>Action</th>
            </thead>
            <tbody>
           
                @foreach($clients as $x)
                    <tr>
                        <td>{{$x->lastname.', '.$x->firstname.', '.$x->middlename}}</td>
                        <td>{{$x->branch()->first()==null ? 'Branch Code Error' : $x->branch()->first()->name}}</td>    
                        <td>{{$x->cluster()->first()==null ? 'None' : $x->cluster()->first()->clusterInformation->code }}</td>
                        <td>{{$x->mobile_number}}</td>
                        <td>
                        <a href="\Clients\Update\{{$x->id}}"><button class="btn btn-sm btn-default">Update Info</button></a>
                        <a href="\Clients\Credit\{{$x->id}}"><button class="btn btn-sm btn-default">Credit Limit</button></a> 
                        <button class="btn btn-sm btn-default">Delete</button>
                    </tr>
                @endforeach
            </tbody>
        </table>  
        {{$clients->links()}}
    </div>
   
@stop
@section('page-script')
    <script>
        $(function(){
            $('#tblMain').DataTable();
        })
    </script>
@stop