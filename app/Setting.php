<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = ['key','value'];
}
