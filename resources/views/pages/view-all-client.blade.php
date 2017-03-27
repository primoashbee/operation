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
                          
                                <div class="container form-group has-feedback">
                                    <div class="form-inline">
                                        <label for="search" class="sr-only">Search</label>
                                        <select class="form-control" name="filter" id="filter_option" >
                                            <option value="">---CHOOSE FILTERING OPTION---</option>
                                            <option value="">ALL</option>
                                            <option value="client_code">CLIENT CODE</option>
                                            <option value="lastname">LASTNAME</option>
                                            <option value="firstname">FIRSTNAME</option>
                                            <option value="middlename">MIDDLENAME</option>
                                            <option value="mobile_number">MOBILE NUMBER</option>
                                            <option value="sex">GENDER</option>
                                            <option value="birthday" type="fullbirthday">BIRTHDAY</option>
                                            <option value="birthday" type="year">YEAR OF BIRTH</option>
                                        
                                        </select>
                                        <input type="text" class="form-control" name="search" id="search" placeholder="search" style="width:50%">
                                        <input type="date" class="form-control" id="date_search" placeholder="search" style="width:50%;display:none;">
                                        <select id="sex" class="form-control" style="width:50%;display:none;">
                                            <option value="">-----</option>
                                            <option value="female">Female</option>
                                            <option value="male">Male</option>
                                        </select>
                                        <input type="submit" class="btn btn-default">
                                    </div>
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
                <th>ID</th>
                <th>Name</th>
                <th>Branch</th>
                <th>Age</th>
                <th>Cluster</th>
                <th>Mobile Number</th>
                <th>Action</th>
            </thead>
            <tbody>
           
                @foreach($clients as $x)
                    <tr>
                        <td>{{$x->client_code}}</td>
                        
                        <td>
                        @if($x->sex=="Male")
                            <div><img class="photo-icon img_src img-circle"  alt="{{$x->firstname.' '.$x->lastname}}" src="{{$x->img_src==null ? '/photo/clients/2x2-filler m.jpg' : $x->img_src}}"> {{$x->firstname.' '.$x->lastname }}</div></td>
                        @else
                            <div><img class="photo-icon img_src img-circle"  alt="{{$x->firstname.' '.$x->lastname}}" src="{{$x->img_src==null ? '/photo/clients/2x2-filler f.jpg' : $x->img_src}}"> {{$x->firstname.' '.$x->lastname }}</div></td>
                       
                        @endif
                        </td>
                        
                        <td>{{$x->branch()->first()==null ? 'Branch Code Error' : $x->branch()->first()->name}}</td>    
                        <td>{{$x->getAge()}}</td>    
                        <td>{{$x->cluster()->first()==null ? 'None' : $x->cluster()->first()->clusterInformation->code }}</td>
                        <td>{{$x->mobile_number}}</td>
                        <td>
                        <a href="\Clients\Update\{{$x->id}}"><button class="btn btn-sm btn-default">Update Info</button></a>
                        <button class="btn btn-sm btn-default">Delete</button>
                    </tr>
                @endforeach
            </tbody>
        </table>  
        {{$clients->links()}}
    </div>
   
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
        $(function(){
            //$('#tblMain').DataTable();
            $('.img_src').click(function(){
            var src = $(this).attr('src')
            var name = $(this).attr('alt')
                        $('.imagepreview').attr('src', src);
                        $('#preview-name').html(name);
                        $('#imagemodal').modal('show');   
            })
        
        })

        $('#filter_option').change(function(){
            if($(this).val()=="birthday" && $('option:selected',$(this)).attr('type')=="fullbirthday"){
                
                $('#search').hide()
                $('#sex').hide()
                $('#date_search').show()
            }else if($(this).val()=="sex"){
                $('#search').hide()
                $('#sex').show()
                $('#date_search').hide()
            }else{
                $('#search').val('')
                $('#search').show()

                $('#sex').hide()
                $('#date_search').hide()
            }
        })
        $('#date_search').change(function(){
            console.log($(this).val());
            $('#search').val($(this).val())
        })
        $('#sex').change(function(){
            val = $(this).val()
            
            $('#search').val($(this).val())
        })
    </script>
@stop