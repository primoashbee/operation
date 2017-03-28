<?php

namespace App\Http\Controllers;
use Laravel\Scout\Searchable;
use Illuminate\Http\Request;
use Validator;
use App\Client_Information;
class ClientController extends Controller
{
    use Searchable;
    public $table;
    public function index(){
        $client = new Client_Information();

        $filter = \Request::get('filter');
        $key = \Request::get('search');
        
        if($filter !=NULL && $key !=NULL){
            if($filter=="sex"){
                $client=$client::where('branch_id','=',\Auth::user()->branch_code)->where($filter,'=',$key)->orderBy('id','asc')->paginate(50);        
            }else{
                $client=$client::where('branch_id','=',\Auth::user()->branch_code)->where($filter,'like','%'.$key.'%')->orderBy('id','asc')->paginate(50);        
            }
        }else{
            $client=$client::where('branch_id','=',\Auth::user()->branch_code)->orderBy('id','asc')->paginate(100);
        }
        return view('pages.view-all-client',['clients'=>$client]);      
    }    
    public function preCreateClient(){
       
        return view('pages.add-client');      
    }    
    public function postCreateClient(Request $request){
       $client = new Client_Information();
       $request->request->add(['branch_id'=>whoIsLoggedIn()->branch_code]);
       $request->request->add(['age'=>getAge($request->birthday)]);
         $clients = new \App\Client_Information;
        if($client::where('lastname','like','%'.$request->lastname.'%')->where('firstname','like','%'.$request->firstname.'%')->where('birthday','like','%'.$request->birthday.'%')->count() > 0){
            $client = $client::where('lastname','like','%'.$request->lastname.'%')->where('firstname','like','%'.$request->firstname.'%')->where('birthday','like','%'.$request->birthday.'%')->get();
            $msg = "Client already registered at ".$client->first()->branch()->name." ";;

            return redirect('/Clients/Create')
            ->withErrors(['Record Existing',$msg])
            ->withInput();
        }
       $rules =[
            'lastname'=>'required',
            'firstname'=>'required',
            'middlename'=>'required',
            'client_code'=>'required|unique:clients',
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
            'branch_id'=>'required'
        ];

        $messages =[
            'lastname.required' => 'Please enter lastname',
            'firstname.required'=>'Please enter firstname',
            'middlename.required'=>'Please enter middlename',
            'client_code.unique'=>'Existing Client Code',
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
            'branch_id.required'=>'Authentication Error'
        ];
        
        $clients = new \App\Client_Information;
        if($client::where('lastname','like','%'.$request->lastname.'%')->where('firstname','like','%'.$request->firstname.'%')->where('birthday','like','%'.$request->birthday.'%')->count() > 0){
            $client = $client::where('lastname','like','%'.$request->lastname.'%')->where('firstname','like','%'.$request->firstname.'%')->where('birthday','like','%'.$request->birthday.'%')->get();
            dd($client);
            return redirect('/Clients/Create')
            ->withErrors(['Record Existing','Se'])
            ->withInput();
        }
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
      
        //$file->move($path,$file);
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
        $path = '\photo\clients\\';
        $path = public_path().$path;
        $filename  = $client->client_code.'.jpg';
        $input = $request->all();
        if($request->hasFile('img_src')){
            $file = $request->file('img_src')->move($path,$filename);
            $new_input = $request->except('img_src');
            $input = array_add($new_input,'img_src','\photo\clients\\'.$filename); 
        
        }
        $client->update($input);
        $client->income->update($request->all());
        $client->business->update($request->all());
        
        
          return redirect('/Clients/Update/'.$id)
                    ->with('status','Client Updated');
        
    }
   
    public function postCredit(Request $request, $id){
        $limits=new \App\Credit_Limit;

    }
    public function checkClient(Request $request){
        $client = new Client_Information();
        $client = $client->where('lastname','=',$request->lastname)->where('firstname','=',$request->firstname)->where('birthday','=',$request->birthday);
        if($client->count() > 0){
            $msg = 'Client Already Existing at '.$client->first()->branch()->name.' branch';
            return response()->json(['code'=>404,'msg'=>$msg]);
        }else{
        
            return response()->json(['code'=>200,'msg'=>'New Client']);
            
        }
    }
}
