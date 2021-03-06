@extends('layouts.admin-layout')
@section('content')
<form method="post" id="myForm">
    <div style="margin-top:30px"></div>
    

    <div id="step-1">
      
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Personal Information</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
            
        <div>
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
       
        <div class="alert alert-danger" id="ajaxAlert" style="display:none;">
            <strong>Alert!</strong> <span id="ajaxMsg"></span>
        </div>
                    {{ csrf_field() }}
            <div class="row">
            
             <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                    <label for="client_code">Client Code</label>
                    
                    <input type="text" class="form-control" id="client_code" value ="{{generateClientCode()}}" name ="client_code" readonly>
                    </div>
            </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                    <label for="lastname">Last Name</label>
                      
                    <input type="text" class="form-control unique" id="lastname" name ="lastname" value ="{{ old('lastname')}}" >
                    </div>
                </div>
                
            
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                    <label for="firstname">Firstname Name</label>
                    <input type="text" class="form-control unique" id="firstname" name ="firstname" value ="{{ old('firstname')}}" >
                    </div>
                </div>
                
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">                
                    <label for="middlename">Middle Name</label>
                    <input type="text" class="form-control" id="middlename" name ="middlename" value ="{{ old('middlename')}}" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                    <label for="birthday">Birthday </label>
                    <input type="date" class="form-control unique" id="birthday" name ="birthday" value ="{{ old('birthday')}}">
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                    <label for="suffix">SUFFIX (ex. <i>JR, I, II, III</i>)</label>
                    <input type="text" class="form-control" id="suffix" name ="suffix" value ="{{ old('suffix')}}">
                    </div>
                </div>
                
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                    <label for="nickname">Nickname</label>
                    <input type="text" class="form-control" id="nickname" name ="nickname"  value ="{{ old('nickname')}}" >
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                    <label for="spouse_name">Spouse Name</label>
                    <input type="text" class="form-control" id="spouse_name" name ="spouse_name" value ="{{ old('spouse_name')}}">
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                    <label for="tin">TIN </label>
                    <input type="text" class="form-control" id="TIN" name ="TIN" value ="{{ old('TIN')}}">
                    </div>
                </div>
               <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                    <label for="mother_name">Mother Maiden Name</label>
                    <input type="text" class="form-control" id="mother_name" name ="mother_name" value ="{{ old('mother_name')}}">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-8 col-lg-8">
                    <div class="form-group">
                    <label for="home_address">Home Address</label>
                    <input type="text" class="form-control" id="home_address" name ="home_address" value ="{{ old('home_address')}}" >
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                    <label for="home_year">Home Address Corresponding Year </label>
                    <input type="text" class="form-control" id="home_year" name ="home_year"  value ="{{ old('home_year')}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-lg-8">
                    <div class="form-group">
                    <label for="business_address">Business Address</label>
                    <input type="text" class="form-control" id="business_address" name ="business_address" value ="{{ old('business_address')}}" >
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                    <label for="business_year">Business Address Corresponding Year </label>
                    <input type="text" class="form-control" id="business_year" name ="business_year" value ="{{ old('business_year')}}" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                    <label for="mobile_number">Mobile Number (ex.<i>0923-456-7890</i>)</label>
                    <input type="text" class="form-control" id="mobile_number" name ="mobile_number" value ="{{ old('mobile_number')}}" >
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                    <label for="telephone_number">Telephone # (ex.<i>(045)-222-1123</i>) </label>
                    <input type="text" class="form-control" id="telephone_number" name ="telephone_number" value ="{{ old('telephone_number')}}">
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                    <label for="civil_status">Civil Status </label>
                    <select type="text" class="form-control" id="civil_status" name ="civil_status" >
                        <option value="{{old('civil_status')}}">{{ old('lastname') }}</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Separated">Separated</option>
                        <option value="Widow">Widow</option>
                    </select>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                    <label for="sex">Sex</label>
                    <select type="text" class="form-control" id="sex" name ="sex" >
                        <option value="{{old('sex')}}">{{ old('sex') }}</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                    <label for="education">Highest Educational Attainment</label>
                    <select type="text" class="form-control" id="education" name ="education">
                        <option value="{{old('education')}}">{{ old('education') }}</option>
                        <option value="Male">College</option>
                        <option value="Vocational">Vocational</option>
                        <option value="High School">High School</option>
                        <option value="Elementary">Elementary</option>
                        <option value="None">None</option>
                    </select>
                    
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                        <label for="house_type">House</label>
                    <select type="text" class="form-control" id="house_type" name ="house_type" >
                            <option value="{{old('house_type')}}">{{ old('house_type') }}</option>
                            <option value="Owned">Owned</option>
                            <option value="Rented">Rented</option>
                        </select>
                    </div>
                
                </div>
            </div>
        </div>
        
    </div>
    <div id="step-2">
        
        <h1 style="margin-top:-20px"     > &nbsp;</h1>
        <h1 > Household Composition and Source of Income </h1>
        <hr>
        <br>
            <div class="row">
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                    <label for="member_lastname">Member Last Name</label>
                    <input type="text" class="form-control" id="member_lastname" name ="member_lastname" value ="{{old('member_lastname')}}" >
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                    <label for="member_firstname">Member First Name</label>
                    <input type="text" class="form-control" id="member_firstname" name ="member_firstname"  value ="{{old('member_firstname')}}" >
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                    <label for="member_middlename">Member Middle Name</label>
                    <input type="text" class="form-control" id="member_middlename" name ="member_middlename"  value ="{{old('member_middlename')}}" >
                    </div>
                </div> 
                <div class="col-md-1 col-lg-1">
                    <div class="form-group">
                    <label for="member_age">Age</label>
                    <input type="number" class="form-control" id="member_age" name ="member_age"  value ="{{old('member_age')}}" style="width:70px" >
                    </div>
                </div> 
                <div class="col-md-2 col-lg-2">
                    <div class="form-group">
                    <label for="member_suffix">SUFFIX</label>
                    <input type="text" class="form-control" id="member_suffix" name ="member_suffix"  value ="{{old('member_suffix')}}" style="width:50px" >
                    </div>
                </div>
            </div>
            <div class="row">
              
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                    <label for="member_relationship">Relationship to Client</label>
                    <input type="text" class="form-control" id="member_relationship" name ="member_relationship"  value ="{{old('member_relationship')}}" >
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                    <label for="member_occupation">Occupation</label>
                    <input type="text" class="form-control" id="member_occupation" name ="member_occupation"  value ="{{old('member_occupation')}}">
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                    <label for="member_occupation_years">Years</label>
                    <input type="number" class="form-control" id="member_occupation_years" name ="member_occupation_years"  value ="{{old('member_occupation_years')}}"style="width:70px">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                    <label for="member_monthly_income">Monthly Income (Php)</label>
                    <input type="number" class="form-control" id="member_monthly_income" name ="member_monthly_income"  value ="{{old('member_monthly_income')}}">
                    </div>
                </div>
                <div class="col-md-9 col-lg-9">
                    <div class="form-group">
                    <label for="member_address">Address</label>
                    <textarea id="member_address" name = "member_address"  value ="{{old('member_address')}}" class="form-control" width="3" row="3" style="margin: 0px -485.556px 0px 0px; width: 759px; height: 75px;" >{{old('member_address')}}</textarea>
                  
                    </div>
                </div>  
            </div>
        
        
    </div>
    <div id="step-3">
        
        <h1 style="margin-top:-20px"> &nbsp;</h1>
        <h1 > Business Activities </h1>
        <hr>
       
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="main_business">Main Business</label>
                        <input type="text" class="form-control" id="main_business" name="main_business"  value ="{{old('main_business')}}" >
                    </div>
                </div>
                <div class="col-md-2 col-lg-2">
                    <div class="form-group">
                        <label for="main_business_years">Years in Business</label>
                        <input type="text" class="form-control" id="main_business_years" name="main_business_years"  value ="{{old('main_business_years')}}" >
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <label for="secondary_business">Secondary Business</label>
                        <input type="text" class="form-control" id="secondary_business" name ="secondary_business"  value ="{{old('secondary_business')}}">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="number_of_paid_employees"># of Paid Employess</label>
                        <input type="text" class="form-control" id="number_of_paid_employees" name ="number_of_paid_employees" value ="{{old('number_of_paid_employees')}}">
                    </div>
                </div> 
                <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="business_place_characteristic">Workplace</label>
                            <select class="form-control" id="business_place_characteristic" name ="business_place_characteristic"  >
                                <option value="{{old('business_place_characteristic')}}">{{ old('business_place_characteristic') }} <option>
                                <option value="Owned">Owned</option>
                                <option value="Rented">Rented</option>
                                <option value="Home-Based">Home-Based</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Ambulant">Ambulant</option>
                            </select>
                        </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-lg-offset-5 col-md-offset-5">
                    <input type="submit" value="submit" name="submit" class="btn btn-success btn-lg">
                </div>
            </div>
        
            
    </div>
   
</form> 
@stop
@section('page-script')
<script>
var ctr = 0
$(function(){
    $('.unique').change(function(){
        ctr = 0 
        $.each($('.unique'),function(){
            if($(this).val()!=""){
                ctr = ctr + 1
            }
        })
        if(ctr==3){
            $.ajax({
                url:'/Api/CheckClient',
                type:'POST',
                data:{lastname:$('#lastname').val(),firstname:$('#firstname').val(),birthday:$('#birthday').val()},
                dataType:'JSON',
                success:function(data){
                    if(data.code == 200){
                        $('#ajaxAlert').hide()
                    }else{
                        $('#ajaxAlert').show()
                    }
                    $('#ajaxMsg').html(data.msg)
                }


                
            })
        }
    })
})
</script>
@stop