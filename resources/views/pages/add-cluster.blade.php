@extends('layouts.admin-layout')
@section('content')
<form method="post" id="myForm" action="/Cluster/Create">
    <div style="margin-top:30px"></div>
    

    <div id="step-1">
        
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Cluster Information</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
            
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
                <div class="alert alert-success">
                    <h1> {{ session('status') }} </h1>
                </div>
            @endif
        
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8 col-lg-8">
                    <div class="form-group">
                    <label for="branch">Branch</label>
                    <input type="text" class="form-control" id="branch" name ="branch" value ="{{ getBranchById(whoIsLoggedIn()->branch_code)->name }}" readonly placeholder="Branch Name" >
                    <input type="hidden"  id="branch_id" name ="branch_id" value ="{{\whoIsLoggedIn()->branch_code}}"  >
                    </div>
                </div>
                
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" id="code" name ="code" value ="{{generateClusterCode()}}" placeholder="Cluster code"  readonly>
                    </div>
                </div>
                
            </div>

            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                    <label for="pa_lastname">Loan Officer's Lastname</label>
                    <input type="text" class="form-control" id="pa_lastname" name ="pa_lastname" value ="{{ old('pa_lastname')}}" placeholder="lastname" >
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                    <label for="pa_firstname">Loan Officer's Firstname</label>
                    <input type="text" class="form-control" id="pa_firstname" name ="pa_firstname" value ="{{ old('pa_firstname')}}" placeholder="firstname" >
                    </div>
                </div> 
                
            </div>
            <input type="submit" class="btn btn-submit btn-default"> 
    </div>
        
    
</form> 
@stop
@section('page-script')
<script>
var curr = 0
 var branchTags = []
$(function(){
 
  @foreach($branches as $x)
    branchTags.push({ value:'{{$x->id}}',label:'{{$x->name}}' })
  @endforeach
  
  $('#branch').autocomplete({
      source:branchTags,
      select:function(event,ui){
          event.preventDefault()
          $('#branch_id').val((ui.item.value))
          $('#branch').val((ui.item.label))
      }
  })
})

</script>
@stop