<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cluster_Members extends Model
{
    use SoftDeletes;
    protected $table ='cluster_members';
    protected $dates = ['deleted_at'];
    protected $fillable=['client_id','cluster_id'];
    public function name(){
        return $this->belongsTo('App\Client_Information','client_id');
    }
    public function listToAdd($cluster_id){
        $list = \DB::select(
            "SELECT * FROM clients WHERE id NOT IN
             (SELECT client_id FROM cluster_members where cluster_id=".$cluster_id.")"
            );
        $list = new \App\Cluster_Members;
        $list = $list->where('cluster_id','=',$cluster_id)->get();
        return $list;
    }
    public function clusterInformation(){
        return $this->belongsTo('App\Cluster_Information','cluster_id');
    }
  
}
