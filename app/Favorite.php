<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'favorites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'favoritetable_id', 'favoritetable_type'];


    public function favoritetable()
    {
        return $this->morphTo();
    }
    public function users(){
        return $this->belongsTo('App\User','user_id','id');
    }


}
