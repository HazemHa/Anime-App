<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupType extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_type';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = ['name', 'description'];

     public function items(){
         return $this->hasMany('App\GroupType', 'group_type_id','id');
     }
}
