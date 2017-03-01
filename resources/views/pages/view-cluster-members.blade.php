@extends('layouts.admin-layout')
@section('content')
    
    <div style="margin-top:60px" class="clearfix"></div>
   
    <h1> <b>{{$cluster_info->branch()->first()->operation}}</b> |<b> {{ $cluster_info->branch()->first()->name }}</b> </h1>
    <h2>Cluster Code: <b>{{$cluster_info->code}}</b>  </h2>
       
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('status'))

        <div class="{{ session('status')['code'] == 1 ? 'alert alert-success' :'alert alert-danger'}}">
            <h1> {{ session('status')['MSG'] }} </h1>
        </div>
    @endif
       
        <h4> Loan Officer: <b>{{$cluster_info->pa_lastname.', '.$cluster_info->pa_firstname}}</b></h4>
     
        <form action ="" method="post">
            <div class="col-lg-12 ">
                {{csrf_field()}}
                <div class="form-group has-feedback">
                    <label for="search" class="sr-only">Search</label>
                    <input type="text" class="form-control" name="search" id="search" placeholder="search">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
                         
            </div>
        </form>
    <div class="" >
        <div id="current_members">
                <button class="btn btn-default" id="btn_add_members"> Add Members </button>
                <table class="table table-striped">
                <thead>
                <th>Name</th>
                <th>Address</th>
                <th>Action</th>
                </thead>
                <tbody>
                    @foreach($members->all() as $x)
                        <tr>
                       
                        <td>{{$x->name->firstname.' '.$x->name->lastname }}</td>
                        
                        <td>{{$x->name->home_address}}</td>
                        <td><a href="/Clients/Update/{{$x->name->id}}"><button class="btn btn-sm btn-success">Update Client Information </button></a> 
                        <a href="/Cluster/{{$id}}/Members/Remove/{{$x->name->id}}"><button class="btn btn-sm btn-danger">Remove </button></a> </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
        </div>
        
        <div id="list_to_add" style="display: none;">
            <form action "/Cluster/{{Request::segment(1)}}/Members/Add" method= "post" id="frmAddToCluster">
                {{csrf_field()}} 
                <input type="hidden" name = "cluster_id" value="{{$id}}">

                <button class="btn btn-default" id="btn_back"> Back </button>
                <table class="table table-striped" id="myTable">
                <thead>
                <th></th>
                <th>Name</th>
                <th>Address</th>
                <th>Action</th>
                </thead>
                <tbody>
               
                    @foreach($clients_to_add as $x)
                        <tr>
                        <td><input type="checkbox" name="client_id[]" value="{{$x->id}}"></td>
                        <td>{{$x->lastname}}</td>
                        
                        <td>{{$x->home_address}}</td>
                        <td><a href="/Cluster/{{$id}}/Members/Add/{{$x->id}}"><button class="btn btn-sm btn-default">Update Cluster</button></a> <a href="/Cluster/{{$x->id}}/Members"><button class="btn btn-sm btn-default">Loans</button></a></td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
                <input type="submit">
            </form>
        </div>

    </div>
    
   
    {{$members->links()}}

@stop
@section('page-script')
<script>
 var oTable
$(function(){
    $('#myTable').DataTable();
    oTable = $('#data_table').dataTable();
    $('#list_to_add').hide();
    $('tr').click(function(event) {
        if (event.target.type !== 'checkbox') {
        $(':checkbox', this).trigger('click');
        }
    });
})
$("#btn_add_members").click(function(){
    
    $('#current_members').hide(500)
    $('#list_to_add').show(500)

})
$("#btn_back").click(function(e){
    
    $('#current_members').show(500)
    $('#list_to_add').hide(500)
    e.preventDefault()

})

$('#frmAddToCluster').submit(function () {
            $("input[name='question']").remove();  //Remove the old values
            $("input:checked", oTable.fnGetNodes()).each(function(){
                $('<input type="checkbox" name="questions" ' + 'value="' +
                  $(this).val() + '" type="hidden" checked="checked" />')
                    .css("display", "none")
                    .appendTo('#form');
            });
});


</script>
@stop