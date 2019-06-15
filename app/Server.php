<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'servers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = ['episode_id', 'server_name', 'episode_link', 'server_type'];
     
    public function episode()
    {
        return $this->belongsTo('App\Episode','episode_id','id');
    }
}
