<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client_Information extends Model
{
    use SoftDeletes;
    protected $table = 'clients';
    protected $dates = ['deleted_at'];
    public $fillable=['client_code','lastname','firstname','middlename','branch_id','suffix','nickname','mother_name','spouse_name','TIN','birthday','age','home_address','home_year','business_address','business_year','mobile_number','telephone_number','civil_status','sex','education','house_type','img_src'];    
    

    public function business(){
        return $this->hasOne('App\Client_Business','client_id');
    }
    public function marami(){
        return $this->hasMany('App\Client_Business','client_id');
    }
    public function income(){
        return $this->hasOne('App\Client_Income','client_id');
    }
   
    public function cluster(){
        return $this->hasOne('App\Cluster_Members','client_id');
    }
    public function loans(){
        return $this->hasMany('App\Loans','client_id','id');
    }
    public function hasNoCluster(){
        //return $this->leftJoin('cluster_members as c2','c2.client_id','=','clients.id')->whereNotNull('c2.client_id')->toSql();
        /*return \DB::table('clients')
        ->whereNotIn('clients.id',
        function($sql){
             $sql->select('cluster_members.client_id')->from('cluster_members')
            ->whereRaw('clients.branch_id ='.\Auth::user()->branch_code)
            ->whereRaw('clients.id = cluster_members.client_id');
        })->get();
        */
        $ci = new \App\Client_Information;
        $ci = $ci::where('branch_id','=',\Auth::user()->branch_code);
        $cl = new \App\Cluster_Members;
        $cl = $cl::all();
        $ids = array();
        foreach($cl as $x){
            $ids[] = $x->client_id;
        }   
        return $ci->whereNotIn('id',$ids)->get();
    }

    
    public function branch(){
        $branch = new \App\Branch_Information;
        return $branch::find($this->branch_id);
    }
    public function getAge(){
        return \Carbon\Carbon::parse($this->birthday)->age;
    }
}