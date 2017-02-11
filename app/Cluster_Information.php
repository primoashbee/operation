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
    
}
