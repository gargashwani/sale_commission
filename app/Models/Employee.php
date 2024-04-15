<?php

namespace App\Models;

use App\Models\Sale;
use App\Models\User;
use App\Models\Saletype;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use Notifiable;
     use SoftDeletes;
    //because all the fields are guarded by default, so we are making them free from guard
     protected $guarded = [];
     protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'status', 'city', 'state', 'address', 'zip', 'phone', 'bgcolor', 'bordercolor', 'commission'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function sales()
    {
        return $this->hasMany('App\Models\Sale');
    }

    public function saletypes(){
        return $this->hasMany('App\Models\Saletype');
    }
}
