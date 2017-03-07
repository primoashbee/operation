<?php

namespace App\Http\Controllers;
use Laravel\Scout\Searchable;
use Illuminate\Http\Request;
use Validator;
use App\Client_Information;
class ClientController extends Controller
{
    use Searchable;
    public function index(){
        $client = new Client_Information();;
        $client=$client::paginate(15);
        return view('pages.view-all-client',['clients'=>$client]);      
    }    
    public function preCreateClient(){
       
        return view('pages.add-client');      
    }    
    public function postCreateClient(Request $request){
       $client = new Client_Information();
      // dd($request->all());
        $rules =[
            'lastname'=>'required',
            'firstname'=>'required',
            'middlename'=>'required',
            'TIN'=>'numeric',
            'nickname'=>'required',
            'birthday'=>'required',
            'home_address'=>'required',
            'home_year'=>'required',
            'mobile_number'=>'required',
            'civil_status'=>'required',
            'sex'=>'required',
            'house_type'=>'required',
            'member_lastname'=>'required',
            'member_firstname'=>'required',
            'member_age'=>'required|numeric',
            'member_relationship'=>'required',
            'member_occupation'=>'required',
            'member_monthly_income'=>'required|numeric',
            'member_address'=>'required',
            'main_business'=>'required',
            'main_business_years'=>'required',

        ];

        $messages =[
            'lastname.required' => 'Please enter lastname',
            'firstname.required'=>'Please enter firstname',
            'middlename.required'=>'Please enter middlename',
            'nickname.required'=>'Please enter nickname',
            'birthday.required'=>'Please enter birthday',
            'home_address.required'=>'Please enter Address of Client',
            'home_year.required'=>'Please enter Address Year',
            'mobile.required'=>'Please enter mobile number',
            'mobile.numeric'=>'Mobile number should be numeric',
            'civil_status.required'=>'Please select civil status',
            'sex.required'=>'Please select sex',
            'house_type.required'=>'Please select house rented',
            'member_lastname.required'=>'Please Enter household member lastname',
            'member_firstname.required'=>'Please Enter household member firstname',
            'member_age.required'=>'Please Enter household member age',
            'member_relationship.required'=>'Please Enter household member relationship to client',
            'member_occupation.required'=>'Please Enter household members occupation',
            'member_monthly_income.required'=>'Please Enter household members monthly income',
            'member_monthly_income.numeric'=>'Household members monthly income should be numeric',
            'member_address.required'=>'Please Enter household members address',
            'main_business.required'=>'Please Enter Main business',
            'main_business_years.required'=>'Please Enter Business Years',
        ];
        
        $validator =Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return redirect('/Clients/Create')
            ->withErrors($validator)
            ->withInput();
        }
       $client=$client::create($request->all());
       $client_id=$client->id;
    
       $values = array_add($request->all(), 'client_id', $client_id);
       
       $client->business()->create($values);
       $client->income()->create($values);
       return redirect('/Clients/Create')
            ->with('status','Client Succesfuly Added');
             
    }   
    public function getInfoById($id){
        $client = new Client_Information();
        $client = $client::find($id);
        return view('pages.update-client',['information'=>$client]);

    } 
    public function updateClient(Request $request,$id){
        $rules =[
           'lastname'=>'required',
           'firstname'=>'required',
           'middlename'=>'required',
           'TIN'=>'numeric',
           'nickname'=>'required',
           'birthday'=>'required',
           'home_address'=>'required',
           'home_year'=>'required',
           'mobile_number'=>'required',
           'civil_status'=>'required',
           'sex'=>'required',
           'house_type'=>'required',
           'member_lastname'=>'required',
           'member_firstname'=>'required',
           'member_age'=>'required|numeric',
           'member_relationship'=>'required',
           'member_occupation'=>'required',
           'member_monthly_income'=>'required|numeric',
           'member_address'=>'required',
           'main_business'=>'required',
           'main_business_years'=>'required',

        ];
        $messages =[
           'lastname.required' => 'Please enter lastname',
           'firstname.required'=>'Please enter firstname',
           'middlename.required'=>'Please enter middlename',
           'nickname.required'=>'Please enter nickname',
           'birthday.required'=>'Please enter birthday',
           'home_address.required'=>'Please enter Address of Client',
           'home_year.required'=>'Please enter Address Year',
           'mobile.required'=>'Please enter mobile number',
           'mobile.numeric'=>'Mobile number should be numeric',
           'civil_status.required'=>'Please select civil status',
           'sex.required'=>'Please select sex',
           'house_type.required'=>'Please select house rented',
           'member_lastname.required'=>'Please Enter household member lastname',
           'member_firstname.required'=>'Please Enter household member firstname',
           'member_age.required'=>'Please Enter household member age',
           'member_relationship.required'=>'Please Enter household member relationship to client',
           'member_occupation.required'=>'Please Enter household members occupation',
           'member_monthly_income.required'=>'Please Enter household members monthly income',
           'member_monthly_income.numeric'=>'Household members monthly income should be numeric',
           'member_address.required'=>'Please Enter household members address',
           'main_business.required'=>'Please Enter Main business',
           'main_business_years.required'=>'Please Enter Business Years',
        ];
        $validator =Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return redirect('/Clients/Update/'.$id)
            ->withErrors($validator)
            ->withInput();
        }
        $client = new Client_Information();
        $client= $client::find($id);
        $client->update($request->all());
        $client->income->update($request->all());
        $client->business->update($request->all());
          return redirect('/Clients/Update/'.$id)
                    ->with('status','Client Updated');
        
    }
   
    public function postCredit(Request $request, $id){
        $limits=new \App\Credit_Limit;

    }
}
