<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ratings';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = ['user_id', 'count', 'rating_id', 'rating_type'];

    
    public function rating()
    {
        return $this->morphTo();
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
