@extends('layouts.admin-layout')
@section('content')

    <div style="padding-top:100px"></div>
    <table class="table table-condensed">
        <thead>
            <th>Week #</th>
            <th>Principal</th>
            <th>Interest</th>
            <th>P+I</th>
            
            <th>Principal Balance</th>
            <th>Interest Balance</th>
        </thead>
        <h1> {{$data->weekly_amort}} </h1>
        <tbody>
            <tr>
                <td> 0 </td>
                <td> {{ zero_peso()}} </td>
                <td> {{ zero_peso()}} </td>
                <td> {{ zero_peso()}} </td>
               
                
                <td> {{ pesos($data->loan) }} </td>
                <td> {{ pesos($data->interest_value) }} </td>
                
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

</script>
@stop