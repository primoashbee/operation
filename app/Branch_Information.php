<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Branch_Information extends Model
{
    //use Softdeletes;
    protected $table ='branches';
    public function cluster(){
        return $this->hasMany('App\Cluster_Information','branch_id');
    }
}
