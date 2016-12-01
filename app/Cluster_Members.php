<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cluster_Members extends Model
{
    protected $table ='cluster_members';
    public function name(){
        return $this->belongsTo('App\Client_Information','client_id');
    }
    
  
}
