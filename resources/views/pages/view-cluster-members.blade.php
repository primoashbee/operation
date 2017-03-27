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
                <table class="table table-striped listing" id = "tblMain">
                <thead>
                <th>Name</th>
                <th>Address</th>
                <th>Action</th>
                </thead>
                <tbody >
                    @foreach($members->all() as $x)
                        <tr>
                        <td>
                        @if($x->name->sex=="Male")
                        <div><img class="photo-icon img_src img-circle"  alt="{{$x->name->firstname.' '.$x->name->lastname}}" src="{{$x->name->img_src==null ? '/photo/clients/2x2-filler m.jpg' : $x->name->img_src}}"> {{$x->name->firstname.' '.$x->name->lastname }}</div></td>
                        @else
                        <div><img class="photo-icon img_src img-circle"  alt="{{$x->name->firstname.' '.$x->name->lastname}}" src="{{$x->name->img_src==null ? '/photo/clients/2x2-filler f.jpg' : $x->name->img_src}}"> {{$x->name->firstname.' '.$x->name->lastname }}</div></td>
                       
                        @endif

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
                <table class="table table-striped listing" id="tblToAdd">
                <thead>
                <th></th>
                <th>Client Code</th>
                <th>Name</th>
                <th>Address</th>
              
                </thead>
                <tbody>
               
                    @foreach($clients_to_add as $x)
                        <tr>

                        <td><input class="cToAdd" type="checkbox" name="client_id[]" value="{{$x->id}}"></td>
                        <td>{{$x->client_code}}</td>
                        <td><div><img class="photo-icon img_src img-circle" alt="{{$x->firstname.' '.$x->lastname}}" src="{{$x->img_src==null ? '/photo/clients/2x2-filler.jpg' : $x->img_src}}">  {{$x->firstname.' '.$x->lastname}}</div></td>
                        
                        <td>{{$x->home_address}}</td>
                        
                        </tr>
                    @endforeach
                </tbody>
                </table>
                <input type="submit" class="btn btn-default">
            </form>
        </div>

    </div>
    
   
    {{$members->links()}}


 
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">              
      <div class="modal-body" >
      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        
        <img src="" class="imagepreview thumbnail" style="width: 100%;" >
        <center><b><h4 id="preview-name"></h4></b></center>
      </div>
    </div>
  </div>
</div>  
@stop
@section('page-script')
<script>
 var table
$(function(){
   table= $('table.listing').DataTable();
   

})

$('.img_src').click(function(){
    var src = $(this).attr('src')
    var name = $(this).attr('alt')
    $('.imagepreview').attr('src', src);
    $('#preview-name').html(name);
    $('#imagemodal').modal('show');   
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

$('#frmAddToCluster').submit(function (e) {
        var $form = $(this);
            // Iterate over all checkboxes in the table
            table.$('input[type="checkbox"]').each(function(){
                // If checkbox doesn't exist in DOM
                if(!$.contains(document, this)){
                    // If checkbox is checked
                    if(this.checked){
                        // Create a hidden element 
                        $form.append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', this.name)
                            .val(this.value)
                        );
                    }
                } 
            });          
});



$('.img_src').click(function(){
var src = $(this).attr('src')
var name = $(this).attr('alt')
			$('.imagepreview').attr('src', src);
			$('#preview-name').html(name);
			$('#preview').css('overflow-y', 'auto'); 
            $('#preview').css('max-height', $(window).height() * 2);
            $('#large_image').css('max-height: calc(100vh - 225px);');

})
</script>
@stop