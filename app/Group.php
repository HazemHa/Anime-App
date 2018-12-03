<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'groups';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['writtenBy', 'group_type_id','name','description','image'];

    public function episodes(){
        return $this->hasMany('App\Episode','id', 'group_id');
    }
    public function uesrs(){
        return $this->belongsTo('App\User', 'writtenBy','id');
    }
    public function groupName(){
    return $this->belongsTo('App\GroupType', 'group_type_id');
    }
    /**
     * Get all of the Group's comments,favorites and likes.
     */
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
    public function ratings()
    {
        return $this->morphMany('App\Rating', 'ratingtable');
    }
}
