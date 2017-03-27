<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cluster_Information;
class ClusterController extends Controller
{

    public function index(){
        $cluster = new Cluster_Information();
        $cluster = $cluster::where('branch_id','=',\Auth::user()->branch_code)->paginate(15);
        $branch = new \App\Branch_Information;
        $branches = $branch::all();
        $branch = $branch::paginate(15);

        //dd($branches->where('1','1')->with('clusters'));
        //dd($branch::find(1)->cluster()->first());
        //$branches->where('status','=','1')->with('clusters')->get();
        return view('pages.view-cluster',['information'=>$cluster]);
    }  
    public function preCreateCluster(){
        $branches = new \App\Branch_Information;
        $branches =$branches::all();
        return view('pages.add-cluster',['branches'=>$branches]);
    }
    public function postCreateCluster(Request $request){
        if($request->code != generateClusterCode()){
            $array = array('Code Error');
            return back()->withErrors($array);
        }
        $cluster = new Cluster_Information();
        $cluster = new \App\Cluster_Information;
        $rules = [
            'branch_id'=>'required | exists:branches,id',
            'code'=>'required | unique:clusters,code',
            'pa_lastname'=>'required',
            'pa_firstname'=>'required',
        ];
        $messages = [
            'branch_id.required'=>'Provice branch location',
            'branch_id.exists'=>'Branch should be existing',
            'code.unique'=>'Cluster code existing',
            'pa_lastname.required'=>'Provide loan officer\'s LASTNAME',
            'pa_firstname.required'=>'Provide loan officer\'s FIRSTNAME',
        ];

        $validator = \Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
             return redirect('/Cluster/Create/')
            ->withErrors($validator)
            ->withInput();
        } 

        if($cluster::create($request->all())){
            return redirect('/Cluster/Create')->with('status', 'Cluster Added!');
        }else{
            return redirect('/Cluster/Create')->with('status', 'Cluster Not Saved!');
        } 
        
    }
    public function getInfoById($id){
        $cluster = new Cluster_Information();
        $cluster= $cluster::find($id);
        
        $branches = new \App\Branch_Information;
        $branch_id = $cluster::find(1)->first()->branch_id;
        
        $branch_name = $branches::find($branch_id)->name;
    
        $branches =$branches::all();
        
        return view('pages.update-cluster',['id'=>$id,'branch_info'=>$cluster,'branches'=>$branches,'branch_name'=>$branch_name]);
    }
    public function updateCluster(Request $request,$id){
        $cluster = new \App\Cluster_Information;
        $cluster = $cluster::find($id);
        $code = $cluster->code;
        //d($this->pa('id'));
        $rules = [
            'branch_id'=>'required | exists:branches,id',
            'code'=>'required | unique:clusters,code,'.$id,
            'pa_lastname'=>'required',
            'pa_firstname'=>'required',
        ];        
        $messages = [
            'branch_id.required'=>'Provice branch location',
            'branch_id.exists'=>'Branch should be existing',
            'code.unique'=>'Cluster code existing',
            'pa_lastname.required'=>'Provide loan officer\'s LASTNAME',
            'pa_firstname.required'=>'Provide loan officer\'s FIRSTNAME',
            ];
        $validator = \Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
             return redirect('/Cluster/Update/'.$id)
            ->withErrors($validator)
            ->withInput();
        }
        $input = $request->except('branch','branch_id','code');
        
        if($cluster->update($input)){
            return redirect('/Cluster/Update/'.$id)->with('status','Cluster Updated');
        }

          return redirect('/Cluster/Update/'.$id)->with('status','Sometings Went Wrong');

    }
    public function memberSummary($id){
        $cluster = new \App\Cluster_Information;
        $cluster_information=$cluster::find($id);

        $members= new \App\Cluster_Members;
        
      //  dd($members->listToAdd($id)->all());
        
        $cluster_members = $members::where('cluster_id','=',$id)->paginate(1000);
        
        $clients = new \App\Client_Information;
        //$clients = $clients->where('branch_id','=',\Auth::user()->branch_code);
       //dd(\Auth::user());
        $clients =$clients->hasNoCluster();
        return view('pages.view-cluster-members',['clients_to_add'=>$clients,'members'=>$cluster_members,'cluster_info'=>$cluster_information,'id'=>$id]);
        
    }
    public function preAddToCluster(){
        $client = new \App\Client_Information;
        $clients = $client::where('branch_id','=',\Auth::user()->branch_code)->get();
      
        return response()->json($clients);        
    }
    public function postAddToCluster(Request $request,$id){

        $x = new \App\Cluster_Information;
        if(!$x->find($id)->isAvailable()){
            $status = array('code'=>0,'MSG'=>'Cluster is in active program. Cannot Add Members');
            return back()->with('status',$status);
        }
        if($x->find($id)->sumAfterAddingMember(count($request->client_id)) > 20 ){
            $current = $x->find($id)->sumAfterAddingMember(count($request->client_id)) - count($request->client_id);
            $toAdd = count($request->client_id); 
            $remaining = 20 - $current;
            $total = $current + $toAdd;
              $errors = array('Cannot Add More Members','Cannot Exceed More than 20','Current Members :'.$current,'Remainig Slot: '.$remaining,'For Adding: '.$toAdd,'Total if Added: '.$total);
            return back()->withErrors($errors);
        }

        $cluster = new \App\Cluster_Members;
        $data = array();
        $rules = [
            'cluster_id'=>'required | exists:clusters,id',
            'client_id'=>'required | exists:clients,id'
        ];
        $msg  = [
            'cluster_id.exists'=>'Cluster must be existing',
            'cluster_id.required'=>'Provide cluster',
            'client_id.required'=>'Select client first'
            ];
        $validator = \Validator::make($request->all(),$rules,$msg);

        if($validator->fails()){
            return redirect('/Cluster/'.$id.'/Members')
            ->withErrors($validator)
            ->withInput();
            
        }
        $msg=array();
        $ctr = 0;
        foreach($request->client_id as $x){
            $result = \DB::table('cluster_members')
            ->where('client_id', '=',$x)
            ->exists();
                if($result){
                    $msg[]=array('id'=>$x);
                }else{
                    $cluster::firstOrCreate(['cluster_id'=>$id,'client_id'=>$x]);
                    $ctr++;
                }

        }
            if($ctr==0){
                $status = array('code'=>0,'MSG'=>'Client(s) selected belongs to another cluster');
            }else if($ctr==count($x)){
                $status =array('code'=>1,'MSG'=>'Clients Added to Cluster '.$ctr.'/'.count($request->client_id));
            }else{
                $status =array('code'=>1,'MSG'=>'Clients Added to Cluster '.$ctr.'/'.count($request->client_id));
            }
            return redirect('/Cluster/'.$id.'/Members')->with('status',$status);
        
        
    
        
        
    }
    public function removeToCluster($cluster_id,$client_id){
        $x = new \App\Cluster_Information;
        if(!$x->find($cluster_id)->isAvailable()){
            $status = array('code'=>0,'MSG'=>'Cluster is in active program. Cannot remove cluster member/s');
            return back()->with('status',$status);
        }
        $clusters = new \App\Cluster_Members;
        $delete_id = $clusters->where('cluster_id','=',$cluster_id)->where('client_id','=',$client_id)->get();
        $delete_id = $delete_id->first()->id;
        $member = $clusters::find($delete_id);
        //dd($member);
        if($member->delete()){
            $status = array('code'=>1,'MSG'=>'Client Removed From Cluster');
        }else{
            $status = array('code'=>0,'MSG'=>'Something went wrong');
       
        }
        return back()->with('status',$status);
    }
}

