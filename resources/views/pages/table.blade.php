@extends('layouts.viewing-layout')
@section('content')
<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnClose"><span aria-hidden="true">× Close Page</span></button>
    <table class="table table-condensed">
        <thead>
            <th>Week #</th>
            <th>Principal</th>
            <th>Interest</th>
            <th>P+I</th>
            
            <th>Principal Balance</th>
            <th>Interest Balance</th>
        </thead>
        <h1 class="text-center"> Amortization Schedule </h1>
        <tbody>
            </tr>
        @foreach($data->table as $x)
            <tr>
                <td>{{$x->week}}</td>
                <td>{{pesos($x->principal)}}</td>
                <td>{{pesos($x->interest)}}</td>
                <td>{{pesos($x->interest + $x->principal)}}</td>
              
                <td>{{pesos($x->p_balance)}}</td>
                <td>{{pesos($x->i_balance)}}</td>
            </tr>
            
        @endforeach
            <tr>
                <td></td>
                <td>{{pesos($data->t_principal)}}</td>
                <td>{{pesos($data->t_interest)}}</td>
                 <td></td>
                 <td></td>
                 <td></td>
            </tr>
        </tbody>
    </table>
@stop
@section('page-script')
<script>
$('#btnClose').click(function(){
    window.top.close()
})
</script>
@stop