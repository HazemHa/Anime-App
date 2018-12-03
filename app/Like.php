<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'likes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'likestable_id', 'likestable_type'];

    public function likestable()
    {
        return $this->morphTo();
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
   
    

   
}
