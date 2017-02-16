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
    
    public function totalMembers($id){
        return total_cluster_members($id);
    }
    public function status(){
        $payment_summaries = new \App\Payment_Summary;
        //if($payment_summaries::find($this->id)->collection_date){}
        if(is_null($payment_summaries::find($this->id))){
            return 'Ready for Application';
        }else{
            return 'On-Going Collection';   
        }
        
    }
    public function countMembers(){
        $cluster_members = new \App\Cluster_Members;
        return $cluster_members::where('cluster_id','=',$this->id)->count();
    }
    
}
