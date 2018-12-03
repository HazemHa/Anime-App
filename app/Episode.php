<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'episodes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['group_id','number', 'description'];

    public function group()
    {
        return $this->belongsTo('App\Group','group_id','id');
    }

    /**
     * Get all of the Episode's comments,favorites and likes.
     */
    public function servers(){
      return $this->hasMany('App\Server', 'episode_id', 'id');
    }
   
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commenttable');
    }
    public function favorites()
    {
        return $this->morphMany('App\Favorite', 'favoritetable');
    }
    public function likes()
    {
        return $this->morphMany('App\Like', 'likestable');
    }

    public function rating()
    {
        return $this->morphMany('App\Rating', 'rating');
    }
}
