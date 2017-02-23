<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(){
        $branches = new \App\Branch_Information;
        $branches = $branches::all();
        return view('pages.login',['branches'=>$branches]);
    }
    public function login(Request $request){
       $accounts = new \App\Accounts;
       $res = $accounts->login($request->except('_token'));
       
       if($res){
            return redirect('Clients');
       }else{
           \Session::set('msg','Invalid Username\Password');
           return redirect()->back();
       }
    }
    public function register(Request $request){

        $rules = [
            'username'=>'unique:accounts,username| required',
            'password'=> 'required | min:8 | confirmed',
            'firstname'=>'required',
            'lastname'=>'required',
            'password_confirmation'=>'required'

        ];
        $msg = [
            'username.unique'=>'Username Already Existing',
            'username.required'=>'Provide Username',
            'password.required'=>'Provid Password',
            'password.min'=>'Minimum Character For Password is Eight (8)',
            'password.confirmation'=>'Password must Match',
            'password_confirm.required'=>'Provide Password Confirmation'   
            ];
        $validator = \Validator::make($request->all(),$rules,$msg);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $hashed_password = \Hash::make($request->password);
        $accounts = new \App\Accounts;
        $accounts->username = $request->username;
        $accounts->password = $hashed_password;
        $accounts->branch_code =1;
        $accounts->is_admin = 1;
        if($accounts->save()){
            \Session::set('msg','Account Created Successful');
            return redirect()->back();
        }


        
    }
}
