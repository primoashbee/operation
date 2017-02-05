@extends('layouts.admin-layout')

@section('content')
   
<div style="padding-top:25px">
    <form action ="{{url()->current()}}" method = "POST" enctype="multipart/form-data">
    
    {{csrf_field()}}
    <h1>Upload File</h1>

   
          <input type="file" class="filestyle" name = "fileUpload" data-buttonName="btn-primary">
          <input type="submit" class="btn btn-default">
    </form>
   
</div>
@stop
@section('scripts')
<script>
$(function(){
    $(":file").filestyle({buttonName: "btn-primary"});
})
</script>
@stop
