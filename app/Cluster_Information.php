<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cluster_Information extends Model
{
    protected $table ='clusters';
    protected $fillable=['code','branch_id','region','pa_lastname','pa_firstname'];
    
    public function branch(){
        return $this->belongsTo('App\Branch_Information','branch_id','id');
    }
    public function members(){
        return $this->hasMany('App\Cluster_Members','cluster_id');
    }
    public function sumAfterAddingMember($count){
        //check if adding will reach beyond 20 -> maximum cluster sizeof
        $x = new \App\Cluster_Members;
        return ($x::where('cluster_id','=',$this->id)->count()  + $count);

    }
    public function totalMembers($id){
        return total_cluster_members($id);
    }
    public function status(){
        $di = new \App\Disbursement_Information;
        //if($payment_summaries::find($this->id)->collection_date){}
        if($di::where('cluster_id','=',$this->id)->where('status','=','on-going')->count() > 0){
            return 'On-Going Collection';   
        }else{
            return 'Ready for Application';

        }
        
    }
    public function isAvailable(){
        if($this->status()=="Ready for Application"){
            return true;
        }
        return false;
        
    }
    public function countMembers(){
        $cluster_members = new \App\Cluster_Members;
        return $cluster_members::where('cluster_id','=',$this->id)->count();
    }
    
}
