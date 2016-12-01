@extends('layouts.admin-layout')
@section('content')

    <div style="margin-top:60px" class="clearfix"></div>
    <h1>List of All Clusters</h1>
        <h3>Displaying <b><i>{{$information->count().'/'.($information->total())}} </i></b>Clusters</h3>
        <form action ="\Cluster" method="post">
            <div class="col-lg-12 ">
            {{csrf_field()}}
                <div class="form-group has-feedback">
                    <label for="search" class="sr-only">Search</label>
                    <input type="text" class="form-control" name="search" id="search" placeholder="search">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
                         
            </div>
        </form>
    <div class="">
    <table class="table table-striped">
    <thead>
    <th>Branch</th>
    <th>Code</th>
    <th>Loan Officer</th>
    <th>Action</th>
    </thead>
    <tbody>
        @foreach($information as $x)
            <tr>
            <td>{{$x->branch()->first()->name}}</td>
            <td>{{$x->code}}</td>
            
            <td>{{$x->pa_lastname.' '.$x->pa_firstname.' '.$x->pa_middlename}}</td>
            <td><a href="/Cluster/Update/{{$x->id}}"><button class="btn btn-sm btn-default">Update Cluster</button></a> <a href="/Cluster/{{$x->id}}/Members"><button class="btn btn-sm btn-default">Members Management</button></a></td>
            </tr>
        @endforeach
    </tbody>
    </table>
    </div>
   
    {{$information->links()}}

@stop
@section('page-script')

@stop