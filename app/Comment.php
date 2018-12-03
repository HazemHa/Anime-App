<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = ['user_id','name','body', 'commenttable_id', 'commenttable_type'];

    public function commenttable()
    {
        return $this->morphTo();
    }
    
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
