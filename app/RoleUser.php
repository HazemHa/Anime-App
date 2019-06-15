<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = ['name', 'description'];

     public function users(){
         return $this->hasMany('App\User','role_id','id');
     }
}
